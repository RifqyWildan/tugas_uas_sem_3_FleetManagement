<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Diskon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\GenericNotice;

class DiskonController extends Controller
{
    public function index()
    {
        $diskons = Diskon::latest()->get();
        return view('admin.diskon.index', compact('diskons'));
    }

    public function create()
    {
        return view('admin.diskon.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_diskon' => 'required|string|max:255',
            'tipe_diskon' => 'required|in:persen,nominal,otomatis',
            'diskon_persen' => 'required_if:tipe_diskon,persen,otomatis|numeric|min:0|max:100',
            'diskon_nominal' => 'required_if:tipe_diskon,nominal|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $data = $request->all();
        
        // Set default values untuk field yang tidak digunakan
        if ($request->tipe_diskon === 'persen') {
            $data['diskon_nominal'] = 0;
        } elseif ($request->tipe_diskon === 'nominal') {
            $data['diskon_persen'] = 0;
        }

        $diskon = Diskon::create($data);

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Diskon Baru',
                    "Diskon {$diskon->nama_diskon} ditambahkan oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi diskon: ' . $e->getMessage());
        }

        return redirect()->route('admin.diskon.index')->with('success', 'Diskon berhasil ditambahkan');
    }

    public function show(Diskon $diskon)
    {
        return view('admin.diskon.show', compact('diskon'));
    }

    public function edit(Diskon $diskon)
    {
        return view('admin.diskon.edit', compact('diskon'));
    }

    public function update(Request $request, Diskon $diskon)
    {
        $request->validate([
            'nama_diskon' => 'required|string|max:255',
            'tipe_diskon' => 'required|in:persen,nominal,otomatis',
            'diskon_persen' => 'required_if:tipe_diskon,persen,otomatis|numeric|min:0|max:100',
            'diskon_nominal' => 'required_if:tipe_diskon,nominal|numeric|min:0',
            'tanggal_mulai' => 'nullable|date',
            'tanggal_selesai' => 'nullable|date|after_or_equal:tanggal_mulai',
            'keterangan' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $data = $request->all();
        
        // Set default values untuk field yang tidak digunakan
        if ($request->tipe_diskon === 'persen') {
            $data['diskon_nominal'] = 0;
        } elseif ($request->tipe_diskon === 'nominal') {
            $data['diskon_persen'] = 0;
        }

        $diskon->update($data);

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Diskon Diperbarui',
                    "Diskon {$diskon->nama_diskon} diperbarui oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi update diskon: ' . $e->getMessage());
        }

        return redirect()->route('admin.diskon.index')->with('success', 'Diskon berhasil diperbarui');
    }

    public function destroy(Diskon $diskon)
    {
        $name = $diskon->nama_diskon;
        $diskon->delete();

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Diskon Dihapus',
                    "Diskon {$name} dihapus oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi hapus diskon: ' . $e->getMessage());
        }

        return redirect()->route('admin.diskon.index')->with('success', 'Diskon berhasil dihapus');
    }
}
