<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TarifPerKg;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\GenericNotice;

class TarifPerKgController extends Controller
{
    public function index()
    {
        $tarifPerKgs = TarifPerKg::latest()->get();
        return view('admin.tarif-per-kg.index', compact('tarifPerKgs'));
    }

    public function create()
    {
        return view('admin.tarif-per-kg.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_tarif' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0',
            'tipe_barang' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $tarifPerKg = TarifPerKg::create($request->all());

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Tarif Per Kg Baru',
                    "Tarif {$tarifPerKg->nama_tarif} ditambahkan oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi tarif per kg: ' . $e->getMessage());
        }

        return redirect()->route('admin.tarif-per-kg.index')->with('success', 'Tarif Per Kg berhasil ditambahkan');
    }

    public function show(TarifPerKg $tarifPerKg)
    {
        return view('admin.tarif-per-kg.show', compact('tarifPerKg'));
    }

    public function edit(TarifPerKg $tarifPerKg)
    {
        return view('admin.tarif-per-kg.edit', compact('tarifPerKg'));
    }

    public function update(Request $request, TarifPerKg $tarifPerKg)
    {
        $request->validate([
            'nama_tarif' => 'required|string|max:255',
            'harga_per_kg' => 'required|numeric|min:0',
            'tipe_barang' => 'nullable|string|max:100',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:aktif,tidak_aktif',
        ]);

        $tarifPerKg->update($request->all());

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Tarif Per Kg Diperbarui',
                    "Tarif {$tarifPerKg->nama_tarif} diperbarui oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi update tarif per kg: ' . $e->getMessage());
        }

        return redirect()->route('admin.tarif-per-kg.index')->with('success', 'Tarif Per Kg berhasil diperbarui');
    }

    public function destroy(TarifPerKg $tarifPerKg)
    {
        $name = $tarifPerKg->nama_tarif;
        $tarifPerKg->delete();

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Tarif Per Kg Dihapus',
                    "Tarif {$name} dihapus oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi hapus tarif per kg: ' . $e->getMessage());
        }

        return redirect()->route('admin.tarif-per-kg.index')->with('success', 'Tarif Per Kg berhasil dihapus');
    }
}
