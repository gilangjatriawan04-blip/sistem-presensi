<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pengajuan Izin') }}
            </h2>
            <a href="{{ route('izin.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Status Badge -->
            <div class="mb-6 flex justify-between items-center">
                <div class="flex items-center space-x-2">
                    <span class="text-sm text-gray-500">Status:</span>
                    @php
                        $statusColors = [
                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                            'disetujui' => 'bg-green-100 text-green-800 border-green-200',
                            'ditolak' => 'bg-red-100 text-red-800 border-red-200',
                        ];
                        $statusLabels = [
                            'pending' => 'Menunggu',
                            'disetujui' => 'Disetujui',
                            'ditolak' => 'Ditolak',
                        ];
                    @endphp
                    <span class="px-3 py-1 text-sm font-medium rounded-full border {{ $statusColors[$izin->status_approval] }}">
                        {{ $statusLabels[$izin->status_approval] }}
                    </span>
                </div>
                <span class="text-sm text-gray-500">No. #{{ $izin->id }}</span>
            </div>

            <!-- Main Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <!-- Header Izin -->
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                    <h3 class="font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Informasi Izin
                    </h3>
                </div>
                
                <div class="p-6">
                    <!-- Informasi Izin -->
                    <div class="grid grid-cols-2 gap-6 mb-6">
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Jenis Izin</p>
                            @php
                                $jenisLabels = [
                                    'izin' => 'Izin',
                                    'sakit' => 'Sakit',
                                    'izin_terlambat' => 'Izin Terlambat',
                                    'tugas_luar' => 'Tugas Luar',
                                ];
                            @endphp
                            <p class="font-medium">{{ $jenisLabels[$izin->jenis_izin] ?? $izin->jenis_izin }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Periode Izin</p>
                            <p class="font-medium">
                                {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y') }}
                                @if($izin->tanggal_mulai != $izin->tanggal_selesai)
                                    - {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y') }}
                                @endif
                            </p>
                        </div>
                        @if($izin->jam_izin_terlambat)
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Estimasi Datang</p>
                            <p class="font-medium">{{ \Carbon\Carbon::parse($izin->jam_izin_terlambat)->format('H:i') }}</p>
                        </div>
                        @endif
                        <div>
                            <p class="text-sm text-gray-500 mb-1">Diajukan Pada</p>
                            <p class="font-medium">{{ $izin->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>

                    <!-- Alasan -->
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-2">Alasan</p>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <p class="text-gray-700">{{ $izin->alasan }}</p>
                        </div>
                    </div>

                    <!-- File Bukti -->
                    @if($izin->file_bukti)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-2">File Bukti</p>
                        <div class="bg-gray-50 rounded-xl p-4">
                            <a href="{{ route('izin.download', $izin) }}" 
                               class="inline-flex items-center text-blue-600 hover:text-blue-800">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download File
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Catatan Admin (Jika Ada) -->
                    @if($izin->catatan_admin)
                    <div class="mb-6">
                        <p class="text-sm text-gray-500 mb-2">Catatan Admin</p>
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <p class="text-blue-700">{{ $izin->catatan_admin }}</p>
                            @if($izin->approvedBy)
                            <p class="text-xs text-gray-500 mt-2">
                                - {{ $izin->approvedBy->name }}, {{ \Carbon\Carbon::parse($izin->approved_at)->format('d/m/Y H:i') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    @endif

                    <!-- Status Timeline -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <p class="text-sm text-gray-500 mb-4">Riwayat Status</p>
                        <div class="relative">
                            <!-- Timeline Item: Pengajuan -->
                            <div class="flex items-start mb-4">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">Pengajuan Dibuat</p>
                                    <p class="text-sm text-gray-500">{{ $izin->created_at->format('d/m/Y H:i') }}</p>
                                </div>
                            </div>
                            
                            <!-- Timeline Item: Approval (Jika sudah) -->
                            @if($izin->status_approval != 'pending')
                            <div class="flex items-start">
                                <div class="flex-shrink-0 w-8 h-8 rounded-full {{ $izin->status_approval == 'disetujui' ? 'bg-green-100' : 'bg-red-100' }} flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 {{ $izin->status_approval == 'disetujui' ? 'text-green-600' : 'text-red-600' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        @if($izin->status_approval == 'disetujui')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                        @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                        @endif
                                    </svg>
                                </div>
                                <div>
                                    <p class="font-medium text-gray-900">
                                        {{ $izin->status_approval == 'disetujui' ? 'Disetujui' : 'Ditolak' }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        oleh {{ $izin->approvedBy->name ?? 'Admin' }} 
                                        pada {{ \Carbon\Carbon::parse($izin->approved_at)->format('d/m/Y H:i') }}
                                    </p>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>