<!-- HAPUS semua field Data Magang -->
<!-- CUKUP ini saja: -->

<form method="POST" action="{{ route('admin.users.store.peserta') }}">
    @csrf
    
    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Data Akun</h3>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nama Lengkap <span class="text-red-500">*</span>
            </label>
            <input type="text" name="name" value="{{ old('name') }}" 
                   class="w-full border-gray-300 rounded-md" required>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Email <span class="text-red-500">*</span>
            </label>
            <input type="email" name="email" value="{{ old('email') }}" 
                   class="w-full border-gray-300 rounded-md" required>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Password <span class="text-red-500">*</span>
            </label>
            <input type="password" name="password" 
                   class="w-full border-gray-300 rounded-md" required>
            <p class="text-xs text-gray-500 mt-1">Minimal 8 karakter</p>
        </div>
        
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Konfirmasi Password <span class="text-red-500">*</span>
            </label>
            <input type="password" name="password_confirmation" 
                   class="w-full border-gray-300 rounded-md" required>
        </div>
    </div>
    
    <div class="flex justify-end">
        <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-md">
            ✅ Tambah Peserta
        </button>
    </div>
</form>