<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Peserta Magang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card: Status Hari Ini -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Status Hari Ini</h3>
                            @if($presensi_hari_ini)
                                @if($presensi_hari_ini->jam_masuk && !$presensi_hari_ini->jam_pulang)
                                    <p class="text-green-600 font-bold">Sudah Check-in</p>
                                    <p class="text-sm text-gray-600">{{ $presensi_hari_ini->jam_masuk->format('H:i') }}</p>
                                @elseif($presensi_hari_ini->jam_pulang)
                                    <p class="text-blue-600 font-bold">Sudah Check-out</p>
                                    <p class="text-sm text-gray-600">{{ $presensi_hari_ini->jam_masuk->format('H:i') }} - {{ $presensi_hari_ini->jam_pulang->format('H:i') }}</p>
                                @endif
                            @else
                                <p class="text-red-600 font-bold">Belum Presensi</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Card: Total Kehadiran -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Total Kehadiran</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $total_hadir }}</p>
                            <p class="text-sm text-gray-600">Hari kerja</p>
                        </div>
                    </div>
                </div>

                <!-- Card: Keterlambatan -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Keterlambatan</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $total_terlambat }}</p>
                            <p class="text-sm text-gray-600">Kali terlambat</p>
                        </div>
                    </div>
                </div>

                <!-- Card: Sisa Magang -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Sisa Magang</h3>
                            @if(isset($sisa_hari_magang))
                                <p class="text-2xl font-bold text-gray-900">{{ $sisa_hari_magang }}</p>
                                <p class="text-sm text-gray-600">Hari tersisa</p>
                            @else
                                <p class="text-gray-600">Belum diatur</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Presensi Hari Ini -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Presensi Hari Ini ({{ $today }})</h3>
                    
                    @if($presensi_hari_ini)
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <h4 class="font-medium text-gray-700">Check-in</h4>
                                <p class="text-lg">
                                    @if($presensi_hari_ini->jam_masuk)
                                        {{ $presensi_hari_ini->jam_masuk->format('H:i:s') }}
                                        <span class="text-sm {{ $presensi_hari_ini->status == 'terlambat' ? 'text-red-600' : 'text-green-600' }}">
                                            ({{ $presensi_hari_ini->status == 'terlambat' ? 'Terlambat' : 'Tepat waktu' }})
                                        </span>
                                    @else
                                        <span class="text-red-600">Belum check-in</span>
                                    @endif
                                </p>
                            </div>
                            
                            <div>
                                <h4 class="font-medium text-gray-700">Check-out</h4>
                                <p class="text-lg">
                                    @if($presensi_hari_ini->jam_pulang)
                                        {{ $presensi_hari_ini->jam_pulang->format('H:i:s') }}
                                    @else
                                        <span class="text-yellow-600">Belum check-out</span>
                                    @endif
                                </p>
                            </div>
                            
                            @if($presensi_hari_ini->keterangan)
                                <div class="col-span-2">
                                    <h4 class="font-medium text-gray-700">Keterangan</h4>
                                    <p>{{ $presensi_hari_ini->keterangan }}</p>
                                </div>
                            @endif
                        </div>
                    @else
                        <p class="text-gray-600">Belum ada presensi hari ini.</p>
                        <a href="{{ route('presensi.index') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Presensi Sekarang
                        </a>
                    @endif
                </div>
            </div>

            <!-- Riwayat Bulan Ini -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Riwayat Presensi Bulan Ini</h3>
                    
                    @if($presensi_bulan_ini->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Jam</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($presensi_bulan_ini as $presensi)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">{{ $presensi->tanggal->format('d/m/Y') }}</td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($presensi->jam_masuk)
                                                    {{ $presensi->jam_masuk->format('H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($presensi->jam_pulang)
                                                    {{ $presensi->jam_pulang->format('H:i') }}
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @php
                                                    $statusColors = [
                                                        'tepat_waktu' => 'bg-green-100 text-green-800',
                                                        'terlambat' => 'bg-yellow-100 text-yellow-800',
                                                        'pulang_cepat' => 'bg-orange-100 text-orange-800',
                                                        'izin' => 'bg-blue-100 text-blue-800',
                                                        'sakit' => 'bg-purple-100 text-purple-800',
                                                        'alpha' => 'bg-red-100 text-red-800',
                                                    ];
                                                    $colorClass = $statusColors[$presensi->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $colorClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $presensi->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($presensi->total_kerja_menit > 0)
                                                    {{ floor($presensi->total_kerja_menit / 60) }} jam {{ $presensi->total_kerja_menit % 60 }} menit
                                                @else
                                                    -
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600">Belum ada riwayat presensi bulan ini.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
