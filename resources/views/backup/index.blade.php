<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Presensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Notifications -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                    {{ session('success') }}
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                    {{ session('error') }}
                </div>
            @endif
            
            @if(session('info'))
                <div class="mb-6 bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded">
                    {{ session('info') }}
                </div>
            @endif
            
            <!-- Status Hari Ini -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-8">
                <div class="p-6 bg-white border-b border-gray-200">
                    <h3 class="text-lg font-semibold mb-4">Status Presensi Hari Ini ({{ $today }})</h3>
                    
                    @if($izin)
                        <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 mb-4">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm text-yellow-700">
                                        Anda memiliki izin/sakit hari ini: <strong>{{ $izin->jenis_izin }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endif
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Check-in Status -->
                        <div class="border rounded-lg p-6 {{ $presensi && $presensi->jam_masuk ? 'bg-green-50 border-green-200' : 'bg-gray-50 border-gray-200' }}">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-lg">Check-in</h4>
                                    @if($presensi && $presensi->jam_masuk)
                                        <p class="text-2xl font-bold text-green-600">
                                            {{ \Carbon\Carbon::parse($presensi->jam_masuk)->format('H:i:s') }}
                                        </p>
                                        <p class="text-sm text-gray-600">
                                            Status: 
                                            <span class="{{ $presensi->status == 'terlambat' ? 'text-red-600' : 'text-green-600' }}">
                                                {{ $presensi->status == 'terlambat' ? 'Terlambat' : 'Tepat waktu' }}
                                            </span>
                                        </p>
                                        @if($presensi->terlambat_menit > 0)
                                            <p class="text-sm text-red-600">
                                                Terlambat: {{ $presensi->terlambat_menit }} menit
                                            </p>
                                        @endif
                                    @else
                                        <p class="text-lg text-gray-600">Belum check-in</p>
                                    @endif
                                </div>
                                <div class="text-4xl">
                                    @if($presensi && $presensi->jam_masuk)
                                        ✅
                                    @else
                                        ⏰
                                    @endif
                                </div>
                            </div>
                        </div>
                        
                        <!-- Check-out Status -->
                        <div class="border rounded-lg p-6 {{ $presensi && $presensi->jam_pulang ? 'bg-blue-50 border-blue-200' : 'bg-gray-50 border-gray-200' }}">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h4 class="font-semibold text-lg">Check-out</h4>
                                    @if($presensi && $presensi->jam_pulang)
                                        <p class="text-2xl font-bold text-blue-600">
                                            {{ \Carbon\Carbon::parse($presensi->jam_pulang)->format('H:i:s') }}
                                        </p>
                                        @if($presensi->pulang_cepat_menit > 0)
                                            <p class="text-sm text-yellow-600">
                                                Pulang cepat: {{ $presensi->pulang_cepat_menit }} menit
                                            </p>
                                        @endif
                                    @else
                                        <p class="text-lg text-gray-600">Belum check-out</p>
                                    @endif
                                </div>
                                <div class="text-4xl">
                                    @if($presensi && $presensi->jam_pulang)
                                        ✅
                                    @else
                                        🏠
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    @if($officeLocation)
                        <div class="mt-6 text-sm text-gray-600">
                            <p>Lokasi kantor: {{ $officeLocation->nama_lokasi }}</p>
                            <p>Radius yang diizinkan: {{ $officeLocation->radius_meter }} meter</p>
                            <p>Jam kerja: {{ \Carbon\Carbon::parse($officeLocation->jam_masuk_default)->format('H:i') }} - {{ \Carbon\Carbon::parse($officeLocation->jam_pulang_default)->format('H:i') }}</p>
                        </div>
                    @endif
                </div>
            </div>
            
            <!-- Form Presensi -->
            @if(!$izin)
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Check-in Form -->
                @if(!$presensi || !$presensi->jam_masuk)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Check-in</h3>
                        
                        <form id="checkinForm" method="POST" action="{{ route('presensi.checkin') }}">
                            @csrf
                            
                            <!-- Hidden GPS Fields -->
                            <input type="hidden" id="checkinLatitude" name="latitude">
                            <input type="hidden" id="checkinLongitude" name="longitude">
                            
                            <!-- GPS Status -->
                            <div class="mb-4">
                                <div class="flex items-center mb-2">
                                    <div id="gpsStatusCheckin" class="inline-block w-3 h-3 rounded-full bg-gray-300 mr-2"></div>
                                    <span id="gpsTextCheckin">Mendeteksi lokasi...</span>
                                </div>
                                <p class="text-sm text-gray-600" id="locationInfoCheckin"></p>
                            </div>
                            
                            <!-- Keterangan -->
                            <div class="mb-4">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700">Keterangan (opsional)</label>
                                <textarea id="keterangan" name="keterangan" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500" placeholder="Contoh: Meeting pagi, tugas khusus, etc."></textarea>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" id="checkinButton" class="w-full inline-flex justify-center items-center px-4 py-3 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700 active:bg-green-800 focus:outline-none focus:border-green-900 focus:ring ring-green-300 disabled:opacity-25 transition ease-in-out duration-150 disabled:cursor-not-allowed" disabled>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                Check-in Sekarang
                            </button>
                        </form>
                    </div>
                </div>
                @endif
                
                <!-- Check-out Form -->
                @if($presensi && $presensi->jam_masuk && !$presensi->jam_pulang)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                        <h3 class="text-lg font-semibold mb-4">Check-out</h3>
                        
                        <form id="checkoutForm" method="POST" action="{{ route('presensi.checkout') }}">
                            @csrf
                            
                            <!-- Hidden GPS Fields -->
                            <input type="hidden" id="checkoutLatitude" name="latitude">
                            <input type="hidden" id="checkoutLongitude" name="longitude">
                            
                            <!-- GPS Status -->
                            <div class="mb-4">
                                <div class="flex items-center mb-2">
                                    <div id="gpsStatusCheckout" class="inline-block w-3 h-3 rounded-full bg-gray-300 mr-2"></div>
                                    <span id="gpsTextCheckout">Mendeteksi lokasi...</span>
                                </div>
                                <p class="text-sm text-gray-600" id="locationInfoCheckout"></p>
                            </div>
                            
                            <!-- Submit Button -->
                            <button type="submit" id="checkoutButton" class="w-full inline-flex justify-center items-center px-4 py-3 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-800 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150 disabled:cursor-not-allowed" disabled>
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Check-out Sekarang
                            </button>
                        </form>
                    </div>
                </div>
                @endif
            </div>
            @endif
            
            <!-- Riwayat Link -->
            <div class="mt-8 text-center">
                <a href="{{ route('presensi.riwayat') }}" class="inline-flex items-center text-blue-600 hover:text-blue-800">
                    <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Lihat Riwayat Presensi
                </a>
            </div>
        </div>
    </div>
    
    <!-- JavaScript for GPS -->
    @push('scripts')
    <script>
        function updateGPSStatus(formType, position) {
            const lat = position.coords.latitude;
            const lon = position.coords.longitude;
            const accuracy = position.coords.accuracy;
            
            // Update hidden fields
            document.getElementById(formType + 'Latitude').value = lat;
            document.getElementById(formType + 'Longitude').value = lon;
            
            // Update status display
            document.getElementById('gpsStatus' + formType).className = 
                'inline-block w-3 h-3 rounded-full bg-green-500 mr-2';
            document.getElementById('gpsText' + formType).textContent = 'Lokasi terdeteksi';
            document.getElementById('locationInfo' + formType).textContent = 
                `Lat: ${lat.toFixed(6)}, Lon: ${lon.toFixed(6)} (Akurasi: ±${Math.round(accuracy)}m)`;
            
            // Enable button
            document.getElementById(formType + 'Button').disabled = false;
        }
        
        function handleGPSError(formType, error) {
            document.getElementById('gpsStatus' + formType).className = 
                'inline-block w-3 h-3 rounded-full bg-red-500 mr-2';
            document.getElementById('gpsText' + formType).textContent = 'Gagal mendapatkan lokasi';
            
            let errorMessage = 'Error: ';
            switch(error.code) {
                case error.PERMISSION_DENIED:
                    errorMessage += 'Izin ditolak. Izinkan akses lokasi di browser.';
                    break;
                case error.POSITION_UNAVAILABLE:
                    errorMessage += 'Informasi lokasi tidak tersedia.';
                    break;
                case error.TIMEOUT:
                    errorMessage += 'Permintaan lokasi timeout.';
                    break;
                default:
                    errorMessage += 'Error tidak diketahui.';
                    break;
            }
            
            document.getElementById('locationInfo' + formType).textContent = errorMessage;
        }
        
        // Get GPS for checkin form
        if (document.getElementById('checkinForm')) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (pos) => updateGPSStatus('checkin', pos),
                    (err) => handleGPSError('checkin', err),
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            } else {
                document.getElementById('locationInfoCheckin').textContent = 
                    'Geolocation tidak didukung oleh browser ini.';
            }
        }
        
        // Get GPS for checkout form
        if (document.getElementById('checkoutForm')) {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (pos) => updateGPSStatus('checkout', pos),
                    (err) => handleGPSError('checkout', err),
                    { enableHighAccuracy: true, timeout: 10000 }
                );
            } else {
                document.getElementById('locationInfoCheckout').textContent = 
                    'Geolocation tidak didukung oleh browser ini.';
            }
        }
    </script>
    @endpush
</x-app-layout>