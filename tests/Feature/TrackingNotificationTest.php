<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\GenericNotice;

class TrackingNotificationTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_tracking_sends_notification_to_admins()
    {


        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Staff']);

        $super = User::factory()->create();
        $super->assignRole('Super Admin');

        $staff = User::factory()->create();
        $staff->assignRole('Staff');

        // Make sure permissions/roles cache is fresh for Spatie
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Sanity: ensure recipients exist
        $this->assertTrue(\App\Models\User::whereHas('roles', function($q){ $q->whereIn('name', ['Super Admin','Staff']); })->count() >= 1);

        // Create related models
        \App\Models\Armada::create([
            'nomor_polisi' => 'B 5555 ZZ',
            'jenis_kendaraan' => 'Box',
            'merk' => 'Isuzu',
            'kapasitas_muatan' => 1000,
            'tahun_pembuatan' => 2020,
            'status' => 'aktif',
        ]);

        \App\Models\Driver::create([
            'nama' => 'Budi',
            'no_ktp' => '1234567890123456',
            'no_sim' => 'SIM5555555',
            'tipe_sim' => 'B1',
            'telepon' => '081234000000',
            'alamat' => 'Jakarta',
            'status_aktif' => 'aktif',
            'tanggal_gabung' => now()->toDateString(),
        ]);

        \App\Models\Rute::create([
            'nama_rute' => 'Test Rute',
            'asal' => 'A',
            'tujuan' => 'B',
            'jarak_km' => 100,
            'estimasi_waktu' => '2 hari',
            'tarif' => 100000,
        ]);

        $this->actingAs($staff)
            ->post(route('admin.tracking.store'), [
                'id_armada' => 1,
                'id_driver' => 1,
                'id_rute' => 1,
                'no_resi' => 'TESTRESI123',
                'status_pengiriman' => 'dikirim',
                'tanggal_kirim' => now()->toDateString(),
            ]);

        // Check that at least one notification was stored in the database
        $this->assertDatabaseHas('notifications', [
            'type' => GenericNotice::class,
        ]);
    }
}
