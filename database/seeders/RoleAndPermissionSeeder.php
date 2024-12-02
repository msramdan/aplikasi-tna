<?php

namespace Database\Seeders;

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
        // Clear cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define roles and their permissions
        $rolesWithPermissions = [
            'Super Admin' => [
                'permissions' => config('permission.permissions.access', []),
                'grant_all' => true,
            ],
            'Admin Unit' => [
                'permissions' => [
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
                ],
            ],
            'User' => [
                'permissions' => [
                    'kalender pembelajaran view',
                    'pengajuan kap view',
                    'kompetensi view',
                    'topik view',
                    'rumpun pembelajaran view',
                    'nomenklatur pembelajaran view',
                ],
            ],
            'Admin Pusbin JFA' => [
                'permissions' => [
                    'kalender pembelajaran view',
                    'pengajuan kap view',
                    'pengajuan kap tahunan bpkp',
                    'pengajuan kap tahunan non bpkp',
                    'pengajuan kap insidentil bpkp',
                    'kompetensi view',
                    'topik view',
                    'rumpun pembelajaran view',
                    'nomenklatur pembelajaran view',
                ],
            ],
            'Admin APIP' => [
                'permissions' => [
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
                ],
            ],
        ];

        // Create roles and assign permissions
        foreach ($rolesWithPermissions as $roleName => $roleData) {
            $role = Role::create(['name' => $roleName]);

            if (!empty($roleData['grant_all'])) {
                $role->givePermissionTo(Permission::all());
            } else {
                foreach ($roleData['permissions'] as $permissionName) {
                    Permission::firstOrCreate(['name' => $permissionName]);
                    $role->givePermissionTo($permissionName);
                }
            }
        }
    }
}
