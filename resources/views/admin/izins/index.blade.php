<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Persetujuan Izin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-yellow-100 p-3 rounded-full">
                            <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">Pending</h3>
                            <p class="text-2xl font-bold">{{ $stats['pending'] }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-green-100 p-3 rounded-full">
                            <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">Disetujui</h3>
                            <p class="text-2xl font-bold">{{ $stats['disetujui'] }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-red-100 p-3 rounded-full">
                            <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">Ditolak</h3>
                            <p class="text-2xl font-bold">{{ $stats['ditolak'] }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="bg-white rounded-lg shadow p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 bg-blue-100 p-3 rounded-full">
                            <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div class="ml-4">
                            <h3 class="text-lg font-semibold">Total</h3>
                            <p class="text-2xl font-bold">{{ $stats['total'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Filter Tabs -->
            <div class="mb-6 bg-white rounded-lg shadow">
                <div class="border-b">
                    <nav class="flex -mb-px">
                        <a href="{{ route('admin.izin.index', ['status' => 'pending']) }}" 
                           class="{{ $status == 'pending' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-6 text-center border-b-2 font-medium">
                            Pending ({{ $stats['pending'] }})
                        </a>
                        <a href="{{ route('admin.izin.index', ['status' => 'disetujui']) }}" 
                           class="{{ $status == 'disetujui' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-6 text-center border-b-2 font-medium">
                            Disetujui ({{ $stats['disetujui'] }})
                        </a>
                        <a href="{{ route('admin.izin.index', ['status' => 'ditolak']) }}" 
                           class="{{ $status == 'ditolak' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-6 text-center border-b-2 font-medium">
                            Ditolak ({{ $stats['ditolak'] }})
                        </a>
                        <a href="{{ route('admin.izin.index', ['status' => 'all']) }}" 
                           class="{{ $status == 'all' ? 'border-blue-500 text-blue-600' : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }} py-4 px-6 text-center border-b-2 font-medium">
                            Semua
                        </a>
                    </nav>
                </div>
                
                <!-- Izin List -->
                <div class="p-6">
                    @if($izins->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Pemohon</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Periode</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Diajukan</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        <th class="px-4 py-3 bg-gray-50 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($izins as $izin)
                                        <tr class="hover:bg-gray-50">
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <div class="font-medium">{{ $izin->user->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $izin->user->institution_name }}</div>
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
                                                {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y') }}
                                                @if($izin->tanggal_mulai != $izin->tanggal_selesai)
                                                    - {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y') }}
                                                @endif
                                            </td>
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                {{ $izin->created_at->format('d/m/Y H:i') }}
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
                                            <td class="px-4 py-3 whitespace-nowrap">
                                                <a href="{{ route('admin.izin.show', $izin) }}" 
                                                   class="text-blue-600 hover:text-blue-900 mr-3">
                                                    Lihat
                                                </a>
                                                @if($izin->file_bukti)
                                                    <a href="{{ route('admin.izin.download', $izin) }}" 
                                                       class="text-green-600 hover:text-green-900">
                                                        Download
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="mt-6">
                            {{ $izins->links() }}
                        </div>
                    @else
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <h3 class="mt-4 text-lg font-medium text-gray-900">Tidak ada data izin</h3>
                            <p class="mt-1 text-sm text-gray-600">
                                @if($status == 'pending')
                                    Tidak ada izin yang menunggu persetujuan.
                                @elseif($status == 'disetujui')
                                    Belum ada izin yang disetujui.
                                @elseif($status == 'ditolak')
                                    Belum ada izin yang ditolak.
                                @else
                                    Belum ada data izin.
                                @endif
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>