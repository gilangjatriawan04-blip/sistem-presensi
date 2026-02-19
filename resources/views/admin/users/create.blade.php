<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah User Baru') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-900">
                ← Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf
                        
                        <!-- Data Akun -->
                        <h3 class="text-lg font-semibold mb-4 border-b pb-2">Data Akun</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Nama Lengkap <span class="text-red-500">*</span>
                                </label>
                                <input type="text" name="name" value="{{ old('name') }}" 
                                       class="w-full border-gray-300 rounded-md" required>
                                @error('name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" name="email" value="{{ old('email') }}" 
                                       class="w-full border-gray-300 rounded-md" required>
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Password <span class="text-red-500">*</span>
                                </label>
                                <input type="password" name="password" 
                                       class="w-full border-gray-300 rounded-md" required>
                                <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
                                @error('password')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Role <span class="text-red-500">*</span>
                                </label>
                                <select name="role" class="w-full border-gray-300 rounded-md" required>
                                    <option value="">-- Pilih Role --</option>
                                    @foreach($roleOptions as $value => $label)
                                        <option value="{{ $value }}" {{ old('role') == $value ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('role')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                        
                        <!-- Data Peserta (khusus role peserta) -->
                        <div id="dataPeserta" class="{{ old('role') != 'peserta' ? 'hidden' : '' }}">
                            <h3 class="text-lg font-semibold mb-4 border-b pb-2 mt-6">Data Magang</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Jenis Peserta
                                    </label>
                                    <select name="jenis_peserta" class="w-full border-gray-300 rounded-md">
                                        <option value="">-- Pilih --</option>
                                        @foreach($jenisPesertaOptions as $value => $label)
                                            <option value="{{ $value }}" {{ old('jenis_peserta') == $value ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        NIM/NISN
                                    </label>
                                    <input type="text" name="nim_nisn" value="{{ old('nim_nisn') }}" 
                                           class="w-full border-gray-300 rounded-md">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Nama Institusi
                                    </label>
                                    <input type="text" name="institution_name" value="{{ old('institution_name') }}" 
                                           class="w-full border-gray-300 rounded-md"
                                           placeholder="Universitas/Sekolah">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Kelas/Jurusan
                                    </label>
                                    <input type="text" name="institution_class" value="{{ old('institution_class') }}" 
                                           class="w-full border-gray-300 rounded-md"
                                           placeholder="TI-3A / XII TKJ">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Mulai Magang
                                    </label>
                                    <input type="date" name="start_date" value="{{ old('start_date') }}" 
                                           class="w-full border-gray-300 rounded-md">
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">
                                        Tanggal Selesai Magang
                                    </label>
                                    <input type="date" name="end_date" value="{{ old('end_date') }}" 
                                           class="w-full border-gray-300 rounded-md">
                                </div>
                            </div>
                        </div>
                        
                        <div class="flex justify-end mt-6">
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-md">
                                Simpan User
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Tampilkan/sembunyikan form data peserta berdasarkan role
        document.querySelector('select[name="role"]').addEventListener('change', function() {
            const dataPeserta = document.getElementById('dataPeserta');
            if (this.value === 'peserta') {
                dataPeserta.classList.remove('hidden');
            } else {
                dataPeserta.classList.add('hidden');
            }
        });
    </script>
</x-app-layout>