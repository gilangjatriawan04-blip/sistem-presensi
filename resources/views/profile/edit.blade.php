<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Profile') }}
            </h2>
            <span class="bg-blue-100 text-blue-800 text-xs px-3 py-1.5 rounded-full font-medium">
                @if(auth()->user()->role == 'admin') 👑 Admin
                @elseif(auth()->user()->role == 'pembimbing') 👨‍🏫 Pembimbing
                @else 🎓 Peserta Magang
                @endif
            </span>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- User Info Card dengan Avatar -->
            <div class="bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 rounded-2xl p-6 mb-6 text-white shadow-xl">
                <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
                    <!-- Avatar Component -->
                    <x-avatar-upload :user="auth()->user()" size="w-28 h-28" />
                    
                    <!-- Info User -->
                    <div class="flex-1 text-center md:text-left">
                        <h3 class="text-2xl font-bold mb-2">{{ auth()->user()->name }}</h3>
                        <p class="text-blue-100 mb-3">{{ auth()->user()->email }}</p>
                        
                        <div class="flex flex-wrap gap-4 justify-center md:justify-start">
                            <div class="bg-white/10 rounded-xl px-4 py-2">
                                <span class="text-xs text-blue-200">Bergabung</span>
                                <p class="font-semibold">{{ auth()->user()->created_at->format('d M Y') }}</p>
                            </div>
                            <div class="bg-white/10 rounded-xl px-4 py-2">
                                <span class="text-xs text-blue-200">Role</span>
                                <p class="font-semibold capitalize">{{ auth()->user()->role }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SATU FORM UNTUK SEMUA DATA -->
            <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                @csrf
                @method('patch')

                <!-- Informasi Pribadi -->
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informasi Pribadi
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Name -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Data Magang (khusus peserta) -->
                @if(auth()->user()->role == 'peserta')
                <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden p-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Data Magang
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Jenis Peserta -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Peserta</label>
                            <select name="jenis_peserta" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white">
                                <option value="">-- Pilih Jenis Peserta --</option>
                                <option value="mahasiswa" {{ old('jenis_peserta', auth()->user()->jenis_peserta) == 'mahasiswa' ? 'selected' : '' }}>🎓 Mahasiswa (D3/S1)</option>
                                <option value="smk" {{ old('jenis_peserta', auth()->user()->jenis_peserta) == 'smk' ? 'selected' : '' }}>🏫 SMK/SMA Sederajat</option>
                                <option value="pegawai" {{ old('jenis_peserta', auth()->user()->jenis_peserta) == 'pegawai' ? 'selected' : '' }}>💼 Pegawai</option>
                                <option value="lainnya" {{ old('jenis_peserta', auth()->user()->jenis_peserta) == 'lainnya' ? 'selected' : '' }}>📌 Lainnya</option>
                            </select>
                        </div>

                        <!-- NIM/NISN -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">NIM / NISN</label>
                            <input type="text" name="nim_nisn" value="{{ old('nim_nisn', auth()->user()->nim_nisn) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Contoh: 220398001">
                        </div>

                        <!-- Nama Institusi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Institusi</label>
                            <input type="text" name="institution_name" value="{{ old('institution_name', auth()->user()->institution_name) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="Universitas Indonesia, SMKN 1 Jakarta, dll">
                        </div>

                        <!-- Kelas/Jurusan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Kelas / Jurusan</label>
                            <input type="text" name="institution_class" value="{{ old('institution_class', auth()->user()->institution_class) }}" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                   placeholder="TI-3A, XII TKJ, SI-5B">
                        </div>

                        <!-- Tanggal Mulai (Read-only jika sudah diisi) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Mulai Magang
                                @if(!auth()->user()->start_date)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            
                            @if(auth()->user()->start_date)
                                <div class="px-4 py-3 bg-gray-100 rounded-xl text-gray-700 border border-gray-300">
                                    {{ \Carbon\Carbon::parse(auth()->user()->start_date)->format('d/m/Y') }}
                                    <p class="text-xs text-gray-500 mt-1">Tanggal mulai tidak dapat diubah</p>
                                </div>
                                <input type="hidden" name="start_date" value="{{ auth()->user()->start_date }}">
                            @else
                                <input type="date" name="start_date" value="{{ old('start_date') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @endif
                        </div>

                        <!-- Tanggal Selesai (Read-only jika sudah diisi) -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Tanggal Selesai Magang
                                @if(!auth()->user()->end_date)
                                    <span class="text-red-500">*</span>
                                @endif
                            </label>
                            
                            @if(auth()->user()->end_date)
                                <div class="px-4 py-3 bg-gray-100 rounded-xl text-gray-700 border border-gray-300">
                                    {{ \Carbon\Carbon::parse(auth()->user()->end_date)->format('d/m/Y') }}
                                    <p class="text-xs text-gray-500 mt-1">Tanggal selesai tidak dapat diubah</p>
                                </div>
                                <input type="hidden" name="end_date" value="{{ auth()->user()->end_date }}">
                            @else
                                <input type="date" name="end_date" value="{{ old('end_date') }}"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            @endif
                        </div>
                    </div>

                    <div class="mt-4 bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg">
                        <p class="text-sm text-blue-700">
                            <span class="font-bold">Informasi:</span> Data magang diperlukan untuk validasi periode presensi. 
                            Periode magang hanya dapat diisi sekali.
                        </p>
                    </div>
                </div>
                @endif

                <!-- Tombol Simpan -->
                <div class="flex justify-end">
                    <button type="submit" 
                            class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition font-medium shadow-md hover:shadow-lg">
                        Simpan Perubahan
                    </button>
                </div>

                <!-- Pesan Sukses -->
                @if (session('status') === 'profile-updated')
                    <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl text-center">
                        ✅ Profile berhasil diperbarui!
                    </div>
                @endif
            </form>

            <!-- Hapus Akun (Terpisah) -->
            <div class="mt-6">
                @include('profile.partials.delete-user-form')
            </div>
        </div>
    </div>

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</x-app-layout>