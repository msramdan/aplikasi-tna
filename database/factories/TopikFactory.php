<?php

namespace Database\Factories;

use App\Models\Topik;
use Illuminate\Database\Eloquent\Factories\Factory;

class TopikFactory extends Factory
{
    protected $model = Topik::class;

    public function definition()
    {
        return [
            'nama_topik' => $this->faker->sentence(2),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
