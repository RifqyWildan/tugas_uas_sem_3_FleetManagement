<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Armada;
use App\Models\Driver;
use App\Models\Rute;
use Spatie\Permission\Models\Role;

class TrackingCrudTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_tracking()
    {
        // Create role and user
        Role::create(['name' => 'Super Admin']);
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        // Create related models
        $armada = Armada::create([
            'nomor_polisi' => 'B 1234 CD',
            'jenis_kendaraan' => 'Box',
            'merk' => 'Isuzu',
            'kapasitas_muatan' => 1000,
            'tahun_pembuatan' => 2020,
            'status' => 'aktif',
        ]);

        $driver = Driver::create([
            'nama' => 'Budi',
            'no_ktp' => '1234567890123456',
            'no_sim' => 'SIM1234567',
            'tipe_sim' => 'B1',
            'telepon' => '081234567890',
            'alamat' => 'Jakarta',
            'status_aktif' => 'aktif',
            'tanggal_gabung' => now()->toDateString(),
        ]);

        $rute = Rute::create([
            'nama_rute' => 'Jakarta-Surabaya',
            'asal' => 'Jakarta',
            'tujuan' => 'Surabaya',
            'jarak_km' => 700,
            'estimasi_waktu' => '2 hari',
            'tarif' => 500000,
        ]);

        $payload = [
            'id_armada' => $armada->id_armada,
            'id_driver' => $driver->id_driver,
            'id_rute' => $rute->id_rute,
            'no_resi' => 'RESI123456789',
            'status_pengiriman' => 'dikirim',
            'tanggal_kirim' => now()->toDateString(),
            'lokasi_terakhir' => 'Jakarta',
        ];

        $response = $this->actingAs($user)->post(route('admin.tracking.store'), $payload);
        $response->assertRedirect(route('admin.tracking.index'));

        $this->assertDatabaseHas('pengiriman', [
            'no_resi' => 'RESI123456789',
            'status_pengiriman' => 'dikirim',
        ]);
    }
}
