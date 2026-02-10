<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\OfficeLocation;
use App\Models\Presensi;
use App\Models\Izin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Buat lokasi kantor
        $kantorPusat = OfficeLocation::create([
            'nama_lokasi' => 'Kantor Pusat',
            'alamat' => 'Jl. Sudirman No. 123, Jakarta',
            'latitude' => -6.208763,
            'longitude' => 106.845599,
            'radius_meter' => 150,
            'jam_masuk_default' => '08:00:00',
            'jam_pulang_default' => '17:00:00',
            'is_aktif' => true,
        ]);

        // 2. Buat user admin (password: admin123)
        $admin = User::create([
            'name' => 'Admin Sistem',
            'email' => 'admin@presensi.test',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'jenis_peserta' => 'pegawai',
            'device_id' => 'ADMIN001',
        ]);

        // 3. Buat user pembimbing
        $pembimbing = User::create([
            'name' => 'Dr. Ahmad S.Kom',
            'email' => 'pembimbing@presensi.test',
            'password' => Hash::make('pembimbing123'),
            'role' => 'pembimbing',
            'jenis_peserta' => 'pegawai',
            'institution_name' => 'Universitas Indonesia',
            'device_id' => 'PEMBIMBING001',
        ]);

        // 4. Buat 10 user random menggunakan factory
        User::factory(10)->create();

        // 5. Buat beberapa presensi dummy
        $users = User::where('role', 'pegawai')->get();
        
        foreach ($users as $user) {
            // Buat presensi untuk 5 hari terakhir
            for ($i = 1; $i <= 5; $i++) {
                $tanggal = now()->subDays($i)->format('Y-m-d');
                
                // Skip weekend
                if (date('N', strtotime($tanggal)) >= 6) continue;
                
                // Random jam masuk (antara 07:30 - 09:30)
                $jamMasuk = now()->subDays($i)->setTime(
                    rand(7, 9),
                    rand(0, 59),
                    0
                );
                
                $presensi = Presensi::create([
                    'user_id' => $user->id,
                    'tanggal' => $tanggal,
                    'jam_masuk' => $jamMasuk,
                    'jam_pulang' => $jamMasuk->copy()->addHours(rand(7, 9)),
                    'lokasi_masuk' => '-6.20' . rand(100, 999) . ',106.84' . rand(100, 999),
                    'lokasi_pulang' => '-6.20' . rand(100, 999) . ',106.84' . rand(100, 999),
                    'jam_masuk_normal' => '08:00:00',
                    'jam_pulang_normal' => '17:00:00',
                    'keterangan' => fake()->sentence(),
                ]);
                
                // Hitung status presensi
                $presensi->hitungStatus();
            }
        }

        // 6. Buat beberapa izin dummy
        foreach ($users->take(3) as $user) {
            Izin::create([
                'user_id' => $user->id,
                'jenis_izin' => 'sakit',
                'alasan' => 'Demam tinggi dan batuk',
                'tanggal_mulai' => now()->subDays(2)->format('Y-m-d'),
                'tanggal_selesai' => now()->subDays(2)->format('Y-m-d'),
                'file_bukti' => 'surat_dokter.pdf',
                'status_approval' => 'disetujui',
                'approved_by' => $admin->id,
                'approved_at' => now()->subDays(1),
            ]);
        }

        // 7. Buat izin terlambat
        $userContoh = $users->first();
        Izin::create([
            'user_id' => $userContoh->id,
            'jenis_izin' => 'izin_terlambat',
            'alasan' => 'Kendaraan bermasalah di jalan',
            'tanggal_mulai' => now()->format('Y-m-d'),
            'tanggal_selesai' => now()->format('Y-m-d'),
            'jam_izin_terlambat' => '09:30:00',
            'status_approval' => 'pending',
        ]);

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin login: admin@presensi.test / admin123');
        $this->command->info('Pembimbing: pembimbing@presensi.test / pembimbing123');
    }
}