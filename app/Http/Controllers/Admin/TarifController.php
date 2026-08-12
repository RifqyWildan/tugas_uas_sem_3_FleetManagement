<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tarif;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\GenericNotice;

class TarifController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::latest()->get();
        return view('admin.tarif.index', compact('tarifs'));
    }

    public function create()
    {
        return view('admin.tarif.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_layanan' => 'required',
            'tarif_per_km' => 'required|numeric|min:0',
            'minimal_tarif' => 'required|numeric|min:0',
            'catatan' => 'nullable',
        ]);

        $tarif = Tarif::create($request->all());

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Tarif Baru',
                    "Tarif {$tarif->nama_layanan} ditambahkan oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi tarif: ' . $e->getMessage());
        }

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil ditambahkan');
    }

    public function show(Tarif $tarif)
    {
        return view('admin.tarif.show', compact('tarif'));
    }

    public function edit(Tarif $tarif)
    {
        return view('admin.tarif.edit', compact('tarif'));
    }

    public function update(Request $request, Tarif $tarif)
    {
        $request->validate([
            'nama_layanan' => 'required',
            'tarif_per_km' => 'required|numeric|min:0',
            'minimal_tarif' => 'required|numeric|min:0',
            'catatan' => 'nullable',
        ]);

        $tarif->update($request->all());

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Tarif Diperbarui',
                    "Tarif {$tarif->nama_layanan} diperbarui oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi update tarif: ' . $e->getMessage());
        }

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil diperbarui');
    }

    public function destroy(Tarif $tarif)
    {
        $name = $tarif->nama_layanan;
        $tarif->delete();

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Tarif Dihapus',
                    "Tarif {$name} dihapus oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi hapus tarif: ' . $e->getMessage());
        }

        return redirect()->route('admin.tarif.index')->with('success', 'Tarif berhasil dihapus');
    }
}