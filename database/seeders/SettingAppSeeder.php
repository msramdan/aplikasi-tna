<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\SettingApp;

class SettingAppSeeder extends Seeder
{
    public function run()
    {
        SettingApp::create([
            'aplication_name' => 'Aplikasi TNA',
            'logo' => '',
            'favicon' => '',
            'is_maintenance' => 'No',
            'otomatis_sync_info_diklat' => 'No',
            'reverse_atur_tagging' => 'Yes',
        ]);
    }
}
