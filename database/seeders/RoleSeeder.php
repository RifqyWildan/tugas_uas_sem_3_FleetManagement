<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Permissions untuk semua modul
        $permissions = [
            // General/System
            'manage users', 'manage system settings', 'view audit log',
            // Finance
            'view finance', 'manage finance',
            // Armada
            'view armada', 'create armada', 'edit armada', 'delete armada',
            // Rute
            'view rute', 'create rute', 'edit rute', 'delete rute',
            // Driver
            'view driver', 'create driver', 'edit driver', 'delete driver',
            // Tracking/Pengiriman
            'view tracking', 'create tracking', 'edit tracking', 'delete tracking',
            // Gudang
            'view gudang', 'create gudang', 'edit gudang', 'delete gudang',
            // Service
            'view service', 'create service', 'edit service', 'delete service',
            // Tarif
            'view tarif', 'create tarif', 'edit tarif', 'delete tarif',
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // ========================================
        // Role 1: Super Admin (Full Access)
        // ========================================
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // ========================================
        // Role 2: Staff (Tidak bisa Delete)
        // ========================================
        $staff = Role::firstOrCreate(['name' => 'Staff']);
        $staff->givePermissionTo([
            // Finance (terbatas)
            'view finance',
            // Armada
            'view armada', 'create armada', 'edit armada',
            // Rute
            'view rute', 'create rute', 'edit rute',
            // Driver
            'view driver', 'create driver', 'edit driver',
            // Tracking
            'view tracking', 'create tracking', 'edit tracking',
            // Gudang
            'view gudang', 'create gudang', 'edit gudang',
            // Service
            'view service', 'create service', 'edit service',
            // Tarif
            'view tarif', 'create tarif', 'edit tarif',
        ]);

        // ========================================
        // Role 3: Public (Read Only - Cek Resi)
        // ========================================
        $public = Role::firstOrCreate(['name' => 'Public']);
        $public->givePermissionTo([
            'view tracking', // Hanya bisa cek resi/tracking
        ]);
    }
}