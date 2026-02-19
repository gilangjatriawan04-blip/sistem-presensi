<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Manajemen User') }}
            </h2>
            <div class="flex gap-2">
                <!-- TOMBOL TAMBAH ADMIN -->
                <a href="{{ route('admin.users.create.admin') }}" 
                   class="bg-gradient-to-r from-red-500 to-red-600 hover:from-red-600 hover:to-red-700 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-md hover:shadow-lg transition-all transform hover:scale-105 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    + Admin
                </a>
                
                <!-- TOMBOL TAMBAH PEMBIMBING -->
                <a href="{{ route('admin.users.create.pembimbing') }}" 
                   class="bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-md hover:shadow-lg transition-all transform hover:scale-105 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    + Pembimbing
                </a>
                
                <!-- TOMBOL TAMBAH PESERTA -->
                <a href="{{ route('admin.users.create.peserta') }}" 
                   class="bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white px-4 py-2 rounded-xl text-sm font-medium shadow-md hover:shadow-lg transition-all transform hover:scale-105 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                    </svg>
                    + Peserta
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <!-- Statistik Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 mb-6">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-sm text-gray-500">Total User</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $stats['total'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-sm text-gray-500">Admin</p>
                    <p class="text-2xl font-bold text-red-600">{{ $stats['admin'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-sm text-gray-500">Pembimbing</p>
                    <p class="text-2xl font-bold text-purple-600">{{ $stats['pembimbing'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-sm text-gray-500">Peserta</p>
                    <p class="text-2xl font-bold text-green-600">{{ $stats['peserta'] ?? 0 }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4">
                    <p class="text-sm text-gray-500">Magang Aktif</p>
                    <p class="text-2xl font-bold text-yellow-600">{{ $stats['magang_aktif'] ?? 0 }}</p>
                </div>
            </div>

            <!-- Filter & Search Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 mb-6">
                <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-wrap items-end gap-4">
                    <!-- Filter Role -->
                    <div class="w-full sm:w-auto">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                        <select name="role" class="w-full sm:w-40 border-gray-300 rounded-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Semua Role</option>
                            <option value="admin" {{ $role == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="pembimbing" {{ $role == 'pembimbing' ? 'selected' : '' }}>Pembimbing</option>
                            <option value="peserta" {{ $role == 'peserta' ? 'selected' : '' }}>Peserta</option>
                        </select>
                    </div>
                    
                    <!-- Search -->
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cari User</label>
                        <div class="flex">
                            <input type="text" name="search" value="{{ $search ?? '' }}" 
                                   placeholder="Nama atau email..."
                                   class="flex-1 border-gray-300 rounded-l-lg text-sm focus:ring-blue-500 focus:border-blue-500">
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-r-lg text-sm font-medium transition">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Reset Filter -->
                    <div>
                        <a href="{{ route('admin.users.index') }}" 
                           class="inline-block bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium transition">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            <!-- Tabel Users -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Institusi</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Periode Magang</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($users as $user)
                            <tr class="hover:bg-blue-50 transition even:bg-gray-50">
                             <td class="px-6 py-4 whitespace-nowrap">
    <div class="flex items-center">
        <!-- Avatar dengan kondisi (gambar atau inisial) -->
        <div class="w-10 h-10 rounded-full bg-gradient-to-r from-blue-400 to-blue-500 flex items-center justify-center text-white font-bold text-sm mr-3 overflow-hidden shadow-sm">
            @if($user->avatar)
                <img src="{{ asset('storage/' . $user->avatar) }}" 
                     alt="{{ $user->name }}" 
                     class="w-full h-full object-cover">
            @else
                {{ strtoupper(substr($user->name, 0, 1)) }}
            @endif
        </div>
        <div>
            <div class="text-sm font-medium text-gray-900">{{ $user->name }}</div>
            <div class="text-xs text-gray-500">{{ $user->email }}</div>
        </div>
    </div>
</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $roleColors = [
                                            'admin' => 'bg-red-100 text-red-800 border-red-200',
                                            'pembimbing' => 'bg-purple-100 text-purple-800 border-purple-200',
                                            'peserta' => 'bg-green-100 text-green-800 border-green-200',
                                        ];
                                        $colorClass = $roleColors[$user->role] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-3 py-1 text-xs font-medium rounded-full border {{ $colorClass }}">
                                        {{ ucfirst($user->role) }}
                                        @if($user->role == 'peserta' && $user->jenis_peserta)
                                            <span class="ml-1 opacity-75">({{ $user->jenis_peserta }})</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    @if($user->institution_name)
                                        <p class="text-sm text-gray-900">{{ $user->institution_name }}</p>
                                        <p class="text-xs text-gray-500">{{ $user->institution_class ?? '' }}</p>
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if($user->start_date && $user->end_date)
                                        <div class="text-xs">
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($user->start_date)->format('d/m/Y') }}</span>
                                            <span class="text-gray-400"> - </span>
                                            <span class="font-medium">{{ \Carbon\Carbon::parse($user->end_date)->format('d/m/Y') }}</span>
                                        </div>
                                        @php
                                            $today = now();
                                            $end = \Carbon\Carbon::parse($user->end_date);
                                            $daysLeft = $today->diffInDays($end, false);
                                        @endphp
                                        @if($daysLeft > 0)
                                            <span class="text-xs text-green-600">{{ $daysLeft }} hari lagi</span>
                                        @elseif($daysLeft == 0)
                                            <span class="text-xs text-yellow-600">Hari terakhir</span>
                                        @else
                                            <span class="text-xs text-red-600">Selesai</span>
                                        @endif
                                    @else
                                        <span class="text-sm text-gray-400">-</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center space-x-2">
                                        <a href="{{ route('admin.users.edit', $user) }}" 
                                           class="text-blue-600 hover:text-blue-900 p-1 rounded hover:bg-blue-50 transition">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </a>
                                        
                                        @if($user->id !== Auth::id())
                                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" 
                                                  onsubmit="return confirm('Hapus user {{ $user->name }}?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="text-red-600 hover:text-red-900 p-1 rounded hover:bg-red-50 transition">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                    </svg>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-500">
                                    <svg class="mx-auto h-12 w-12 text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13 1.197h-6" />
                                    </svg>
                                    <p class="text-sm">Tidak ada user ditemukan.</p>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                
                <!-- Pagination -->
                @if($users->hasPages())
                <div class="px-6 py-4 border-t border-gray-200">
                    {{ $users->links() }}
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>