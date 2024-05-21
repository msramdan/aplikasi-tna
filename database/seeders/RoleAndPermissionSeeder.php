<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\{Role, Permission};

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        $roleAdmin = Role::create(
            [
                'name' => 'Super Admin'
            ]
        );

        foreach (config('permission.permissions') as $permission) {
            foreach ($permission['access'] as $access) {
                Permission::create(['name' => $access]);
            }
        }
        $roleAdmin->givePermissionTo(Permission::all());

        // Admin Unit
        $roleAdminUnit = Role::create([
            'name' => 'Admin Unit'
        ]);
        $permissionAdminUnit = [
            'reporting view',
            'reporting create',
            'reporting edit',
            'reporting delete'
        ];
        foreach ($permissionAdminUnit as $x) {
            $roleAdminUnit->givePermissionTo($x);
        }

        // User biasa
        $roleUser = Role::create([
            'name' => 'User'
        ]);
        $permissionUser = [
            'kalender pembelajaran view',
            'kalender pembelajaran create',
            'kalender pembelajaran edit',
            'kalender pembelajaran delete'
        ];
        foreach ($permissionUser as $y) {
            $roleUser->givePermissionTo($y);
        }
    }
}
