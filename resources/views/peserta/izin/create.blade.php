<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Ajukan Izin') }}
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
            
            <!-- Info Card -->
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 rounded-2xl p-6 mb-6 text-white shadow-lg">
                <div class="flex items-center">
                    <div class="bg-white/20 p-3 rounded-xl mr-4">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-semibold mb-1">Pengajuan Izin / Sakit</h3>
                        <p class="text-blue-100 text-sm">Isi form dengan lengkap dan benar. Izin akan diproses oleh admin.</p>
                    </div>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <form method="POST" action="{{ route('izin.store') }}" enctype="multipart/form-data" id="izinForm">
                        @csrf

                        <!-- Jenis Izin (Card Style) -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-3">
                                Jenis Izin <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                <!-- Izin -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="jenis_izin" value="izin" class="sr-only peer" 
                                           {{ request()->get('jenis') == 'izin' ? 'checked' : '' }}
                                           onchange="toggleFields(this.value)">
                                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-center peer-checked:bg-blue-50 peer-checked:border-blue-500 peer-checked:shadow-md transition-all hover:bg-gray-100">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <span class="block text-sm font-medium">Izin</span>
                                    </div>
                                </label>
                                
                                <!-- Sakit -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="jenis_izin" value="sakit" class="sr-only peer"
                                           {{ request()->get('jenis') == 'sakit' ? 'checked' : '' }}
                                           onchange="toggleFields(this.value)">
                                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-center peer-checked:bg-red-50 peer-checked:border-red-500 peer-checked:shadow-md transition-all hover:bg-gray-100">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="block text-sm font-medium">Sakit</span>
                                    </div>
                                </label>
                                
                                <!-- Izin Terlambat -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="jenis_izin" value="izin_terlambat" class="sr-only peer"
                                           {{ request()->get('jenis') == 'izin_terlambat' ? 'checked' : '' }}
                                           onchange="toggleFields(this.value)">
                                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-center peer-checked:bg-yellow-50 peer-checked:border-yellow-500 peer-checked:shadow-md transition-all hover:bg-gray-100">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <span class="block text-sm font-medium">Izin Terlambat</span>
                                    </div>
                                </label>
                                
                                <!-- Tugas Luar -->
                                <label class="relative cursor-pointer">
                                    <input type="radio" name="jenis_izin" value="tugas_luar" class="sr-only peer"
                                           {{ request()->get('jenis') == 'tugas_luar' ? 'checked' : '' }}
                                           onchange="toggleFields(this.value)">
                                    <div class="p-4 bg-gray-50 border border-gray-200 rounded-xl text-center peer-checked:bg-purple-50 peer-checked:border-purple-500 peer-checked:shadow-md transition-all hover:bg-gray-100">
                                        <svg class="w-6 h-6 mx-auto mb-2 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <span class="block text-sm font-medium">Tugas Luar</span>
                                    </div>
                                </label>
                            </div>
                            @error('jenis_izin')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tanggal -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Mulai <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="date" name="tanggal_mulai" value="{{ old('tanggal_mulai', request()->get('tanggal') ?? now()->format('Y-m-d')) }}"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           required id="tanggal_mulai">
                                </div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Tanggal Selesai <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <input type="date" name="tanggal_selesai" value="{{ old('tanggal_selesai', request()->get('tanggal') ?? now()->addDay()->format('Y-m-d')) }}"
                                           class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                           required id="tanggal_selesai">
                                </div>
                                <p class="text-xs text-gray-500 mt-1">Untuk izin 1 hari, isi tanggal yang sama</p>
                            </div>
                        </div>

                        <!-- Jam Izin Terlambat (Hanya untuk Izin Terlambat) -->
                        <div id="jamTerlambatField" class="mb-6 hidden">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Jam Diperkirakan Datang <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <input type="time" name="jam_izin_terlambat" value="{{ old('jam_izin_terlambat', now()->format('H:i')) }}"
                                       class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                       id="jam_izin_terlambat">
                            </div>
                        </div>

                        <!-- Alasan -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Alasan / Keterangan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute top-3 left-0 pl-3 flex items-start pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                                    </svg>
                                </div>
                                <textarea name="alasan" rows="4" 
                                          class="w-full pl-10 pr-3 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Jelaskan alasan izin Anda secara detail..."
                                          required>{{ old('alasan') }}</textarea>
                            </div>
                        </div>

                        <!-- File Bukti (Wajib untuk Sakit) -->
                        <div class="mb-8">
                            <label class="block text-sm font-medium text-gray-700 mb-2" id="fileLabel">
                                File Bukti <span class="text-red-500" id="fileRequired">*</span>
                            </label>
                            <div class="border-2 border-dashed border-gray-300 rounded-xl p-6 text-center hover:border-blue-500 transition group" id="dropzone">
                                <input type="file" name="file_bukti" id="file_bukti" class="hidden" accept=".pdf,.jpg,.jpeg,.png">
                                <label for="file_bukti" class="cursor-pointer">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-gray-400 group-hover:text-blue-500 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12" />
                                    </svg>
                                    <p class="text-sm text-gray-600 group-hover:text-blue-600 transition">
                                        <span class="font-medium">Klik untuk upload</span> atau drag & drop
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1" id="fileInfo">PDF, JPG, PNG (Maks. 2MB)</p>
                                </label>
                                <div id="file-name" class="text-sm text-green-600 mt-2 hidden"></div>
                            </div>
                            @error('file_bukti')
                                <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Buttons -->
                        <div class="flex justify-end gap-3">
                            <a href="{{ route('izin.index') }}" 
                               class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition font-medium">
                                Batal
                            </a>
                            <button type="submit" 
                                    class="px-6 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition font-medium shadow-md hover:shadow-lg">
                                Ajukan Izin
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Toggle field berdasarkan jenis izin
        function toggleFields(jenis) {
            const jamField = document.getElementById('jamTerlambatField');
            const jamInput = document.getElementById('jam_izin_terlambat');
            const fileLabel = document.getElementById('fileRequired');
            
            if (jenis === 'izin_terlambat') {
                jamField.classList.remove('hidden');
                jamInput.required = true;
                fileLabel.innerText = ''; // Tidak wajib
            } else {
                jamField.classList.add('hidden');
                jamInput.required = false;
                fileLabel.innerText = (jenis === 'sakit') ? '*' : ''; // Wajib hanya untuk sakit
            }
            
            // Sakit wajib file
            if (jenis === 'sakit') {
                fileLabel.innerText = '*';
            }
        }

        // Set dari URL parameter
        document.addEventListener('DOMContentLoaded', function() {
            const urlParams = new URLSearchParams(window.location.search);
            const jenis = urlParams.get('jenis');
            const tanggal = urlParams.get('tanggal');
            
            if (jenis) {
                document.querySelectorAll('input[name="jenis_izin"]').forEach(radio => {
                    if (radio.value === jenis) {
                        radio.checked = true;
                        toggleFields(jenis);
                    }
                });
            }
            
            if (tanggal) {
                document.getElementById('tanggal_mulai').value = tanggal;
                document.getElementById('tanggal_selesai').value = tanggal;
            }
        });

        // Tampilkan nama file yang diupload
        document.getElementById('file_bukti').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const fileNameDiv = document.getElementById('file-name');
            const fileInfo = document.getElementById('fileInfo');
            
            if (file) {
                fileNameDiv.textContent = '📄 ' + file.name;
                fileNameDiv.classList.remove('hidden');
                fileInfo.classList.add('hidden');
            } else {
                fileNameDiv.classList.add('hidden');
                fileInfo.classList.remove('hidden');
            }
        });

        // Drag & drop
        const dropzone = document.getElementById('dropzone');
        dropzone.addEventListener('dragover', (e) => {
            e.preventDefault();
            dropzone.classList.add('border-blue-500', 'bg-blue-50');
        });
        
        dropzone.addEventListener('dragleave', () => {
            dropzone.classList.remove('border-blue-500', 'bg-blue-50');
        });
        
        dropzone.addEventListener('drop', (e) => {
            e.preventDefault();
            dropzone.classList.remove('border-blue-500', 'bg-blue-50');
            const file = e.dataTransfer.files[0];
            if (file) {
                document.getElementById('file_bukti').files = e.dataTransfer.files;
                const event = new Event('change', { bubbles: true });
                document.getElementById('file_bukti').dispatchEvent(event);
            }
        });
    </script>
</x-app-layout>