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
            'tagging pembelajaran kompetensi view',
            'tagging kompetensi ik view',
            'rumpun pembelajaran view',
            'topik view',
            'pengajuan kap view',
            'pengajuan kap tahunan bpkp',
            'pengajuan kap insidentil bpkp',
            'pengajuan kap edit',
            'pengajuan kap delete',
            'nomenklatur pembelajaran view',
            'kompetensi view',
            'kalender pembelajaran view',

        ];
        foreach ($permissionAdminUnit as $x) {
            $roleAdminUnit->givePermissionTo($x);
        }

        // User biasa / default user pertama login
        $roleUser = Role::create([
            'name' => 'User'
        ]);
        $permissionUser = [
            'kalender pembelajaran view',
            'pengajuan kap view',
            'kompetensi view',
            'topik view',
            'rumpun pembelajaran view',
            'nomenklatur pembelajaran view'
        ];
        foreach ($permissionUser as $y) {
            $roleUser->givePermissionTo($y);
        }

        // User Admin Pusbin JFA
        $roleAdminPusbinJFA = Role::create([
            'name' => 'Admin Pusbin JFA'
        ]);
        $permissionAdminPusbinJFA = [
            'kalender pembelajaran view',
            'pengajuan kap view',
            'pengajuan kap tahunan bpkp',
            'pengajuan kap tahunan non bpkp',
            'pengajuan kap insidentil bpkp',
            'kompetensi view',
            'topik view',
            'rumpun pembelajaran view',
            'nomenklatur pembelajaran view'
        ];
        foreach ($permissionAdminPusbinJFA as $y) {
            $roleAdminPusbinJFA->givePermissionTo($y);
        }

        // User Admin APIP
        $roleAdminAPIP = Role::create([
            'name' => 'Admin APIP'
        ]);
        $permissionAdminAPIP = [
            'tagging pembelajaran kompetensi view',
            'tagging kompetensi ik view',
            'rumpun pembelajaran view',
            'topik view',
            'pengajuan kap view',
            'pengajuan kap tahunan non bpkp',
            'pengajuan kap insidentil non bpkp',
            'pengajuan kap edit',
            'pengajuan kap delete',
            'nomenklatur pembelajaran view',
            'kompetensi view',
            'kalender pembelajaran view',
        ];
        foreach ($permissionAdminAPIP as $y) {
            $roleAdminAPIP->givePermissionTo($y);
        }
    }
}
