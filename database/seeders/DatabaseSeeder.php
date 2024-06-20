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
        $this->call(KotaSeeder::class);
        $this->call(LokasiSeeder::class);
        $this->call(RuangKelasSeeder::class);
        $this->call(AsramaSeeder::class);
        $this->call(KelompokBesarSeeder::class);
        $this->call(NamaAkademiSeeder::class);
        $this->call(KelompokBesarSeeder::class);
        $this->call(KategoriKompetensiSeeder::class);
        // $this->call(KompetensiSeeder::class);
        // $this->call(TopikSeeder::class);
    }
}
