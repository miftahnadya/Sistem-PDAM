<?php
namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserFactory extends Factory
{
    public function definition()
    {
        $id_pelanggan = $this->faker->unique()->numerify('PLG####');
        return [
            'nama_pelanggan' => $this->faker->unique()->name(),
            'id_pelanggan' => Hash::make($id_pelanggan),
            'remember_token' => Str::random(10),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}