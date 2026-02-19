<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard Pembimbing') }}
            </h2>
            <span class="bg-purple-100 text-purple-800 text-xs px-3 py-1.5 rounded-full font-medium">
                {{ now()->format('l, d F Y') }}
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Statistik Cards (Theme Ungu) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                
                <!-- Card Total Peserta -->
                <div class="bg-white rounded-2xl shadow-md border border-purple-100 p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Total Peserta</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $totalPeserta ?? 0 }}</p>
                            <p class="text-xs text-purple-600 mt-2">Bimbingan</p>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 1.197h-6" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Card Presensi Hari Ini -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Presensi Hari Ini</p>
                            <p class="text-3xl font-bold text-gray-800">{{ $presensiHariIni ?? 0 }}</p>
                            <p class="text-xs text-green-600 mt-2">dari {{ $totalPeserta ?? 0 }} peserta</p>
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
                            <p class="text-3xl font-bold text-yellow-600">{{ $izinPending ?? 0 }}</p>
                            <a href="{{ route('pembimbing.izin') }}" class="text-xs text-blue-600 hover:text-blue-800 mt-2 block">
                                Lihat →
                            </a>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-yellow-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <!-- Card Peserta Aktif -->
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 hover:shadow-lg transition-all duration-300 hover:scale-105">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium text-gray-500 mb-1">Peserta Aktif</p>
                            <p class="text-3xl font-bold text-purple-600">{{ $pesertaAktif ?? 0 }}</p>
                            <p class="text-xs text-gray-500 mt-2">sedang magang</p>
                        </div>
                        <div class="w-14 h-14 rounded-full bg-purple-100 flex items-center justify-center">
                            <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions (2 tombol besar) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <a href="{{ route('pembimbing.peserta') }}" 
                   class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-xl mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 1.197h-6" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Daftar Peserta</h3>
                            <p class="text-purple-100">Lihat dan monitor semua peserta magang</p>
                        </div>
                    </div>
                </a>
                
                <a href="{{ route('pembimbing.izin') }}" 
                   class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl p-6 text-white shadow-lg hover:shadow-xl transition-all hover:scale-105">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-xl mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold">Monitoring Izin</h3>
                            <p class="text-yellow-100">Lihat pengajuan izin peserta</p>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Grafik Presensi -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-700 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Grafik Presensi 7 Hari Terakhir
                    </h3>
                </div>
                
                <div class="p-6">
                    @if(isset($chartData) && count($chartData) > 0)
                        <div class="flex items-end space-x-2 h-48">
                            @foreach($chartLabels as $index => $label)
                                @php
                                    $max = max($chartData) ?: 1;
                                    $height = ($chartData[$index] / $max) * 100;
                                @endphp
                                <div class="flex-1 flex flex-col items-center group">
                                    <div class="relative w-full">
                                        <div class="w-full bg-purple-200 rounded-t-lg relative transition-all duration-300 group-hover:bg-purple-300" 
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
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <p class="text-sm">Belum ada data presensi untuk 7 hari terakhir</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Daftar Peserta (5 Terbaru) -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200 flex justify-between items-center">
                    <h3 class="font-semibold text-gray-700 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 1.197h-6" />
                        </svg>
                        Daftar Peserta Bimbingan
                    </h3>
                    <a href="{{ route('pembimbing.peserta') }}" class="text-sm text-purple-600 hover:text-purple-800">
                        Lihat Semua →
                    </a>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Peserta</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Institusi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($pesertaTerbaru ?? [] as $peserta)
                            <tr class="hover:bg-purple-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-purple-400 to-purple-500 flex items-center justify-center text-white font-bold text-sm mr-3 overflow-hidden">
                                            @if($peserta->avatar)
                                                <img src="{{ asset('storage/' . $peserta->avatar) }}" class="w-full h-full object-cover">
                                            @else
                                                {{ strtoupper(substr($peserta->name, 0, 1)) }}
                                            @endif
                                        </div>
                                        <div>
                                            <div class="text-sm font-medium">{{ $peserta->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $peserta->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <p class="text-sm">{{ $peserta->institution_name ?? '-' }}</p>
                                    <p class="text-xs text-gray-500">{{ $peserta->institution_class ?? '' }}</p>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($peserta->start_date && $peserta->end_date)
                                        <p class="text-xs">{{ \Carbon\Carbon::parse($peserta->start_date)->format('d/m/Y') }}</p>
                                        <p class="text-xs text-gray-500">s/d {{ \Carbon\Carbon::parse($peserta->end_date)->format('d/m/Y') }}</p>
                                    @else
                                        <span class="text-xs text-gray-400">Belum diatur</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $today = now();
                                        $isAktif = $peserta->start_date && $peserta->end_date && 
                                                  $peserta->start_date <= $today && 
                                                  $peserta->end_date >= $today;
                                    @endphp
                                    @if($isAktif)
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">Aktif</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded-full">Tidak Aktif</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <a href="{{ route('pembimbing.peserta.detail', $peserta->id) }}" 
                                       class="text-purple-600 hover:text-purple-900 text-sm font-medium">
                                        Detail
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 1.197h-6" />
                                    </svg>
                                    <p class="text-sm">Belum ada peserta bimbingan</p>
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