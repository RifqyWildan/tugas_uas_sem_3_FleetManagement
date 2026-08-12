<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\GenericNotice;

class NotificationsTest extends TestCase
{
    use RefreshDatabase;

    public function test_creating_armada_sends_notification_to_super_admin()
    {
        Notification::fake();

        // Setup roles and users
        Role::create(['name' => 'Super Admin']);
        Role::create(['name' => 'Staff']);

        $super = User::factory()->create();
        $super->assignRole('Super Admin');

        $staff = User::factory()->create();
        $staff->assignRole('Staff');

        $this->actingAs($staff)
            ->post(route('admin.armada.store'), [
                'nomor_polisi' => 'B 1234 XX',
                'jenis_kendaraan' => 'Bus',
                'merk' => 'Mercedes',
                'kapasitas_muatan' => 1000,
                'tahun_pembuatan' => 2020,
                'status' => 'aktif',
            ])
            ->assertRedirect(route('admin.armada.index'));

        Notification::assertSentTo($super, GenericNotice::class);
    }
}
