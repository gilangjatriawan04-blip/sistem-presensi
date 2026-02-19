<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Pembimbing Baru') }}
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-blue-600 hover:text-blue-900">
                ← Kembali ke Daftar User
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <div class="p-6">
                    <!-- INFO ROLE -->
                    <div class="mb-6 bg-green-50 border-l-4 border-green-400 p-4">
                        <div class="flex">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0zM6 18a1 1 0 001-1v-2.065a8.935 8.935 0 00-2-.712V17a1 1 0 001 1z" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-green-700">
                                    <span class="font-bold">Role: Pembimbing</span><br>
                                    Akun untuk dosen/guru pembimbing dari institusi
                                </p>
                            </div>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('admin.users.store.pembimbing') }}">
                        @csrf

                        <!-- Nama Lengkap -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lengkap <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" value="{{ old('name') }}" 
                                   class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200"
                                   placeholder="Contoh: Dr. Ahmad S.Pd"
                                   required>
                            @error('name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email" name="email" value="{{ old('email') }}" 
                                   class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200"
                                   placeholder="pembimbing@example.com"
                                   required>
                            @error('email')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Nama Institusi -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Institusi <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="institution_name" value="{{ old('institution_name') }}" 
                                   class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200"
                                   placeholder="Contoh: Universitas Indonesia, SMKN 1 Jakarta"
                                   required>
                            @error('institution_name')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password" 
                                   class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200"
                                   placeholder="Minimal 8 karakter"
                                   required>
                            <p class="text-xs text-gray-500 mt-1">🔐 Minimal 8 karakter</p>
                            @error('password')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Konfirmasi Password -->
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Konfirmasi Password <span class="text-red-500">*</span>
                            </label>
                            <input type="password" name="password_confirmation" 
                                   class="w-full border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200"
                                   placeholder="Ketik ulang password"
                                   required>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="flex justify-end">
                            <button type="submit" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-md focus:outline-none focus:ring-2 focus:ring-green-500">
                                ✅ Tambah Pembimbing
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>