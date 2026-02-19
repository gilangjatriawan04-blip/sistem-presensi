<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Izin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notifications -->
            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            <!-- Header dengan Tombol -->
            <div class="mb-6 flex justify-between items-center">
                <div>
                    <h3 class="text-lg font-semibold">Daftar Pengajuan Izin Anda</h3>
                    <p class="text-sm text-gray-600">Status dan riwayat izin</p>
                </div>
                <a href="{{ route('izin.create') }}" 
                   class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                    + Ajukan Izin Baru
                </a>
            </div>
            
            <!-- Table List Izin -->
            <div class="bg-white rounded-lg shadow overflow-hidden">
                @if(isset($izins) && $izins->count() > 0)
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Jenis</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Diajukan</th>
                                <th class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($izins as $izin)
                            <tr>
                                <td class="px-4 py-3">
                                    @if($izin->jenis_izin == 'izin') 
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded">Izin</span>
                                    @elseif($izin->jenis_izin == 'sakit')
                                        <span class="px-2 py-1 bg-purple-100 text-purple-800 text-xs rounded">Sakit</span>
                                    @elseif($izin->jenis_izin == 'izin_terlambat')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">Izin Telat</span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-800 text-xs rounded">{{ $izin->jenis_izin }}</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    {{ date('d/m/Y', strtotime($izin->tanggal_mulai)) }}
                                    @if($izin->tanggal_mulai != $izin->tanggal_selesai)
                                        - {{ date('d/m/Y', strtotime($izin->tanggal_selesai)) }}
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    @if($izin->status_approval == 'pending')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-800 text-xs rounded">Menunggu</span>
                                    @elseif($izin->status_approval == 'disetujui')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 text-xs rounded">Disetujui</span>
                                    @else
                                        <span class="px-2 py-1 bg-red-100 text-red-800 text-xs rounded">Ditolak</span>
                                    @endif
                                </td>
                                <td class="px-4 py-3">
                                    {{ date('d/m/Y H:i', strtotime($izin->created_at)) }}
                                </td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('izin.show', $izin) }}" class="text-blue-600 hover:text-blue-900">
                                        Lihat
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <!-- Pagination -->
                    <div class="px-4 py-3 border-t">
                        {{ $izins->links() }}
                    </div>
                @else
                    <!-- Kosong -->
                    <div class="p-8 text-center">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        <h3 class="mt-4 text-lg font-medium">Belum ada pengajuan izin</h3>
                        <p class="mt-1 text-gray-600">Mulai dengan mengajukan izin pertama Anda</p>
                        <div class="mt-4">
                            <a href="{{ route('izin.create') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                                Ajukan Izin Pertama
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>