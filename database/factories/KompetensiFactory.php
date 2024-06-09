<?php

namespace Database\Factories;

use App\Models\Kompetensi;
use Illuminate\Database\Eloquent\Factories\Factory;

class KompetensiFactory extends Factory
{
    protected $model = Kompetensi::class;

    public function definition()
    {
        return [
            'nama_kompetensi' => $this->faker->sentence(2),
            'deskripsi_kompetensi' => $this->faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
