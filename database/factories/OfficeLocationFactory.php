<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OfficeLocation>
 */
class OfficeLocationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Koordinat contoh: Jakarta Pusat
        return [
            'nama_lokasi' => 'Kantor Pusat ' . fake()->company(),
            'alamat' => fake()->address(),
            'latitude' => fake()->latitude(-6.2, -6.1), // Jakarta area
            'longitude' => fake()->longitude(106.7, 106.9),
            'radius_meter' => 100,
            'jam_masuk_default' => '08:00:00',
            'jam_pulang_default' => '17:00:00',
            'is_aktif' => true,
        ];
    }

    /**
     * State untuk lokasi tidak aktif
     */
    public function nonAktif(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_aktif' => false,
        ]);
    }
}