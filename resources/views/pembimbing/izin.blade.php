<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Monitoring Izin Peserta') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Filter Tabs -->
            <div class="bg-white rounded-lg shadow mb-6">
                <div class="border-b">
                    <nav class="flex -mb-px">
                        <a href="{{ route('pembimbing.izin', ['status' => 'pending']) }}" 
                           class="{{ $status == 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-6 text-center border-b-2 font-medium">
                            Pending
                        </a>
                        <a href="{{ route('pembimbing.izin', ['status' => 'disetujui']) }}" 
                           class="{{ $status == 'disetujui' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-6 text-center border-b-2 font-medium">
                            Disetujui
                        </a>
                        <a href="{{ route('pembimbing.izin', ['status' => 'ditolak']) }}" 
                           class="{{ $status == 'ditolak' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-6 text-center border-b-2 font-medium">
                            Ditolak
                        </a>
                        <a href="{{ route('pembimbing.izin', ['status' => 'all']) }}" 
                           class="{{ $status == 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-6 text-center border-b-2 font-medium">
                            Semua
                        </a>
                    </nav>
                </div>
                
                <div class="p-6">
                    @if($izins->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pemohon</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Alasan</th>
                                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($izins as $izin)
                                    <tr>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            <div class="font-medium">{{ $izin->user->name }}</div>
                                            <div class="text-xs text-gray-500">{{ $izin->user->institution_name }}</div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @php
                                                $jenisLabels = [
                                                    'izin' => 'Izin',
                                                    'sakit' => 'Sakit',
                                                    'izin_terlambat' => 'Izin Terlambat',
                                                    'tugas_luar' => 'Tugas Luar'
                                                ];
                                            @endphp
                                            {{ $jenisLabels[$izin->jenis_izin] ?? $izin->jenis_izin }}
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            {{ Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y') }}
                                            @if($izin->tanggal_mulai != $izin->tanggal_selesai)
                                                <br>
                                                <span class="text-xs text-gray-500">s.d {{ Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y') }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3">
                                            <div class="max-w-xs truncate">{{ $izin->alasan }}</div>
                                        </td>
                                        <td class="px-4 py-3 whitespace-nowrap">
                                            @php
                                                $statusColors = [
                                                    'pending' => 'bg-yellow-100 text-yellow-800',
                                                    'disetujui' => 'bg-green-100 text-green-800',
                                                    'ditolak' => 'bg-red-100 text-red-800',
                                                ];
                                            @endphp
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$izin->status_approval] }}">
                                                {{ ucfirst($izin->status_approval) }}
                                            </span>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mt-6">
                            {{ $izins->links() }}
                        </div>
                    @else
                        <div class="text-center py-8">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <p class="mt-2 text-gray-600">Tidak ada data izin.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>