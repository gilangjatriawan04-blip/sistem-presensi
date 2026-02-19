
<section>
    <header class="mb-6">
        <h2 class="text-2xl font-bold text-gray-800 flex items-center">
            <svg class="w-6 h-6 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            {{ __('Data Magang') }}
        </h2>
        <p class="text-sm text-gray-600 mt-1 ml-8">
            {{ __("Lengkapi data magang Anda untuk dapat melakukan presensi.") }}
        </p>
    </header>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <!-- Grid 2 Kolom -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Jenis Peserta -->
            <div>
                <label for="jenis_peserta" class="block text-sm font-medium text-gray-700 mb-1">
                    Jenis Peserta <span class="text-red-500">*</span>
                </label>
                <select id="jenis_peserta" name="jenis_peserta" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 bg-white"
                        required>
                    <option value="">-- Pilih Jenis Peserta --</option>
                    <option value="mahasiswa" {{ old('jenis_peserta', auth()->user()->jenis_peserta) == 'mahasiswa' ? 'selected' : '' }}>🎓 Mahasiswa (D3/S1)</option>
                    <option value="smk" {{ old('jenis_peserta', auth()->user()->jenis_peserta) == 'smk' ? 'selected' : '' }}>🏫 SMK/SMA Sederajat</option>
                    <option value="pegawai" {{ old('jenis_peserta', auth()->user()->jenis_peserta) == 'pegawai' ? 'selected' : '' }}>💼 Pegawai</option>
                    <option value="lainnya" {{ old('jenis_peserta', auth()->user()->jenis_peserta) == 'lainnya' ? 'selected' : '' }}>📌 Lainnya</option>
                </select>
                <x-input-error class="mt-2" :messages="$errors->get('jenis_peserta')" />
            </div>

            <!-- NIM/NISN -->
            <div>
                <label for="nim_nisn" class="block text-sm font-medium text-gray-700 mb-1">
                    NIM / NISN
                </label>
                <input id="nim_nisn" name="nim_nisn" type="text" 
                       value="{{ old('nim_nisn', auth()->user()->nim_nisn) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Contoh: 220398001">
                <x-input-error class="mt-2" :messages="$errors->get('nim_nisn')" />
                <p class="text-xs text-gray-500 mt-1">Nomor induk mahasiswa/siswa</p>
            </div>

            <!-- Nama Institusi -->
            <div>
                <label for="institution_name" class="block text-sm font-medium text-gray-700 mb-1">
                    Nama Institusi <span class="text-red-500">*</span>
                </label>
                <input id="institution_name" name="institution_name" type="text" 
                       value="{{ old('institution_name', auth()->user()->institution_name) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="Universitas Indonesia, SMKN 1 Jakarta, dll"
                       required>
                <x-input-error class="mt-2" :messages="$errors->get('institution_name')" />
            </div>

            <!-- Kelas/Jurusan -->
            <div>
                <label for="institution_class" class="block text-sm font-medium text-gray-700 mb-1">
                    Kelas / Jurusan
                </label>
                <input id="institution_class" name="institution_class" type="text" 
                       value="{{ old('institution_class', auth()->user()->institution_class) }}"
                       class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                       placeholder="TI-3A, XII TKJ, SI-5B">
                <x-input-error class="mt-2" :messages="$errors->get('institution_class')" />
            </div>
        </div>

        <!-- Grid 2 Kolom untuk Tanggal -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
           <!-- Tanggal Mulai Magang -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Tanggal Mulai Magang
        @if(!auth()->user()->start_date)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    @if(auth()->user()->start_date)
        <!-- Tampilkan teks saja jika sudah diisi -->
        <div class="px-4 py-3 bg-gray-100 rounded-xl text-gray-700 border border-gray-300">
            {{ \Carbon\Carbon::parse(auth()->user()->start_date)->format('d/m/Y') }}
            <p class="text-xs text-gray-500 mt-1">Tanggal mulai tidak dapat diubah setelah diisi</p>
        </div>
        <input type="hidden" name="start_date" value="{{ auth()->user()->start_date }}">
    @else
        <!-- Tampilkan input jika belum diisi -->
        <input type="date" name="start_date" value="{{ old('start_date') }}"
               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
               required>
    @endif
</div>

<!-- Tanggal Selesai Magang -->
<div>
    <label class="block text-sm font-medium text-gray-700 mb-1">
        Tanggal Selesai Magang
        @if(!auth()->user()->end_date)
            <span class="text-red-500">*</span>
        @endif
    </label>
    
    @if(auth()->user()->end_date)
        <!-- Tampilkan teks saja jika sudah diisi -->
        <div class="px-4 py-3 bg-gray-100 rounded-xl text-gray-700 border border-gray-300">
            {{ \Carbon\Carbon::parse(auth()->user()->end_date)->format('d/m/Y') }}
            <p class="text-xs text-gray-500 mt-1">Tanggal selesai tidak dapat diubah setelah diisi</p>
        </div>
        <input type="hidden" name="end_date" value="{{ auth()->user()->end_date }}">
    @else
        <!-- Tampilkan input jika belum diisi -->
        <input type="date" name="end_date" value="{{ old('end_date') }}"
               class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
               required>
    @endif
</div>

        <!-- Info Tambahan -->
        <div class="bg-blue-50 border-l-4 border-blue-500 p-4 rounded-r-lg mt-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-blue-600 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-bold text-blue-700">Informasi Penting:</p>
                    <p class="text-sm text-blue-700">
                        Data magang diperlukan untuk validasi periode presensi. 
                        Pastikan tanggal yang diisi sesuai dengan surat magang.
                    </p>
                </div>
            </div>
        </div>

        <!-- Tombol Simpan -->
        <div class="flex justify-end gap-4 mt-6">
            <button type="reset" 
                    class="px-6 py-3 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-50 transition font-medium">
                Batal
            </button>
            <button type="submit" 
                    class="px-8 py-3 bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl hover:from-blue-600 hover:to-blue-700 transition font-medium shadow-md hover:shadow-lg flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" />
                </svg>
                {{ __('Simpan Perubahan') }}
            </button>
        </div>

        <!-- Pesan Sukses -->
        @if (session('status') === 'profile-updated')
            <div class="mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded-xl text-center flex items-center justify-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
                ✅ Data magang berhasil diperbarui!
            </div>
        @endif
    </form>
</section>