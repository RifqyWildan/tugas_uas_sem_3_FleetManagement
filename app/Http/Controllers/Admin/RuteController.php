<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rute;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\GenericNotice;

class RuteController extends Controller
{
    public function index()
    {
        $rutes = Rute::latest()->get();
        return view('admin.rute.index', compact('rutes'));
    }

    public function create()
    {
        return view('admin.rute.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_rute' => 'required',
            'asal' => 'required',
            'tujuan' => 'required',
            'jarak_km' => 'required|numeric|min:0',
            'estimasi_waktu' => 'required',
            'tarif' => 'required|numeric|min:0',
            'catatan' => 'nullable',
        ]);

        $rute = Rute::create($request->all());

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Rute Baru',
                    "Rute {$rute->nama_rute} dibuat oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi rute: ' . $e->getMessage());
        }

        return redirect()->route('admin.rute.index')->with('success', 'Rute berhasil ditambahkan');
    }

    public function show(Rute $rute)
    {
        $rute->load('trackings');
        return view('admin.rute.show', compact('rute'));
    }

    public function edit(Rute $rute)
    {
        return view('admin.rute.edit', compact('rute'));
    }

    public function update(Request $request, Rute $rute)
    {
        $request->validate([
            'nama_rute' => 'required',
            'asal' => 'required',
            'tujuan' => 'required',
            'jarak_km' => 'required|numeric|min:0',
            'estimasi_waktu' => 'required|integer|min:0',
            'tarif' => 'required|numeric|min:0',
            'catatan' => 'nullable',
        ]);

        $rute->update($request->all());

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Rute Diperbarui',
                    "Rute {$rute->nama_rute} diperbarui oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi update rute: ' . $e->getMessage());
        }

        return redirect()->route('admin.rute.index')->with('success', 'Rute berhasil diperbarui');
    }

    public function destroy(Rute $rute)
    {
        $name = $rute->nama_rute;
        $rute->delete();

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Rute Dihapus',
                    "Rute {$name} dihapus oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi hapus rute: ' . $e->getMessage());
        }

        return redirect()->route('admin.rute.index')->with('success', 'Rute berhasil dihapus');
    }
}