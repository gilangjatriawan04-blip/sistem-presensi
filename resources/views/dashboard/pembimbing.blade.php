<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard Pembimbing') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Monitoring Peserta Magang</h3>
                    
                    <div class="mb-6">
                        <div class="flex items-center mb-2">
                            <svg class="h-6 w-6 text-blue-500 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <span class="text-lg font-semibold">Total Peserta: {{ $total_bimbingan }}</span>
                        </div>
                    </div>

                    <h4 class="font-medium text-gray-700 mb-3">Presensi Hari Ini ({{ $today }})</h4>
                    
                    @if($presensi_hari_ini->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Institusi</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jam Masuk</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
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
                                                <div>{{ $presensi->user->institution_name ?: '-' }}</div>
                                                <div class="text-sm text-gray-600">{{ $presensi->user->institution_class ?: '' }}</div>
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                @if($presensi->jam_masuk)
                                                    {{ $presensi->jam_masuk->format('H:i') }}
                                                @else
                                                    <span class="text-red-600">Belum presensi</span>
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
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-gray-600">Belum ada presensi hari ini.</p>
                    @endif
                    
                    <div class="mt-6">
                        <a href="{{ route('pembimbing.monitoring') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                            Lihat Detail Monitoring
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>