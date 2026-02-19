<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Peserta') }}
            </h2>
            <div class="flex items-center space-x-2">
                <!-- Status Badge -->
                @if(isset($presensi_hari_ini) && $presensi_hari_ini)
                    @if($presensi_hari_ini->jam_masuk && !$presensi_hari_ini->jam_pulang)
                        <span class="bg-green-100 text-green-800 text-xs px-3 py-1.5 rounded-full font-medium flex items-center">
                            <span class="w-2 h-2 bg-green-500 rounded-full mr-2 animate-pulse"></span>
                            Sedang Presensi
                        </span>
                    @elseif($presensi_hari_ini->jam_pulang)
                        <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1.5 rounded-full font-medium">
                            ✅ Sudah Pulang
                        </span>
                    @endif
                @else
                    <span class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1.5 rounded-full font-medium">
                        ⏰ Belum Presensi
                    </span>
                @endif
                <span class="bg-green-100 text-green-800 text-xs px-3 py-1.5 rounded-full font-medium">
                    {{ now()->format('l, d F Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Statistik Cards (Theme Hijau) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Card Status Hari Ini -->
                <div class="bg-white rounded-2xl shadow-md border border-green-100 p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Status Hari Ini</p>
                            @if(isset($presensi_hari_ini) && $presensi_hari_ini)
                                @if($presensi_hari_ini->jam_masuk && !$presensi_hari_ini->jam_pulang)
                                    <p class="text-2xl font-bold text-green-600">Check-in</p>
                                    <p class="text-xs text-gray-500 mt-2">{{ \Carbon\Carbon::parse($presensi_hari_ini->jam_masuk)->format('H:i') }}</p>
                                @elseif($presensi_hari_ini->jam_pulang)
                                    <p class="text-2xl font-bold text-blue-600">Selesai</p>
                                    <p class="text-xs text-gray-500 mt-2">{{ \Carbon\Carbon::parse($presensi_hari_ini->jam_pulang)->format('H:i') }}</p>
                                @endif
                            @else
                                <p class="text-2xl font-bold text-yellow-600">Belum</p>
                                <p class="text-xs text-gray-500 mt-2">Belum ada presensi</p>
                            @endif
                        </div>
                        <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Card Total Hadir -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Hadir</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $total_hadir ?? 0 }}</p>
                            <p class="text-xs text-green-600 mt-2">+12% bulan ini</p>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Card Keterlambatan -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Keterlambatan</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $total_terlambat ?? 0 }}</p>
                            <p class="text-xs text-gray-500 mt-2">Total kali</p>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Card Sisa Magang -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Sisa Magang</p>
                            @if(isset($sisa_hari_magang))
                                <p class="text-3xl font-bold text-purple-600">{{ $sisa_hari_magang }} <span class="text-sm font-normal">hari</span></p>
                                <p class="text-xs text-gray-500 mt-2">sampai {{ \Carbon\Carbon::parse(auth()->user()->end_date)->format('d M Y') }}</p>
                            @else
                                <p class="text-lg font-bold text-gray-400">Belum diatur</p>
                            @endif
                        </div>
                        <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions (2 tombol besar) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <a href="{{ route('presensi.index') }}" class="bg-gradient-to-r from-green-500 to-green-600 rounded-2xl p-8 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="text-2xl font-bold mb-2">Presensi Sekarang</p>
                    <p class="text-green-100">Check-in / Check-out harian</p>
                </a>
                
                <a href="{{ route('izin.create') }}" class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-8 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105 text-center">
                    <svg class="w-16 h-16 mx-auto mb-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="text-2xl font-bold mb-2">Ajukan Izin</p>
                    <p class="text-blue-100">Izin / Sakit / Tugas Luar</p>
                </a>
            </div>

            <!-- Riwayat Presensi (5 Terakhir) -->
            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-700 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Riwayat Presensi Terakhir
                    </h3>
                    <a href="{{ route('presensi.riwayat') }}" class="text-sm text-green-600 hover:text-green-800">
                        Lihat Semua →
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Masuk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Pulang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Total Jam</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($presensi_bulan_ini->take(5) as $presensi)
                            <tr class="hover:bg-green-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($presensi->tanggal)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($presensi->jam_masuk)
                                        <span class="font-medium">{{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }}</span>
                                        @if($presensi->terlambat_menit > 0)
                                            <span class="text-xs text-red-500 block">+{{ $presensi->terlambat_menit }}m</span>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($presensi->jam_pulang)
                                        {{ \Carbon\Carbon::parse($presensi->jam_pulang)->format('H:i') }}
                                    @else
                                        <span class="text-gray-400">-</span>
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
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($presensi->total_kerja_menit > 0)
                                        {{ floor($presensi->total_kerja_menit / 60) }}j {{ $presensi->total_kerja_menit % 60 }}m
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <p class="text-sm">Belum ada riwayat presensi</p>
                                    <a href="{{ route('presensi.index') }}" class="text-green-600 hover:text-green-800 text-sm mt-2 inline-block">
                                        Presensi Sekarang →
                                    </a>
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