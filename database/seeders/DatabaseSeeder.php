<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(RoleAndPermissionSeeder::class);
        $this->call(SettingAppSeeder::class);
        $this->call(KelompokBesarSeeder::class);
        $this->call(AkademiSeeder::class);
        $this->call(KategoriKompetensiSeeder::class);
        $this->call(RumpunPembelajaranSeeder::class);
    }
}
