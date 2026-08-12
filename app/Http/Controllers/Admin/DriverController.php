<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Driver;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\GenericNotice;

class DriverController extends Controller
{
    public function index()
    {
        $drivers = Driver::latest()->get();
        return view('admin.driver.index', compact('drivers'));
    }

    public function create()
    {
        return view('admin.driver.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'no_ktp' => 'required|unique:drivers,no_ktp|size:16',
            'no_sim' => 'required|unique:drivers,no_sim',
            'tipe_sim' => 'required|in:A,B1,B2,C',
            'telepon' => 'required',
            'alamat' => 'required',
            'status_aktif' => 'required|in:aktif,tidak_aktif,cuti',
            'tanggal_gabung' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('driver', 'public');
        }

        $driver = Driver::create($data);

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Driver Baru',
                    "Driver {$driver->nama} ditambahkan oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi driver: ' . $e->getMessage());
        }

        return redirect()->route('admin.driver.index')->with('success', 'Driver berhasil ditambahkan');
    }

    public function show(Driver $driver)
    {
        $driver->load('trackings');
        return view('admin.driver.show', compact('driver'));
    }

    public function edit(Driver $driver)
    {
        return view('admin.driver.edit', compact('driver'));
    }

    public function update(Request $request, Driver $driver)
    {
        $request->validate([
            'nama' => 'required',
            'no_ktp' => 'required|size:16|unique:drivers,no_ktp,' . $driver->id_driver . ',id_driver',
            'no_sim' => 'required|unique:drivers,no_sim,' . $driver->id_driver . ',id_driver',
            'tipe_sim' => 'required|in:A,B1,B2,C',
            'telepon' => 'required',
            'alamat' => 'required',
            'status_aktif' => 'required|in:aktif,tidak_aktif,cuti',
            'tanggal_gabung' => 'required|date',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        if ($request->hasFile('foto')) {
            if ($driver->foto) {
                Storage::disk('public')->delete($driver->foto);
            }
            $data['foto'] = $request->file('foto')->store('driver', 'public');
        }

        $driver->update($data);

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Driver Diperbarui',
                    "Driver {$driver->nama} diperbarui oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi update driver: ' . $e->getMessage());
        }

        return redirect()->route('admin.driver.index')->with('success', 'Driver berhasil diperbarui');
    }

    public function destroy(Driver $driver)
    {
        if ($driver->foto) {
            Storage::disk('public')->delete($driver->foto);
        }
        $name = $driver->nama;
        $driver->delete();

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Driver Dihapus',
                    "Driver {$name} dihapus oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi hapus driver: ' . $e->getMessage());
        }

        return redirect()->route('admin.driver.index')->with('success', 'Driver berhasil dihapus');
    }
}