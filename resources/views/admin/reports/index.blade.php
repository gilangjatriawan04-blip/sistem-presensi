<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Laporan Presensi') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Info Card -->
            <div class="bg-gradient-to-r from-purple-500 to-purple-600 rounded-2xl p-6 mb-6 text-white shadow-lg">
                <div class="flex items-center">
                    <div class="bg-white/20 p-3 rounded-xl mr-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-1">Laporan & Statistik</h3>
                        <p class="text-purple-100 text-sm">Fitur laporan sedang dalam pengembangan</p>
                    </div>
                </div>
            </div>

            <!-- Filter Card (Placeholder) -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Periode</label>
                            <select class="w-full border-gray-300 rounded-xl p-3 bg-gray-50 text-gray-500 cursor-not-allowed" disabled>
                                <option>Bulan Ini</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Peserta</label>
                            <select class="w-full border-gray-300 rounded-xl p-3 bg-gray-50 text-gray-500 cursor-not-allowed" disabled>
                                <option>Semua Peserta</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                            <select class="w-full border-gray-300 rounded-xl p-3 bg-gray-50 text-gray-500 cursor-not-allowed" disabled>
                                <option>Semua Status</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button class="w-full bg-gray-300 text-gray-500 px-4 py-3 rounded-xl cursor-not-allowed" disabled>
                                Generate Laporan
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Coming Soon Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 text-center opacity-50">
                    <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Rekap Harian</h4>
                    <p class="text-sm text-gray-500">Coming Soon</p>
                </div>

                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 text-center opacity-50">
                    <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Rekap Bulanan</h4>
                    <p class="text-sm text-gray-500">Coming Soon</p>
                </div>

                <div class="bg-white rounded-2xl shadow-md border border-gray-100 p-6 text-center opacity-50">
                    <div class="w-16 h-16 rounded-full bg-purple-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h4 class="font-semibold text-gray-800 mb-1">Rekap Izin</h4>
                    <p class="text-sm text-gray-500">Coming Soon</p>
                </div>
            </div>

            <!-- Placeholder Chart -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-gray-50 to-gray-100 border-b border-gray-200">
                    <h3 class="font-semibold text-gray-700">Grafik Presensi (Coming Soon)</h3>
                </div>
                <div class="p-6">
                    <div class="h-64 bg-gray-50 rounded-xl flex items-center justify-center border-2 border-dashed border-gray-200">
                        <div class="text-center">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                            </svg>
                            <p class="text-gray-400">Fitur grafik akan segera hadir</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>