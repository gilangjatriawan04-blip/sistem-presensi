<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Peserta') }}
            </h2>
            <a href="{{ route('pembimbing.peserta') }}" class="text-purple-600 hover:text-purple-800 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- User Profile Card -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-8 mb-6 text-white shadow-lg">
                <div class="flex items-center">
                    <div class="w-20 h-20 rounded-full bg-white/20 flex items-center justify-center text-3xl font-bold mr-6 border-4 border-white/30">
                        {{ strtoupper(substr($peserta->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <h1 class="text-2xl font-bold mb-2">{{ $peserta->name }}</h1>
                        <p class="text-purple-100 mb-3">{{ $peserta->email }}</p>
                        <div class="flex items-center space-x-4 text-sm">
                            <span class="bg-white/20 px-3 py-1 rounded-full">{{ $peserta->jenis_peserta ?? 'Peserta' }}</span>
                            <span class="bg-white/20 px-3 py-1 rounded-full">{{ $peserta->institution_name ?? '-' }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Info Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Hadir</p>
                            <p class="text-3xl font-bold text-green-600">{{ $totalHadir ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Terlambat</p>
                            <p class="text-3xl font-bold text-yellow-600">{{ $totalTerlambat ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Total Izin</p>
                            <p class="text-3xl font-bold text-blue-600">{{ $totalIzin ?? 0 }}</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Kehadiran</p>
                            @php
                                $total = ($totalHadir ?? 0) + ($totalIzin ?? 0);
                                $persentase = $total > 0 ? round(($totalHadir ?? 0) / $total * 100) : 0;
                            @endphp
                            <p class="text-3xl font-bold text-purple-600">{{ $persentase }}%</p>
                        </div>
                        <div class="w-12 h-12 rounded-full bg-purple-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z" />
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Riwayat Presensi -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-700 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                        Riwayat Presensi (30 Hari Terakhir)
                    </h3>
                </div>
                
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Masuk</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jam Pulang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($presensis as $presensi)
                            <tr class="hover:bg-purple-50 transition">
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
                                <td class="px-6 py-4">
                                    <p class="text-sm text-gray-600">{{ $presensi->keterangan ?: '-' }}</p>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                    <p class="text-sm">Belum ada riwayat presensi</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Catatan Akhir Magang -->
<div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mt-6">
    <div class="px-6 py-4 bg-gradient-to-r from-purple-500 to-purple-600">
        <h3 class="font-semibold text-white flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
            Catatan Akhir Magang
        </h3>
    </div>
    
    <div class="p-6">
        <form action="{{ route('pembimbing.catatan.update', $peserta->id) }}" method="POST">
            @csrf
            @method('PATCH')
            
            <textarea name="catatan_pembimbing" rows="4" 
                      class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-purple-500 focus:border-purple-500"
                      placeholder="Tulis catatan untuk peserta magang ini...">{{ $peserta->catatan_pembimbing }}</textarea>
            
            <div class="flex justify-end mt-4">
                <button type="submit" 
                        class="px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-xl hover:from-purple-600 hover:to-purple-700 transition font-medium shadow-md">
                    Simpan Catatan
                </button>
            </div>
        </form>
        
        @if($peserta->catatan_pembimbing)
            <div class="mt-4 p-4 bg-purple-50 rounded-xl">
                <h4 class="font-semibold text-purple-800 mb-2">Catatan Tersimpan:</h4>
                <p class="text-gray-700">{{ $peserta->catatan_pembimbing }}</p>
            </div>
        @endif
    </div>
</div>
</x-app-layout>