<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tracking;
use App\Models\Armada;
use App\Models\Driver;
use App\Models\Rute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\GenericNotice;

class TrackingController extends Controller
{
    public function index()
    {
        $trackings = Tracking::with(['armada', 'driver', 'rute'])->latest()->get();
        return view('admin.tracking.index', compact('trackings'));
    }

    public function create()
    {
        $armadas = Armada::where('status', 'aktif')->get();
        $drivers = Driver::where('status_aktif', 'aktif')->get();
        $rutes = Rute::all();
        return view('admin.tracking.create', compact('armadas', 'drivers', 'rutes'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_armada' => 'required|exists:armadas,id_armada',
            'id_driver' => 'required|exists:drivers,id_driver',
            'id_rute' => 'required|exists:rutes,id_rute',
            'no_resi' => 'required|unique:pengiriman,no_resi',
            'status_pengiriman' => 'required|in:pending,dikirim,dalam_perjalanan,sampai,selesai,batal',
            'tanggal_kirim' => 'required|date',
            'tanggal_sampai' => 'nullable|date|after_or_equal:tanggal_kirim',
            'lokasi_terakhir' => 'nullable',
            'catatan' => 'nullable',
        ]);

        $tracking = Tracking::create($request->all());

        // Notify admins (Super Admin + Staff)
        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Pengiriman Baru',
                    "Resi {$tracking->no_resi} telah dibuat oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi pengiriman: ' . $e->getMessage());
        }

        return redirect()->route('admin.tracking.index')->with('success', 'Tracking berhasil ditambahkan');
    }

    public function show(Tracking $tracking)
    {
        $tracking->load(['armada', 'driver', 'rute']);
        return view('admin.tracking.show', compact('tracking'));
    }

    public function edit(Tracking $tracking)
    {
        $armadas = Armada::where('status', 'aktif')->get();
        $drivers = Driver::where('status_aktif', 'aktif')->get();
        $rutes = Rute::all();
        return view('admin.tracking.edit', compact('tracking', 'armadas', 'drivers', 'rutes'));
    }

    public function update(Request $request, Tracking $tracking)
    {
        $request->validate([
            'id_armada' => 'required|exists:armadas,id_armada',
            'id_driver' => 'required|exists:drivers,id_driver',
            'id_rute' => 'required|exists:rutes,id_rute',
            'no_resi' => 'required|unique:pengiriman,no_resi,' . $tracking->id_pengiriman . ',id_pengiriman',
            'status_pengiriman' => 'required|in:pending,dikirim,dalam_perjalanan,sampai,selesai,batal',
            'tanggal_kirim' => 'required|date',
            'tanggal_sampai' => 'nullable|date|after_or_equal:tanggal_kirim',
            'lokasi_terakhir' => 'nullable',
            'catatan' => 'nullable',
        ]);

        $oldResi = $tracking->no_resi;
        $tracking->update($request->all());

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                // If resi has been added now
                if (empty($oldResi) && ! empty($tracking->no_resi)) {
                    Notification::send($recipients, new GenericNotice(
                        'Resi Dimasukkan',
                        "Resi {$tracking->no_resi} ditambahkan pada pengiriman oleh " . auth()->user()->name
                    ));
                }

                // General update
                Notification::send($recipients, new GenericNotice(
                    'Pengiriman Diperbarui',
                    "Pengiriman (Resi: " . ($tracking->no_resi ?? '-') . ") diperbarui oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi update pengiriman: ' . $e->getMessage());
        }

        return redirect()->route('admin.tracking.index')->with('success', 'Tracking berhasil diperbarui');
    }

    public function destroy(Tracking $tracking)
    {
        $resi = $tracking->no_resi;
        $tracking->delete();

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Pengiriman Dihapus',
                    "Pengiriman (Resi: " . ($resi ?? '-') . ") dihapus oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi hapus pengiriman: ' . $e->getMessage());
        }

        return redirect()->route('admin.tracking.index')->with('success', 'Tracking berhasil dihapus');
    }
}