<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Pengaturan Sistem') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Info Card -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 mb-6 text-white shadow-lg">
                <div class="flex items-center">
                    <div class="bg-white/20 p-3 rounded-xl mr-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-1">Pengaturan Lokasi & Waktu</h3>
                        <p class="text-blue-100 text-sm">Atur lokasi kantor, radius GPS, dan jam kerja default</p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.settings.update') }}">
                        @csrf

                        <!-- Lokasi Kantor Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="w-1 h-6 bg-blue-500 rounded-full mr-3"></span>
                                Lokasi Kantor
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Nama Lokasi -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Lokasi <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="nama_lokasi" 
                                           value="{{ old('nama_lokasi', $office->nama_lokasi) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Kantor Pusat" required>
                                </div>
                                
                                <!-- Alamat -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Alamat
                                    </label>
                                    <input type="text" name="alamat" 
                                           value="{{ old('alamat', $office->alamat) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="Jl. Sudirman No. 123">
                                </div>
                                
                                <!-- Latitude -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Latitude <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="latitude" 
                                           value="{{ old('latitude', $office->latitude) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="-6.208763" required>
                                </div>
                                
                                <!-- Longitude -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Longitude <span class="text-red-500">*</span>
                                    </label>
                                    <input type="text" name="longitude" 
                                           value="{{ old('longitude', $office->longitude) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           placeholder="106.845599" required>
                                </div>
                                
                                <!-- Radius -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Radius (meter) <span class="text-red-500">*</span>
                                    </label>
                                    <input type="number" name="radius_meter" 
                                           value="{{ old('radius_meter', $office->radius_meter ?? 100) }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           min="10" max="5000" required>
                                    <p class="text-xs text-gray-500 mt-1">Minimal 10 meter, maksimal 5000 meter</p>
                                </div>
                            </div>
                        </div>

                        <!-- Waktu Presensi Section -->
                        <div class="mb-8">
                            <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                                <span class="w-1 h-6 bg-green-500 rounded-full mr-3"></span>
                                Waktu Presensi Default
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Jam Masuk -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Jam Masuk Default <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" name="jam_masuk_default" 
                                           value="{{ old('jam_masuk_default', $office->jam_masuk_default ? substr($office->jam_masuk_default, 0, 5) : '08:00') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           required>
                                </div>
                                
                                <!-- Jam Pulang -->
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Jam Pulang Default <span class="text-red-500">*</span>
                                    </label>
                                    <input type="time" name="jam_pulang_default" 
                                           value="{{ old('jam_pulang_default', $office->jam_pulang_default ? substr($office->jam_pulang_default, 0, 5) : '17:00') }}"
                                           class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           required>
                                </div>
                            </div>
                        </div>

                        <!-- Status Aktif -->
                        <div class="mb-8">
                            <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                                <input type="checkbox" id="is_aktif" name="is_aktif" value="1" 
                                       {{ old('is_aktif', $office->is_aktif) ? 'checked' : '' }}
                                       class="w-5 h-5 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <label for="is_aktif" class="ml-3 block text-sm font-medium text-gray-700">
                                    Lokasi ini aktif untuk presensi
                                </label>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                Jika tidak aktif, peserta tidak dapat melakukan presensi di lokasi ini
                            </p>
                        </div>

                        <!-- Preview Lokasi -->
                        @if($office->latitude && $office->longitude)
                        <div class="mb-8 p-4 bg-blue-50 rounded-xl border border-blue-200">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7" />
                                    </svg>
                                </div>
                                <div class="ml-3 flex-1">
                                    <h4 class="text-sm font-medium text-blue-800">Preview Lokasi</h4>
                                    <p class="text-sm text-blue-700 mt-1">
                                        {{ $office->latitude }}, {{ $office->longitude }}
                                    </p>
                                    <a href="https://maps.google.com/?q={{ $office->latitude }},{{ $office->longitude }}" 
                                       target="_blank"
                                       class="inline-flex items-center mt-2 text-xs text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                        </svg>
                                        Buka di Google Maps
                                    </a>
                                </div>
                            </div>
                        </div>
                        @endif

                        <!-- Tombol Submit -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition font-medium shadow-md hover:shadow-lg">
                                Simpan Pengaturan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>