<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Armada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArmadaController extends Controller
{
    public function index()
    {
        // Load related counts so UI can make safe decisions (disable delete if related data exists)
        $armadas = Armada::withCount(['trackings', 'services'])->latest()->get();
        return view('admin.armada.index', compact('armadas'));
    }

    public function create()
    {
        return view('admin.armada.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_polisi' => 'required|unique:armadas,nomor_polisi',
            'jenis_kendaraan' => 'required',
            'merk' => 'required',
            'kapasitas_muatan' => 'required|numeric|min:0',
            'tahun_pembuatan' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'required|in:aktif,tidak_aktif,maintenance',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable',
        ]);

        $data = $request->all();
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('armada', 'public');
        }

        $armada = Armada::create($data);

        // Kirim notifikasi kepada semua Super Admin tentang armada baru
        try {
            $recipients = \App\Models\User::whereHas('roles', function($q){ $q->where('name', 'Super Admin'); })->get();
            if ($recipients->isNotEmpty()) {
                \Illuminate\Support\Facades\Notification::send($recipients, new \App\Notifications\GenericNotice(
                    'Armada Baru',
                    "Armada dengan nomor polisi {$armada->nomor_polisi} telah ditambahkan oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            // Jangan ganggu UX jika notifikasi gagal — log saja
            \Log::error('Gagal mengirim notifikasi armada: ' . $e->getMessage());
        }

        return redirect()->route('admin.armada.index')->with('success', 'Armada berhasil ditambahkan');
    }

    public function show(Armada $armada)
    {
        $armada->load(['trackings', 'services']);
        return view('admin.armada.show', compact('armada'));
    }

    public function edit(Armada $armada)
    {
        return view('admin.armada.edit', compact('armada'));
    }

    public function update(Request $request, Armada $armada)
    {
        $request->validate([
            'nomor_polisi' => 'required|unique:armadas,nomor_polisi,' . $armada->id_armada . ',id_armada',
            'jenis_kendaraan' => 'required',
            'merk' => 'required',
            'kapasitas_muatan' => 'required|numeric|min:0',
            'tahun_pembuatan' => 'required|integer|min:1900|max:' . (date('Y') + 1),
            'status' => 'required|in:aktif,tidak_aktif,maintenance',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'catatan' => 'nullable',
        ]);

        $data = $request->all();
        if ($request->hasFile('foto')) {
            if ($armada->foto) {
                Storage::disk('public')->delete($armada->foto);
            }
            $data['foto'] = $request->file('foto')->store('armada', 'public');
        }

        $armada->update($data);

        try {
            $recipients = \App\Models\User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                \Illuminate\Support\Facades\Notification::send($recipients, new \App\Notifications\GenericNotice(
                    'Armada Diperbarui',
                    "Armada dengan nomor polisi {$armada->nomor_polisi} diperbarui oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi update armada: ' . $e->getMessage());
        }

        return redirect()->route('admin.armada.index')->with('success', 'Armada berhasil diperbarui');
    }

    public function destroy(Armada $armada)
    {
        // Prevent deletion only if there are related active pengiriman (trackings) or services
        // Allow deletion if all related pengiriman are completed ('selesai') or cancelled ('batal')
        $hasActiveTrackings = $armada->trackings()->whereNotIn('status_pengiriman', ['selesai','batal'])->exists();
        if ($hasActiveTrackings || $armada->services()->exists()) {
            return redirect()->route('admin.armada.index')
                ->with('error', 'Armada tidak dapat dihapus karena terdapat pengiriman yang masih aktif atau riwayat service terkait. Selesaikan atau hapus pengiriman terkait terlebih dahulu.');
        }

        if ($armada->foto) {
            Storage::disk('public')->delete($armada->foto);
        }

        $nomor = $armada->nomor_polisi;
        $armada->delete();

        try {
            $recipients = \App\Models\User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                \Illuminate\Support\Facades\Notification::send($recipients, new \App\Notifications\GenericNotice(
                    'Armada Dihapus',
                    "Armada dengan nomor polisi {$nomor} dihapus oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi hapus armada: ' . $e->getMessage());
        }

        return redirect()->route('admin.armada.index')->with('success', 'Armada berhasil dihapus');
    }
}