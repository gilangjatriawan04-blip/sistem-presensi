@props(['user', 'size' => 'w-24 h-24'])

<div class="relative group">
    <!-- Avatar Display -->
    <div class="{{ $size }} rounded-full overflow-hidden border-4 border-white shadow-xl bg-gradient-to-br from-blue-400 to-purple-500 flex items-center justify-center">
        @if($user->avatar)
            <img src="{{ asset('storage/' . $user->avatar) }}" 
                 alt="{{ $user->name }}" 
                 class="w-full h-full object-cover"
                 id="avatar-image">
        @else
            <span class="text-3xl font-bold text-white" id="avatar-initial">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </span>
        @endif
    </div>

    <!-- Upload Button -->
    <label for="avatar-upload" 
           class="absolute inset-0 flex items-center justify-center bg-black/50 rounded-full opacity-0 hover:opacity-100 transition cursor-pointer">
        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
        </svg>
    </label>

    <!-- File Input -->
    <input type="file" 
           id="avatar-upload" 
           class="hidden" 
           accept="image/jpeg,image/png,image/jpg"
           onchange="uploadAvatar(this)">
</div>

<script>
function uploadAvatar(input) {
    const file = input.files[0];
    if (!file) return;
    
    // Validasi ukuran (max 2MB)
    if (file.size > 2 * 1024 * 1024) {
        alert('Ukuran file maksimal 2MB');
        return;
    }
    
    // Preview
    const reader = new FileReader();
    reader.onload = function(e) {
        const img = document.getElementById('avatar-image');
        const initial = document.getElementById('avatar-initial');
        
        if (img) {
            img.src = e.target.result;
        } else if (initial) {
            // Ganti inisial dengan gambar
            const avatarDiv = initial.parentNode;
            avatarDiv.innerHTML = `<img src="${e.target.result}" alt="" class="w-full h-full object-cover" id="avatar-image">`;
        }
    };
    reader.readAsDataURL(file);
    
    // Upload via fetch
    const formData = new FormData();
    formData.append('avatar', file);
    formData.append('_token', '{{ csrf_token() }}');
    
    fetch('{{ route("profile.avatar") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Foto berhasil diupload!');
        } else {
            alert('Gagal: ' + data.message);
        }
    })
    .catch(error => {
        alert('Error: ' + error.message);
    });
}
</script>