<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gudang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\GenericNotice;

class GudangController extends Controller
{
    public function index()
    {
        $gudangs = Gudang::latest()->get();
        return view('admin.gudang.index', compact('gudangs'));
    }

    public function create()
    {
        return view('admin.gudang.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_gudang' => 'required',
            'alamat' => 'required',
            'kapasitas' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,tidak_aktif,penuh,maintenance,over_capacity',
            'tarif_per_kg' => 'required|numeric|min:0',
            'diskon_persen' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable',
        ]);

        $gudang = Gudang::create($request->all());

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Gudang Baru',
                    "Gudang {$gudang->nama_gudang} dibuat oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi gudang: ' . $e->getMessage());
        }

        return redirect()->route('admin.gudang.index')->with('success', 'Gudang berhasil ditambahkan');
    }

    public function show(Gudang $gudang)
    {
        return view('admin.gudang.show', compact('gudang'));
    }

    public function edit(Gudang $gudang)
    {
        return view('admin.gudang.edit', compact('gudang'));
    }

    public function update(Request $request, Gudang $gudang)
    {
        $request->validate([
            'nama_gudang' => 'required',
            'alamat' => 'required',
            'kapasitas' => 'required|numeric|min:0',
            'status' => 'required|in:aktif,tidak_aktif,penuh,maintenance,over_capacity',
            'tarif_per_kg' => 'required|numeric|min:0',
            'diskon_persen' => 'required|numeric|min:0|max:100',
            'catatan' => 'nullable',
        ]);

        $gudang->update($request->all());

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Gudang Diperbarui',
                    "Gudang {$gudang->nama_gudang} diperbarui oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi update gudang: ' . $e->getMessage());
        }

        return redirect()->route('admin.gudang.index')->with('success', 'Gudang berhasil diperbarui');
    }

    public function destroy(Gudang $gudang)
    {
        $name = $gudang->nama_gudang;
        $gudang->delete();

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Gudang Dihapus',
                    "Gudang {$name} dihapus oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi hapus gudang: ' . $e->getMessage());
        }

        return redirect()->route('admin.gudang.index')->with('success', 'Gudang berhasil dihapus');
    }

    /**
     * Tambah stok gudang
     */
    public function addStock(Request $request, Gudang $gudang)
    {
        $request->validate([
            'jumlah_masuk' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        // Validasi: jangan bisa tambah stok jika sudah penuh atau over capacity
        if ($gudang->stok >= $gudang->kapasitas) {
            return redirect()->back()->with('error', 'Tidak bisa menambah stok! Gudang sudah penuh atau over capacity. Kurangi stok terlebih dahulu.');
        }

        // Validasi: jumlah yang ditambahkan tidak boleh melebihi kapasitas tersisa
        if ($gudang->stok + $request->jumlah_masuk > $gudang->kapasitas) {
            $tersisa = $gudang->kapasitas - $gudang->stok;
            return redirect()->back()->with('error', "Jumlah stok melebihi kapasitas! Hanya bisa menambah maksimal {$tersisa} unit. Kapasitas gudang: {$gudang->kapasitas} unit, Stok saat ini: {$gudang->stok} unit.");
        }

        $gudang->stok += $request->jumlah_masuk;
        
        // Auto detect status based on capacity
        if ($gudang->stok > $gudang->kapasitas) {
            $gudang->status = 'over_capacity';
        } elseif ($gudang->stok >= $gudang->kapasitas) {
            $gudang->status = 'penuh';
        } else {
            $gudang->status = 'aktif';
        }
        
        $gudang->catatan = ($gudang->catatan ? $gudang->catatan . "\n" : "") . 
                          "[" . now()->format('d M Y H:i') . "] +{$request->jumlah_masuk} unit - " . 
                          ($request->keterangan ?? "Stok masuk");
        $gudang->save();

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Stok Gudang Ditambahkan',
                    "Stok {$gudang->nama_gudang} ditambah +{$request->jumlah_masuk} unit oleh " . auth()->user()->name . 
                    ". Stok saat ini: {$gudang->stok} unit"
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi tambah stok: ' . $e->getMessage());
        }

        return redirect()->route('admin.gudang.show', $gudang)->with('success', 'Stok berhasil ditambahkan');
    }

    /**
     * Kurangi stok gudang
     */
    public function reduceStock(Request $request, Gudang $gudang)
    {
        $request->validate([
            'jumlah_keluar' => 'required|integer|min:1',
            'keterangan' => 'nullable|string',
        ]);

        if ($gudang->stok < $request->jumlah_keluar) {
            return redirect()->back()->with('error', 'Stok tidak cukup untuk pengurangan! Stok saat ini: ' . $gudang->stok);
        }

        $gudang->stok -= $request->jumlah_keluar;
        
        // Auto detect status based on capacity
        if ($gudang->stok > $gudang->kapasitas) {
            $gudang->status = 'over_capacity';
        } elseif ($gudang->stok >= $gudang->kapasitas) {
            $gudang->status = 'penuh';
        } else {
            $gudang->status = 'aktif';
        }
        
        $gudang->catatan = ($gudang->catatan ? $gudang->catatan . "\n" : "") . 
                          "[" . now()->format('d M Y H:i') . "] -{$request->jumlah_keluar} unit - " . 
                          ($request->keterangan ?? "Stok keluar");
        $gudang->save();

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Stok Gudang Dikurangi',
                    "Stok {$gudang->nama_gudang} dikurangi -{$request->jumlah_keluar} unit oleh " . auth()->user()->name . 
                    ". Stok saat ini: {$gudang->stok} unit"
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi kurangi stok: ' . $e->getMessage());
        }

        return redirect()->route('admin.gudang.show', $gudang)->with('success', 'Stok berhasil dikurangi');
    }
}