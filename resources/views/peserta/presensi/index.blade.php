<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Presensi Hari Ini') }}
            </h2>
            <div class="flex items-center space-x-2">
                <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1.5 rounded-full font-medium">
                    {{ now()->format('l, d F Y') }}
                </span>
            </div>
        </div>
    </x-slot>

    <!-- Info Jam Kerja & Validasi -->
    @if(isset($officeLocation) && $officeLocation)
        @php
            $jamMasuk = Carbon\Carbon::parse($officeLocation->jam_masuk_default);
            $jamPulang = Carbon\Carbon::parse($officeLocation->jam_pulang_default);
            $jamSekarang = Carbon\Carbon::now();
            $batasTerlambat = $jamMasuk->copy()->addMinutes(60);
        @endphp
        
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-2xl p-5 mb-6 border border-blue-200 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <!-- Jam Masuk -->
                <div class="text-center p-3 bg-white rounded-xl shadow-sm">
                    <div class="text-xs text-gray-500 mb-1">Jam Masuk Normal</div>
                    <div class="text-2xl font-bold text-blue-600">{{ $jamMasuk->format('H:i') }}</div>
                    <div class="text-xs text-gray-400 mt-1">Toleransi sampai {{ $batasTerlambat->format('H:i') }}</div>
                </div>
                
                <!-- Jam Pulang -->
                <div class="text-center p-3 bg-white rounded-xl shadow-sm">
                    <div class="text-xs text-gray-500 mb-1">Jam Pulang Normal</div>
                    <div class="text-2xl font-bold text-indigo-600">{{ $jamPulang->format('H:i') }}</div>
                    <div class="text-xs text-gray-400 mt-1">Minimal check-out</div>
                </div>

                <!-- Status Waktu -->
                <div class="text-center p-3 bg-white rounded-xl shadow-sm">
                    <div class="text-xs text-gray-500 mb-1">Waktu Saat Ini</div>
                    <div class="text-2xl font-bold {{ $jamSekarang >= $jamMasuk ? 'text-green-600' : 'text-yellow-600' }}">
                        {{ \Carbon\Carbon::now()->format('H:i:s') }}
                    </div>
                    <div class="text-xs text-gray-400 mt-1">
                        @if(isset($presensi) && $presensi->jam_masuk)
                            @if(!$presensi->jam_pulang)
                                <span class="text-green-600">● Sedang bekerja</span>
                            @else
                                <span class="text-gray-600">● Selesai</span>
                            @endif
                        @else
                            @if($jamSekarang < $jamMasuk)
                                <span class="text-yellow-600">● Belum waktunya</span>
                            @elseif($jamSekarang > $batasTerlambat)
                                <span class="text-red-600">● Melebihi toleransi</span>
                            @else
                                <span class="text-green-600">● Waktu presensi</span>
                            @endif
                        @endif
                    </div>
                </div>
            </div>
            
            <!-- Tombol Izin Terlambat (di dalam card info) -->
            @if(!isset($presensi) || !$presensi || !$presensi->jam_masuk)
                <div class="mt-4 flex justify-center">
                    <a href="{{ route('izin.create') }}?jenis=izin_terlambat" 
                       class="inline-flex items-center px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded-xl transition shadow-md">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Ajukan Izin Terlambat
                    </a>
                </div>
            @endif
            
            <!-- Info Izin Terlambat -->
            @if(isset($izinTerlambat) && $izinTerlambat)
                <div class="mt-3 p-2 bg-green-100 rounded-lg text-center">
                    <span class="text-sm text-green-700">
                        ✅ Anda memiliki izin terlambat yang aktif
                    </span>
                </div>
            @endif
        </div>
    @endif

    <div class="py-6">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- FLASH MESSAGES (SATU AREA) -->
            @if(session('error'))
                <div class="bg-red-500 text-white p-4 rounded-lg mb-4">
                    <p>{{ session('error') }}</p>
                    @if(session('show_izin_button'))
                        <div class="mt-3">
                            <a href="{{ route('izin.create') }}?jenis=izin_terlambat" 
                               class="inline-block bg-white text-red-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-100 transition shadow-md">
                                ➕ Ajukan Izin Terlambat
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            @if(session('warning'))
                <div class="bg-yellow-500 text-white p-4 rounded-lg mb-4">
                    <p>{{ session('warning') }}</p>
                    
                </div>
            @endif

            @if(session('info'))
                <div class="bg-blue-500 text-white p-4 rounded-lg mb-4">
                    <p>{{ session('info') }}</p>
                    @if(session('show_izin_button'))
                        <div class="mt-3">
                            <a href="{{ route('izin.create') }}?jenis=izin_terlambat" 
                               class="inline-block bg-white text-blue-700 font-bold py-2 px-4 rounded-lg hover:bg-gray-100 transition shadow-md">
                                ➕ Ajukan Izin Terlambat
                            </a>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Periode Magang Info (Jika error periode magang) -->
            @if(session('error') && str_contains(session('error'), 'periode magang'))
                <div class="bg-gradient-to-r from-yellow-500 to-yellow-600 rounded-2xl p-6 mb-6 text-white shadow-lg">
                    <div class="flex items-center">
                        <div class="bg-white/20 p-3 rounded-xl mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold mb-1">Periode Magang</h3>
                            <p class="text-yellow-100 text-sm">
                                @if(auth()->user()->start_date && auth()->user()->end_date)
                                    Magang Anda: {{ \Carbon\Carbon::parse(auth()->user()->start_date)->format('d/m/Y') }} - 
                                    {{ \Carbon\Carbon::parse(auth()->user()->end_date)->format('d/m/Y') }}
                                @else
                                    Data periode magang belum diisi. Silakan lengkapi profile.
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Status Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mb-6">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                    <h3 class="font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Status Presensi
                    </h3>
                </div>
                
                <div class="p-6">
                    @if(isset($presensi) && $presensi && $presensi->jam_masuk)
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="text-sm text-gray-500 mb-1">Jam Masuk</p>
                                <p class="text-2xl font-bold text-green-600">
                                    {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i:s') }}
                                </p>
                                @if($presensi->terlambat_menit > 0)
                                    <p class="text-xs text-red-500 mt-1">Terlambat {{ $presensi->terlambat_menit }} menit</p>
                                @endif
                            </div>
                            @if($presensi->jam_pulang)
                                <div class="text-right">
                                    <p class="text-sm text-gray-500 mb-1">Jam Pulang</p>
                                    <p class="text-2xl font-bold text-blue-600">
                                        {{ \Carbon\Carbon::parse($presensi->jam_pulang)->format('H:i:s') }}
                                    </p>
                                    @if($presensi->pulang_cepat_menit > 0)
                                        <p class="text-xs text-yellow-500 mt-1">Pulang cepat {{ $presensi->pulang_cepat_menit }} menit</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                        
                        @if(!$presensi->jam_pulang)
                            <div class="mt-4 p-3 bg-yellow-50 rounded-xl">
                                <p class="text-sm text-yellow-700">
                                    <span class="font-medium">Belum check-out</span> - Jangan lupa check-out sebelum pulang.
                                </p>
                            </div>
                        @endif
                    @else
                        <div class="text-center py-4">
                            <svg class="w-16 h-16 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            <p class="text-gray-500">Anda belum melakukan presensi hari ini</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Form Check-in -->
            @if(!isset($presensi) || !$presensi || !$presensi->jam_masuk)
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 bg-gradient-to-r from-green-500 to-green-600">
                    <h3 class="font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1" />
                        </svg>
                        Check-in
                    </h3>
                </div>
                
                <div class="p-6">
                    <form method="POST" action="{{ route('presensi.checkin') }}" id="checkinForm">
                        @csrf
                        
                        <!-- Hidden GPS Fields -->
                        <input type="hidden" id="checkinLatitude" name="latitude">
                        <input type="hidden" id="checkinLongitude" name="longitude">
                        
                        <!-- GPS Status -->
                        <div class="mb-6 bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <div id="gpsStatus" class="w-3 h-3 rounded-full bg-yellow-500 mr-2 animate-pulse"></div>
                                <span id="gpsText" class="text-sm font-medium">Mendeteksi lokasi...</span>
                            </div>
                            <p id="gpsInfo" class="text-xs text-gray-600"></p>
                            
                            <!-- Office Info -->
                            @if(isset($officeLocation) && $officeLocation)
                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <p class="text-xs text-gray-500">
                                    <span class="font-medium">Lokasi kantor:</span> {{ $officeLocation->nama_lokasi }}
                                </p>
                                <p class="text-xs text-gray-500">
                                    <span class="font-medium">Radius:</span> {{ $officeLocation->radius_meter }} meter
                                </p>
                                <p class="text-xs text-gray-500">
                                    <span class="font-medium">Jam kerja:</span> 
                                    {{ \Carbon\Carbon::parse($officeLocation->jam_masuk_default)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($officeLocation->jam_pulang_default)->format('H:i') }}
                                </p>
                            </div>
                            @endif
                        </div>
                        
                        <!-- Keterangan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Keterangan (opsional)
                            </label>
                            <textarea name="keterangan" rows="3" 
                                      class="w-full border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-green-500 focus:border-green-500"
                                      placeholder="Contoh: Meeting pagi, lembur, tugas khusus, dll"></textarea>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" id="checkinButton" 
                                class="w-full bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:from-green-600 hover:to-green-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Check-in Sekarang
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Form Check-out -->
            @if(isset($presensi) && $presensi && $presensi->jam_masuk && !$presensi->jam_pulang)
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden mt-6">
                <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                    <h3 class="font-semibold text-white flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Check-out
                    </h3>
                </div>
                
                <div class="p-6">
                    <form method="POST" action="{{ route('presensi.checkout') }}" id="checkoutForm">
                        @csrf
                        
                        <!-- Hidden GPS Fields -->
                        <input type="hidden" id="checkoutLatitude" name="latitude">
                        <input type="hidden" id="checkoutLongitude" name="longitude">
                        
                        <!-- GPS Status -->
                        <div class="mb-6 bg-gray-50 rounded-xl p-4">
                            <div class="flex items-center mb-2">
                                <div id="gpsStatusCheckout" class="w-3 h-3 rounded-full bg-yellow-500 mr-2 animate-pulse"></div>
                                <span id="gpsTextCheckout" class="text-sm font-medium">Mendeteksi lokasi...</span>
                            </div>
                            <p id="gpsInfoCheckout" class="text-xs text-gray-600"></p>
                        </div>
                        
                        <!-- Submit Button -->
                        <button type="submit" id="checkoutButton" 
                                class="w-full bg-gradient-to-r from-blue-500 to-blue-600 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:from-blue-600 hover:to-blue-700 transition disabled:opacity-50 disabled:cursor-not-allowed"
                                disabled>
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                            </svg>
                            Check-out Sekarang
                        </button>
                    </form>
                </div>
            </div>
            @endif

            <!-- Link Riwayat -->
            <div class="mt-6 text-center">
                <a href="{{ route('presensi.riwayat') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Lihat Riwayat Presensi
                </a>
            </div>
        </div>
    </div>

    <script>
    // Fungsi untuk mendapatkan lokasi user (Check-in)
    if (document.getElementById('checkinForm')) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    const accuracy = position.coords.accuracy;
                    
                    document.getElementById('checkinLatitude').value = lat;
                    document.getElementById('checkinLongitude').value = lon;
                    
                    document.getElementById('gpsStatus').className = 'w-3 h-3 rounded-full bg-green-500 mr-2';
                    document.getElementById('gpsText').textContent = 'Lokasi terdeteksi';
                    document.getElementById('gpsInfo').innerHTML = 
                        `Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)}<br>
                         Akurasi: ±${Math.round(accuracy)} meter`;
                    
                    document.getElementById('checkinButton').disabled = false;
                },
                function(error) {
                    let message = '';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            message = 'Izin lokasi ditolak. Izinkan akses lokasi di browser.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            message = 'Informasi lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            message = 'Waktu permintaan lokasi habis.';
                            break;
                        default:
                            message = 'Terjadi kesalahan saat mengambil lokasi.';
                    }
                    
                    document.getElementById('gpsStatus').className = 'w-3 h-3 rounded-full bg-red-500 mr-2';
                    document.getElementById('gpsText').textContent = 'Gagal';
                    document.getElementById('gpsInfo').textContent = message;
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            document.getElementById('gpsInfo').textContent = 'Browser tidak mendukung GPS.';
        }
    }

    // Fungsi untuk mendapatkan lokasi user (Check-out)
    if (document.getElementById('checkoutForm')) {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                function(position) {
                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;
                    const accuracy = position.coords.accuracy;
                    
                    document.getElementById('checkoutLatitude').value = lat;
                    document.getElementById('checkoutLongitude').value = lon;
                    
                    document.getElementById('gpsStatusCheckout').className = 'w-3 h-3 rounded-full bg-green-500 mr-2';
                    document.getElementById('gpsTextCheckout').textContent = 'Lokasi terdeteksi';
                    document.getElementById('gpsInfoCheckout').innerHTML = 
                        `Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)}<br>
                         Akurasi: ±${Math.round(accuracy)} meter`;
                    
                    document.getElementById('checkoutButton').disabled = false;
                },
                function(error) {
                    let message = '';
                    switch(error.code) {
                        case error.PERMISSION_DENIED:
                            message = 'Izin lokasi ditolak.';
                            break;
                        case error.POSITION_UNAVAILABLE:
                            message = 'Lokasi tidak tersedia.';
                            break;
                        case error.TIMEOUT:
                            message = 'Waktu habis.';
                            break;
                        default:
                            message = 'Error tidak diketahui.';
                    }
                    
                    document.getElementById('gpsStatusCheckout').className = 'w-3 h-3 rounded-full bg-red-500 mr-2';
                    document.getElementById('gpsTextCheckout').textContent = 'Gagal';
                    document.getElementById('gpsInfoCheckout').textContent = message;
                },
                {
                    enableHighAccuracy: true,
                    timeout: 10000,
                    maximumAge: 0
                }
            );
        } else {
            document.getElementById('gpsInfoCheckout').textContent = 'Browser tidak mendukung GPS.';
        }
    }
    </script>
</x-app-layout>