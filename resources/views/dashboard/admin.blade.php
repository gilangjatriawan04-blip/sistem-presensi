<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card: Total User -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 1.197h-6" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Total User</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $total_users }}</p>
                            <p class="text-sm text-gray-600">User terdaftar</p>
                        </div>
                    </div>
                </div>

                <!-- Card: Presensi Hari Ini -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Presensi Hari Ini</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $total_presensi_hari_ini }}</p>
                            <p class="text-sm text-gray-600">Total check-in</p>
                        </div>
                    </div>
                </div>

                <!-- Card: Izin Pending -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 text-yellow-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Izin Pending</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $total_izin_pending }}</p>
                            <p class="text-sm text-gray-600">Menunggu persetujuan</p>
                        </div>
                    </div>
                </div>

                <!-- Card: Magang Aktif -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-10 w-10 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Magang Aktif</h3>
                            <p class="text-2xl font-bold text-gray-900">{{ $users_magang_aktif }}</p>
                            <p class="text-sm text-gray-600">Peserta aktif</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Presensi Hari Ini -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Presensi Hari Ini ({{ $today }})</h3>
                    
                    @if($presensi_hari_ini->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($presensi_hari_ini as $presensi)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="font-medium">{{ $presensi->user->name }}</div>
                                                <div class="text-sm text-gray-600">{{ $presensi->user->email }}</div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($presensi->jam_masuk)
                                                    {{ $presensi->jam_masuk->format('H:i') }}
                                                    @if($presensi->terlambat_menit > 0)
                                                        <span class="text-red-600 text-sm">(+{{ $presensi->terlambat_menit }}m)</span>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($presensi->jam_pulang)
                                                    {{ $presensi->jam_pulang->format('H:i') }}
                                                    @if($presensi->pulang_cepat_menit > 0)
                                                        <span class="text-yellow-600 text-sm">(-{{ $presensi->pulang_cepat_menit }}m)</span>
                                                    @endif
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
                                                    ];
                                                    $colorClass = $statusColors[$presensi->status] ?? 'bg-gray-100 text-gray-800';
                                                @endphp
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $colorClass }}">
                                                    {{ ucfirst(str_replace('_', ' ', $presensi->status)) }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $presensi->keterangan ?: '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600">Belum ada presensi hari ini.</p>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('admin.users.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:bg-gray-50 transition duration-150 ease-in-out border border-transparent hover:border-gray-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-blue-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 1.197h-6" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Manajemen User</h3>
                            <p class="text-sm text-gray-600">Kelola data pengguna</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.izins.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:bg-gray-50 transition duration-150 ease-in-out border border-transparent hover:border-gray-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Persetujuan Izin</h3>
                            <p class="text-sm text-gray-600">Review pengajuan izin</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('admin.reports.index') }}" class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 hover:bg-gray-50 transition duration-150 ease-in-out border border-transparent hover:border-gray-300">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <svg class="h-8 w-8 text-purple-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold text-gray-900">Laporan</h3>
                            <p class="text-sm text-gray-600">Generate laporan presensi</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>