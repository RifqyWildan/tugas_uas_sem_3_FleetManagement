<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Armada;
use App\Models\Tracking;
use Spatie\Permission\Models\Role;

class ArmadaDeletionTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_cannot_delete_armada_with_related_tracking()
    {
        Role::create(['name' => 'Super Admin']);
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        $armada = Armada::create([
            'nomor_polisi' => 'B 9999 ZZ',
            'jenis_kendaraan' => 'Box',
            'merk' => 'Hino',
            'kapasitas_muatan' => 800,
            'tahun_pembuatan' => 2019,
            'status' => 'aktif',
        ]);

        // Create a tracking referencing this armada
        Tracking::create([
            'id_armada' => $armada->id_armada,
            'id_driver' => null,
            'id_rute' => null,
            'no_resi' => 'RESIDEL123',
            'status_pengiriman' => 'pending',
            'tanggal_kirim' => now()->toDateString(),
        ]);

        $response = $this->actingAs($user)->delete(route('admin.armada.destroy', $armada));
        $response->assertRedirect(route('admin.armada.index'));
        $response->assertSessionHas('error');

        $this->assertDatabaseHas('armadas', ['id_armada' => $armada->id_armada]);
    }

    public function test_admin_can_delete_armada_without_relations()
    {
        Role::create(['name' => 'Super Admin']);
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        $armada = Armada::create([
            'nomor_polisi' => 'B 8888 YY',
            'jenis_kendaraan' => 'Box',
            'merk' => 'Fuso',
            'kapasitas_muatan' => 900,
            'tahun_pembuatan' => 2018,
            'status' => 'aktif',
        ]);

        $response = $this->actingAs($user)->delete(route('admin.armada.destroy', $armada));
        $response->assertRedirect(route('admin.armada.index'));
        $response->assertSessionHas('success');

        $this->assertDatabaseMissing('armadas', ['id_armada' => $armada->id_armada]);
    }

    public function test_admin_can_delete_armada_after_trackings_finished()
    {
        Role::create(['name' => 'Super Admin']);
        $user = User::factory()->create();
        $user->assignRole('Super Admin');

        $armada = Armada::create([
            'nomor_polisi' => 'B 7777 ZZ',
            'jenis_kendaraan' => 'Box',
            'merk' => 'Nissan',
            'kapasitas_muatan' => 1000,
            'tahun_pembuatan' => 2020,
            'status' => 'aktif',
        ]);

        // create an active tracking
        $tracking = Tracking::create([
            'id_armada' => $armada->id_armada,
            'id_driver' => null,
            'id_rute' => null,
            'no_resi' => 'RESI-FIN-001',
            'status_pengiriman' => 'dikirim',
            'tanggal_kirim' => now()->toDateString(),
        ]);

        // deletion blocked while tracking active
        $response = $this->actingAs($user)->delete(route('admin.armada.destroy', $armada));
        $response->assertRedirect(route('admin.armada.index'));
        $response->assertSessionHas('error');
        $this->assertDatabaseHas('armadas', ['id_armada' => $armada->id_armada]);

        // mark tracking completed
        $tracking->update(['status_pengiriman' => 'selesai']);

        // deletion should now succeed
        $response2 = $this->actingAs($user)->delete(route('admin.armada.destroy', $armada));
        $response2->assertRedirect(route('admin.armada.index'));
        $response2->assertSessionHas('success');
        $this->assertDatabaseMissing('armadas', ['id_armada' => $armada->id_armada]);
    }
}
