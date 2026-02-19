<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Admin') }}
            </h2>
            <div class="flex space-x-2">
                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1.5 rounded-full font-medium">
                    {{ now()->format('l, d F Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Statistik Cards (GRID 4) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Card Total User -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total User</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $total_users }}</p>
                            <p class="text-xs text-green-600 mt-2">+12% dari bulan lalu</p>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 1.197h-6" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Statistik Izin per Jenis -->
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
    <div class="bg-blue-50 rounded-xl p-5 text-center border border-blue-100">
        <span class="text-3xl font-bold text-blue-600">{{ $izin_stats['izin'] ?? 0 }}</span>
        <p class="text-sm text-gray-600 mt-1">Izin</p>
    </div>
    <div class="bg-red-50 rounded-xl p-5 text-center border border-red-100">
        <span class="text-3xl font-bold text-red-600">{{ $izin_stats['sakit'] ?? 0 }}</span>
        <p class="text-sm text-gray-600 mt-1">Sakit</p>
    </div>
    <div class="bg-yellow-50 rounded-xl p-5 text-center border border-yellow-100">
        <span class="text-3xl font-bold text-yellow-600">{{ $izin_stats['izin_terlambat'] ?? 0 }}</span>
        <p class="text-sm text-gray-600 mt-1">Izin Terlambat</p>
    </div>
    <div class="bg-purple-50 rounded-xl p-5 text-center border border-purple-100">
        <span class="text-3xl font-bold text-purple-600">{{ $izin_stats['tugas_luar'] ?? 0 }}</span>
        <p class="text-sm text-gray-600 mt-1">Tugas Luar</p>
    </div>
</div>

<!-- Grafik Presensi 7 Hari -->
<div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 mb-8">
    <div class="flex justify-between items-center mb-6">
        <h3 class="font-semibold text-gray-700 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
            </svg>
            Grafik Presensi 7 Hari Terakhir
        </h3>
        <span class="text-xs text-gray-500">Total presensi per hari</span>
    </div>
    
    <div class="flex items-end space-x-2 h-48">
        @foreach($chartLabels as $index => $label)
            @php
                $max = max($chartData) ?: 1;
                $height = ($chartData[$index] / $max) * 100;
            @endphp
            <div class="flex-1 flex flex-col items-center group">
                <div class="relative w-full">
                    <div class="w-full bg-blue-100 rounded-t-lg relative transition-all duration-300 group-hover:bg-blue-200" 
                         style="height: {{ $height }}px;">
                        <div class="absolute -top-7 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs py-1 px-2 rounded opacity-0 group-hover:opacity-100 transition whitespace-nowrap">
                            {{ $chartData[$index] }} presensi
                        </div>
                    </div>
                </div>
                <span class="text-xs text-gray-500 mt-2 font-medium">{{ $label }}</span>
            </div>
        @endforeach
    </div>
</div>

<!-- Peserta Terbaik -->
<div class="bg-white rounded-2xl shadow-md p-6 border border-gray-100 mb-8">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-semibold text-gray-700 flex items-center">
            <svg class="w-5 h-5 mr-2 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
            </svg>
            Peserta dengan Kehadiran Terbaik
        </h3>
        <span class="text-xs text-gray-500">Total presensi</span>
    </div>
    
    <div class="space-y-3">
        @forelse($peserta_terbaik as $peserta)
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
            <div class="flex items-center">
                <div class="w-10 h-10 rounded-full bg-gradient-to-r from-green-400 to-green-500 flex items-center justify-center text-white font-bold text-sm mr-3 shadow-sm">
                    {{ strtoupper(substr($peserta->name, 0, 1)) }}
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-800">{{ $peserta->name }}</p>
                    <p class="text-xs text-gray-500">{{ $peserta->institution_name ?? 'Tanpa institusi' }}</p>
                </div>
            </div>
            <div class="flex items-center">
                <span class="text-lg font-bold text-green-600 mr-2">{{ $peserta->presensis_count }}</span>
                <span class="text-xs text-gray-500">hadir</span>
            </div>
        </div>
        @empty
        <div class="text-center py-6 text-gray-500">
            <p>Belum ada data presensi</p>
        </div>
        @endforelse
    </div>
</div>
                
                <!-- Card Presensi Hari Ini -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Presensi Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $total_presensi_hari_ini }}</p>
                            <p class="text-xs text-gray-500 mt-2">dari {{ $total_users }} user</p>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Card Izin Pending -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Izin Pending</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $total_izin_pending }}</p>
                            <a href="{{ route('admin.izin.index') }}" class="text-xs text-blue-600 hover:text-blue-800 mt-2 block">
                                Lihat semua →
                            </a>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Card Peserta Aktif -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Peserta Aktif</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $users_magang_aktif }}</p>
                            <p class="text-xs text-purple-600 mt-2">sedang magang</p>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions (GRID 3) -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <a href="{{ route('admin.users.create.admin') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-xl mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-semibold">Tambah Admin</p>
                            <p class="text-sm text-blue-100">Staff pengelola sistem</p>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('admin.users.create.pembimbing') }}" class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-xl mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-semibold">Tambah Pembimbing</p>
                            <p class="text-sm text-purple-100">Dosen/guru pembimbing</p>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('admin.users.create.peserta') }}" class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-xl mr-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-lg font-semibold">Tambah Peserta</p>
                            <p class="text-sm text-green-100">Mahasiswa/siswa magang</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Tabel Presensi Hari Ini -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-700 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Presensi Hari Ini
                    </h3>
                    <span class="text-xs bg-blue-100 text-blue-800 px-3 py-1 rounded-full">{{ now()->format('d M Y') }}</span>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($presensi_hari_ini as $presensi)
                            <tr class="hover:bg-blue-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gradient-to-r from-blue-400 to-blue-500 flex items-center justify-center text-white font-bold text-xs mr-3">
                                            {{ strtoupper(substr($presensi->user->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium text-gray-900">{{ $presensi->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $presensi->user->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($presensi->jam_masuk)
                                        <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }}</span>
                                        @if($presensi->terlambat_menit > 0)
                                            <span class="text-xs text-red-500 block">(+{{ $presensi->terlambat_menit }}m)</span>
                                        @endif
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($presensi->jam_pulang)
                                        <span class="text-sm font-medium">{{ \Carbon\Carbon::parse($presensi->jam_pulang)->format('H:i') }}</span>
                                    @else
                                        <span class="text-sm text-gray-400">Belum pulang</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $statusColors = [
                                            'tepat_waktu' => 'bg-green-100 text-green-800',
                                            'terlambat' => 'bg-yellow-100 text-yellow-800',
                                            'pulang_cepat' => 'bg-orange-100 text-orange-800',
                                            'izin' => 'bg-blue-100 text-blue-800',
                                            'sakit' => 'bg-purple-100 text-purple-800',
                                            'alpha' => 'bg-red-100 text-red-800',
                                        ];
                                    @endphp
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$presensi->status] ?? 'bg-gray-100' }}">
                                        {{ ucfirst(str_replace('_', ' ', $presensi->status)) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600">{{ $presensi->keterangan ?: '-' }}</p>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm">Belum ada presensi hari ini</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>