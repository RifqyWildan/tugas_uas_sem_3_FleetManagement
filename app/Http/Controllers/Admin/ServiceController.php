<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Armada;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Models\User;
use App\Notifications\GenericNotice;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with('armada')->latest()->get();
        return view('admin.service.index', compact('services'));
    }

    public function create()
    {
        $armadas = Armada::all();
        return view('admin.service.create', compact('armadas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_armada' => 'required|exists:armadas,id_armada',
            'tanggal_service' => 'required|date',
            'jenis_service' => 'required',
            'deskripsi' => 'nullable',
            'catatan' => 'nullable',
            'biaya' => 'required|numeric|min:0',
        ]);

        $service = Service::create($request->all());

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Service Baru',
                    "Service untuk Armada ID {$service->id_armada} dibuat oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi service: ' . $e->getMessage());
        }

        return redirect()->route('admin.service.index')->with('success', 'Service berhasil ditambahkan');
    }

    public function show(Service $service)
    {
        $service->load('armada');
        return view('admin.service.show', compact('service'));
    }

    public function edit(Service $service)
    {
        $armadas = Armada::all();
        return view('admin.service.edit', compact('service', 'armadas'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'id_armada' => 'required|exists:armadas,id_armada',
            'tanggal_service' => 'required|date',
            'jenis_service' => 'required',
            'deskripsi' => 'nullable',
            'catatan' => 'nullable',
            'biaya' => 'required|numeric|min:0',
        ]);

        $service->update($request->all());

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Service Diperbarui',
                    "Service untuk Armada ID {$service->id_armada} diperbarui oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi update service: ' . $e->getMessage());
        }

        return redirect()->route('admin.service.index')->with('success', 'Service berhasil diperbarui');
    }

    public function destroy(Service $service)
    {
        $id = $service->id_service ?? $service->id;
        $service->delete();

        try {
            $recipients = User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->get();
            if ($recipients->isNotEmpty()) {
                Notification::send($recipients, new GenericNotice(
                    'Service Dihapus',
                    "Service untuk Armada ID {$id} dihapus oleh " . auth()->user()->name
                ));
            }
        } catch (\Throwable $e) {
            \Log::error('Gagal mengirim notifikasi hapus service: ' . $e->getMessage());
        }

        return redirect()->route('admin.service.index')->with('success', 'Service berhasil dihapus');
    }
}