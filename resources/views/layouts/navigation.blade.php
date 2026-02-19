<nav class="bg-gradient-to-r from-blue-600 to-indigo-700 shadow-lg sticky top-0 z-50" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <!-- Logo -->
            <div class="flex items-center">
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-2 group">
                    <div class="bg-white w-9 h-9 rounded-xl flex items-center justify-center shadow-md group-hover:scale-110 transition-transform duration-300">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-white font-bold text-lg hidden sm:block group-hover:text-yellow-200 transition">
                        {{ config('app.name', 'Presensi') }}
                    </span>
                </a>
            </div>

            <!-- Desktop Menu -->
            <div class="hidden md:flex items-center space-x-1">
                <!-- Dashboard -->
                <a href="{{ route('dashboard') }}" 
                   class="text-white hover:text-yellow-200 hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('dashboard') ? 'bg-white/20 text-yellow-200' : '' }}">
                    Dashboard
                </a>

                @if(auth()->user()->role == 'peserta')
                    <a href="{{ route('presensi.index') }}" 
                       class="text-white hover:text-yellow-200 hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('presensi.*') ? 'bg-white/20 text-yellow-200' : '' }}">
                        Presensi
                    </a>
                    <a href="{{ route('izin.index') }}" 
                       class="text-white hover:text-yellow-200 hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('izin.*') ? 'bg-white/20 text-yellow-200' : '' }}">
                        Izin
                    </a>
                @endif

                @if(auth()->user()->role == 'admin')
                    <a href="{{ route('admin.users.index') }}" 
                       class="text-white hover:text-yellow-200 hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.users.*') ? 'bg-white/20 text-yellow-200' : '' }}">
                        Users
                    </a>
                    <a href="{{ route('admin.izin.index') }}" 
                       class="text-white hover:text-yellow-200 hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.izin.*') ? 'bg-white/20 text-yellow-200' : '' }}">
                        Izin
                    </a>
                    <a href="{{ route('admin.settings.index') }}" 
                       class="text-white hover:text-yellow-200 hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('admin.settings.*') ? 'bg-white/20 text-yellow-200' : '' }}">
                        Settings
                    </a>
                @endif

                @if(auth()->user()->role == 'pembimbing')
                    <a href="{{ route('pembimbing.peserta') }}" 
                       class="text-white hover:text-yellow-200 hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('pembimbing.peserta*') ? 'bg-white/20 text-yellow-200' : '' }}">
                        Peserta
                    </a>
                    <a href="{{ route('pembimbing.izin') }}" 
                       class="text-white hover:text-yellow-200 hover:bg-white/10 px-3 py-2 rounded-lg text-sm font-medium transition {{ request()->routeIs('pembimbing.izin') ? 'bg-white/20 text-yellow-200' : '' }}">
                        Izin
                    </a>
                @endif
            </div>

           <!-- Profile Dropdown dengan HOVER -->
<div class="relative group">
    <!-- Trigger Button (tanpa klik) -->
    <button class="flex items-center space-x-2 bg-white/10 hover:bg-white/20 px-3 py-2 rounded-xl transition-all duration-300 group">
        
        <span class="text-white font-medium hidden sm:inline">{{ auth()->user()->name }}</span>
        
        <!-- Avatar dengan Efek -->
        <div class="relative w-8 h-8 rounded-full overflow-hidden ring-2 ring-white/30 group-hover:ring-yellow-400 transition-all duration-300">
            @if(auth()->user()->avatar)
                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                     alt="{{ auth()->user()->name }}" 
                     class="w-full h-full object-cover">
            @else
                <div class="w-full h-full bg-gradient-to-br from-yellow-400 to-yellow-500 flex items-center justify-center text-blue-900 font-bold">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
            @endif
        </div>
        
        <!-- Icon Panah (tetap tanpa rotate) -->
        <svg class="w-4 h-4 text-white transition-transform duration-300 group-hover:rotate-180" 
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>

    <!-- Dropdown Menu muncul saat HOVER -->
    <div class="absolute right-0 top-full mt-2 w-64 bg-white rounded-xl shadow-2xl py-2 border border-gray-100 z-50 
                opacity-0 invisible group-hover:opacity-100 group-hover:visible 
                transition-all duration-300 transform 
                group-hover:translate-y-0 translate-y-2">
        
        <!-- Header Dropdown (Info User) -->
        <div class="px-4 py-3 border-b border-gray-100">
            <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
            <p class="text-xs text-gray-500 mt-0.5">{{ auth()->user()->email }}</p>
            <div class="mt-2 flex flex-wrap gap-1">
                <span class="inline-block px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">
                    {{ ucfirst(auth()->user()->role) }}
                </span>
                @if(auth()->user()->role == 'peserta' && auth()->user()->jenis_peserta)
                    <span class="inline-block px-2 py-1 bg-green-100 text-green-800 text-xs rounded-full">
                        {{ ucfirst(auth()->user()->jenis_peserta) }}
                    </span>
                @endif
            </div>
        </div>
        
        <!-- Menu Items dengan Ikon -->
        <a href="{{ route('profile.edit') }}" 
           class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 transition group">
            <div class="w-8 h-8 rounded-full bg-blue-100 flex items-center justify-center mr-3 group-hover:bg-blue-200 transition">
                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
            </div>
            <div>
                <p class="font-medium">Profile</p>
                <p class="text-xs text-gray-500">Ubah data diri</p>
            </div>
        </a>
        
        <!-- Logout dengan Ikon -->
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" 
                    class="flex items-center w-full px-4 py-3 text-sm text-red-600 hover:bg-red-50 transition group">
                <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center mr-3 group-hover:bg-red-200 transition">
                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </div>
                <div>
                    <p class="font-medium">Logout</p>
                    <p class="text-xs text-gray-500">Akhiri sesi</p>
                </div>
            </button>
        </form>
    </div>
</div>

            <!-- Mobile Menu Button -->
            <div class="flex items-center md:hidden">
                <button @click="open = !open" class="text-white p-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open}" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open}" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="open" x-transition class="md:hidden bg-white border-t border-gray-200">
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 rounded-md">
                Dashboard
            </a>
            @if(auth()->user()->role == 'peserta')
                <a href="{{ route('presensi.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 rounded-md">
                    Presensi
                </a>
                <a href="{{ route('izin.index') }}" class="block px-3 py-2 text-base font-medium text-gray-700 hover:bg-gray-100 rounded-md">
                    Izin
                </a>
            @endif
        </div>
    </div>
</nav>

<!-- Alpine.js -->
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>