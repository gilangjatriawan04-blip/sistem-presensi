<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password123'),
            'remember_token' => Str::random(10),
            
            // Data magang
            'role' => fake()->randomElement(['admin', 'pegawai', 'pembimbing']),
            'jenis_peserta' => fake()->randomElement(['mahasiswa', 'smk', 'pegawai', 'lainnya']),
            'institution_name' => fake()->company(),
            'institution_class' => fake()->randomElement(['TI-3A', 'XII TKJ 1', 'SI-5B', null]),
            'nim_nisn' => fake()->numerify('##########'),
            'supervisor_name' => fake()->name(),
            'supervisor_contact' => fake()->phoneNumber(),
            'start_date' => fake()->dateTimeBetween('-1 month', 'now')->format('Y-m-d'),
            'end_date' => fake()->dateTimeBetween('now', '+6 months')->format('Y-m-d'),
            
            // Login info
            'device_id' => Str::random(16),
            'last_login_at' => fake()->dateTimeBetween('-1 week', 'now'),
            'last_login_ip' => fake()->ipv4(),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * State untuk admin
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'jenis_peserta' => 'pegawai',
            'institution_name' => null,
            'institution_class' => null,
        ]);
    }

    /**
     * State untuk mahasiswa
     */
    public function mahasiswa(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'pegawai',
            'jenis_peserta' => 'mahasiswa',
            'institution_name' => fake()->randomElement(['Universitas Indonesia', 'ITB', 'UGM']),
            'institution_class' => fake()->randomElement(['TI-3A', 'SI-5B', 'MI-2C']),
        ]);
    }

    /**
     * State untuk SMK
     */
    public function smk(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'pegawai',
            'jenis_peserta' => 'smk',
            'institution_name' => fake()->randomElement(['SMKN 1 Jakarta', 'SMKN 4 Bandung', 'SMKN 7 Surabaya']),
            'institution_class' => fake()->randomElement(['XII TKJ 1', 'XII AKL 2', 'XII RPL 3']),
        ]);
    }
}