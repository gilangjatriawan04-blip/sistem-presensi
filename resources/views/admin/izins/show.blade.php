<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Detail Pengajuan Izin') }}
            </h2>
            <a href="{{ route('admin.izin.index') }}" class="text-blue-600 hover:text-blue-800 flex items-center">
                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
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
                <span class="text-sm text-gray-500">ID: #{{ $izin->id }}</span>
            </div>

            <!-- User Info Card -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 mb-6 text-white shadow-lg">
                <div class="flex items-center">
                    <div class="w-16 h-16 rounded-full bg-white/20 flex items-center justify-center text-2xl font-bold mr-4">
                        {{ strtoupper(substr($izin->user->name, 0, 1)) }}
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-semibold mb-1">{{ $izin->user->name }}</h3>
                        <p class="text-blue-100 text-sm mb-2">{{ $izin->user->email }}</p>
                        <div class="flex items-center space-x-2 text-sm text-blue-100">
                            <span>{{ $izin->user->institution_name ?? '-' }}</span>
                            @if($izin->user->institution_class)
                                <span>•</span>
                                <span>{{ $izin->user->institution_class }}</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <!-- Left Column - Izin Details -->
                <div class="md:col-span-2 space-y-6">
                    <!-- Izin Info Card -->
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                Informasi Izin
                            </h3>
                        </div>
                        <div class="p-6">
                            <div class="grid grid-cols-2 gap-6">
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Jenis Izin</p>
                                    @php
                                        $jenisColors = [
                                            'izin' => 'bg-blue-100 text-blue-800',
                                            'sakit' => 'bg-red-100 text-red-800',
                                            'izin_terlambat' => 'bg-yellow-100 text-yellow-800',
                                            'tugas_luar' => 'bg-purple-100 text-purple-800',
                                        ];
                                        $jenisLabels = [
                                            'izin' => 'Izin',
                                            'sakit' => 'Sakit',
                                            'izin_terlambat' => 'Izin Terlambat',
                                            'tugas_luar' => 'Tugas Luar',
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 text-sm font-medium rounded-full {{ $jenisColors[$izin->jenis_izin] }}">
                                        {{ $jenisLabels[$izin->jenis_izin] }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500 mb-1">Periode Izin</p>
                                    <p class="font-medium">
                                        {{ \Carbon\Carbon::parse($izin->tanggal_mulai)->format('d/m/Y') }}
                                        @if($izin->tanggal_mulai != $izin->tanggal_selesai)
                                            - {{ \Carbon\Carbon::parse($izin->tanggal_selesai)->format('d/m/Y') }}
                                        @endif
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">
                                        {{ Carbon\Carbon::parse($izin->tanggal_mulai)->diffInDays($izin->tanggal_selesai) + 1 }} hari
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
                        </div>
                    </div>

                    <!-- Alasan Card -->
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                </svg>
                                Alasan
                            </h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700 whitespace-pre-line">{{ $izin->alasan }}</p>
                        </div>
                    </div>

                    <!-- Catatan Admin (Jika ada) -->
                    @if($izin->catatan_admin)
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                </svg>
                                Catatan Admin
                            </h3>
                        </div>
                        <div class="p-6">
                            <p class="text-gray-700">{{ $izin->catatan_admin }}</p>
                            @if($izin->approvedBy)
                            <p class="text-xs text-gray-500 mt-2">
                                - {{ $izin->approvedBy->name }}, {{ \Carbon\Carbon::parse($izin->approved_at)->format('d/m/Y H:i') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    @endif
                </div>

                <!-- Right Column - File & Actions -->
                <div class="space-y-6">
                    <!-- File Bukti Card -->
                    @if($izin->file_bukti)
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                File Bukti
                            </h3>
                        </div>
                        <div class="p-6">
                            <a href="{{ route('admin.izin.download', $izin) }}" 
                               class="flex items-center p-3 bg-gray-50 rounded-xl hover:bg-blue-50 transition group">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center mr-3 group-hover:bg-blue-200">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-700 group-hover:text-blue-600">
                                        Download File
                                    </p>
                                    <p class="text-xs text-gray-500">{{ basename($izin->file_bukti) }}</p>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endif

                    <!-- Actions Card (Hanya untuk Pending) -->
                    @if($izin->status_approval == 'pending')
                    <div class="bg-white rounded-2xl shadow-md border border-gray-100 overflow-hidden">
                        <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                            <h3 class="font-semibold text-gray-700 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Tindakan
                            </h3>
                        </div>
                        <div class="p-6 space-y-4">
                            <!-- Form Approve -->
                            <form method="POST" action="{{ route('admin.izin.approve', $izin) }}">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <textarea name="catatan_admin" rows="2" 
                                              class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                              placeholder="Catatan (opsional)"></textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white px-4 py-3 rounded-xl hover:from-green-600 hover:to-green-700 transition font-medium shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    Setujui Izin
                                </button>
                            </form>

                            <!-- Form Reject -->
                            <form method="POST" action="{{ route('admin.izin.reject', $izin) }}">
                                @csrf
                                @method('PATCH')
                                <div class="mb-3">
                                    <textarea name="catatan_admin" rows="2" 
                                              class="w-full border border-gray-300 rounded-xl p-3 text-sm focus:ring-2 focus:ring-red-500 focus:border-red-500"
                                              placeholder="Alasan penolakan (wajib)" required></textarea>
                                </div>
                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-red-500 to-red-600 text-white px-4 py-3 rounded-xl hover:from-red-600 hover:to-red-700 transition font-medium shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                    Tolak Izin
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>