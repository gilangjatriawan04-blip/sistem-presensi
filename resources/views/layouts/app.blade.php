<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <title>{{ config('app.name', 'Presensi Magang') }} - @yield('title', 'Dashboard')</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS via CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        /* Custom scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb {
            background: #3b82f6;
            border-radius: 10px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #2563eb;
        }
        
        /* Animasi fade in */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in {
            animation: fadeIn 0.3s ease-out;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-gray-100 to-gray-200">
    
    <!-- Navigation -->
    @include('layouts.navigation')
    
    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white border-b border-gray-200 shadow-sm sticky top-16 z-40">
            <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center">
                    <h1 class="text-2xl font-bold text-gray-800 flex items-center">
                        <span class="bg-blue-600 w-1.5 h-8 rounded-full mr-3"></span>
                        {{ $header }}
                    </h1>
                    
                    <!-- Role Badge -->
                    @auth
                        @php
                            $roleColors = [
                                'admin' => 'bg-gradient-to-r from-red-600 to-red-700 text-white',
                                'pembimbing' => 'bg-gradient-to-r from-purple-600 to-purple-700 text-white',
                                'peserta' => 'bg-gradient-to-r from-green-600 to-green-700 text-white',
                            ];
                            $colorClass = $roleColors[auth()->user()->role] ?? 'bg-gradient-to-r from-gray-600 to-gray-700 text-white';
                        @endphp
                        <span class="px-4 py-2 rounded-full text-sm font-semibold shadow-md {{ $colorClass }}">
                            {{ ucfirst(auth()->user()->role) }}
                            @if(auth()->user()->role == 'peserta' && auth()->user()->jenis_peserta)
                                <span class="border-l border-white/30 pl-2 text-xs">
                                    {{ ucfirst(auth()->user()->jenis_peserta) }}
                                </span>
                            @endif
                        </span>
                    @endauth
                </div>
            </div>
        </header>
    @endisset
    
    <!-- Page Content -->
    <main class="py-8 fade-in">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Notifications -->
            @if(session('success'))
                <div class="mb-6 bg-green-100 border-l-8 border-green-500 p-4 rounded-lg shadow-md">
                    <p class="text-sm font-bold text-green-800">✅ {{ session('success') }}</p>
                </div>
            @endif
            
            @if(session('error'))
                <div class="mb-6 bg-red-100 border-l-8 border-red-500 p-4 rounded-lg shadow-md">
                    <p class="text-sm font-bold text-red-800">❌ {{ session('error') }}</p>
                </div>
            @endif
            
            @if(session('warning'))
                <div class="mb-6 bg-yellow-100 border-l-8 border-yellow-500 p-4 rounded-lg shadow-md">
                    <p class="text-sm font-bold text-yellow-800">⚠️ {{ session('warning') }}</p>
                </div>
            @endif
            
            {{ $slot }}
        </div>
    </main>
    
    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto py-4 shadow-inner">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center text-sm text-gray-600">
                <p>© {{ date('Y') }} {{ config('app.name', 'Sistem Presensi Magang') }}</p>
                <p>v1.0.0</p>
            </div>
        </div>
    </footer>
</body>
</html>