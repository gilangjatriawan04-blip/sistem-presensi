<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Presensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold">Riwayat Presensi Anda</h3>
                        <a href="{{ route('presensi.index') }}" class="text-blue-600 hover:text-blue-800 text-sm">
                            ← Kembali ke Presensi
                        </a>
                    </div>
                    
                    @if($presensis->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Pulang</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Total Jam</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($presensis as $presensi)
                                        <tr>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($presensi->tanggal)->format('d/m/Y') }}
                                                <br>
                                                <span class="text-xs text-gray-500">
                                                    {{ \Carbon\Carbon::parse($presensi->tanggal)->isoFormat('dddd') }}
                                                </span>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($presensi->jam_masuk)
                                                    {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i') }}
                                                    @if($presensi->terlambat_menit > 0)
                                                        <br>
                                                        <span class="text-xs text-red-600">
                                                            +{{ $presensi->terlambat_menit }}m
                                                        </span>
                                                    @endif
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($presensi->jam_pulang)
                                                    {{ \Carbon\Carbon::parse($presensi->jam_pulang)->format('H:i') }}
                                                    @if($presensi->pulang_cepat_menit > 0)
                                                        <br>
                                                        <span class="text-xs text-yellow-600">
                                                            -{{ $presensi->pulang_cepat_menit }}m
                                                        </span>
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
                                                        'izin' => 'bg-blue-100 text-blue-800',
                                                        'sakit' => 'bg-purple-100 text-purple-800',
                                                        'tugas_luar' => 'bg-indigo-100 text-indigo-800',
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
                                                    {{ floor($presensi->total_kerja_menit / 60) }}j 
                                                    {{ $presensi->total_kerja_menit % 60 }}m
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td class="px-4 py-3">
                                                {{ $presensi->keterangan ?: '-' }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $presensis->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            <p class="mt-2 text-gray-600">Belum ada riwayat presensi.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>