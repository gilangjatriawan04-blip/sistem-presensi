<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Presensi Magang') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    
    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <style>
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-800 min-h-screen">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/10 backdrop-blur-md border-b border-white/20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center space-x-2">
                    <div class="bg-gradient-to-r from-blue-400 to-purple-400 w-10 h-10 rounded-xl flex items-center justify-center shadow-lg">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <span class="text-xl font-bold text-white">Presensi<span class="text-blue-300">Magang</span></span>
                </div>
                
                <!-- Navbar Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="#features" class="text-white hover:text-blue-200 transition">Fitur</a>
                    <a href="#stats" class="text-white hover:text-blue-200 transition">Statistik</a>
                    <a href="#contact" class="text-white hover:text-blue-200 transition">Kontak</a>
                </div>
                
                <!-- Navbar Buttons (hanya di pojok kanan) -->
                <div class="flex items-center space-x-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="bg-white text-indigo-900 px-4 py-2 rounded-xl font-semibold hover:bg-opacity-90 transition">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-white hover:text-blue-200 transition px-3 py-2">Login</a>
                        <a href="{{ route('register') }}" class="bg-white text-indigo-900 px-4 py-2 rounded-xl font-semibold hover:bg-opacity-90 transition shadow-md">
                            Daftar
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="pt-24 pb-16 px-4">
        <div class="max-w-7xl mx-auto text-center">
            <h1 class="text-5xl md:text-7xl font-bold text-white mb-6 animate-float">
                Presensi Magang
                <span class="block text-3xl md:text-4xl mt-4 text-blue-200">Mudah, Cepat, dan Akurat</span>
            </h1>
            <p class="text-xl text-white/80 max-w-3xl mx-auto mb-10">
                Aplikasi presensi berbasis lokasi dengan GPS tracking, validasi radius kantor, 
                dan laporan otomatis untuk magang yang lebih profesional.
            </p>
            
            <!-- HERO BUTTONS (tombol besar) -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                @auth
                    <a href="{{ route('dashboard') }}" class="bg-white text-indigo-900 px-8 py-4 rounded-xl font-bold text-lg shadow-2xl hover:shadow-3xl transition transform hover:scale-105">
                        Dashboard →
                    </a>
                @else
                    <a href="{{ route('register') }}" class="bg-white text-indigo-900 px-8 py-4 rounded-xl font-bold text-lg shadow-2xl hover:shadow-3xl transition transform hover:scale-105">
                        Daftar Sekarang
                    </a>
                    <a href="{{ route('login') }}" class="bg-white/20 backdrop-blur-sm text-white border-2 border-white/30 px-8 py-4 rounded-xl font-bold text-lg hover:bg-white/30 transition transform hover:scale-105">
                        Login
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Fitur Cards -->
    <div id="features" class="max-w-7xl mx-auto px-4 py-16">
        <h2 class="text-3xl font-bold text-white text-center mb-12">Fitur Unggulan</h2>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Card GPS -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition group">
                <div class="w-16 h-16 bg-blue-500/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <svg class="w-8 h-8 text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">GPS Tracking</h3>
                <p class="text-white/70">Validasi lokasi otomatis dengan radius kantor yang dapat diatur</p>
            </div>
            
            <!-- Card Realtime -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition group">
                <div class="w-16 h-16 bg-green-500/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <svg class="w-8 h-8 text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Realtime</h3>
                <p class="text-white/70">Data presensi langsung masuk ke sistem dan bisa dimonitor</p>
            </div>
            
            <!-- Card Laporan -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-8 border border-white/20 hover:bg-white/20 transition group">
                <div class="w-16 h-16 bg-purple-500/30 rounded-xl flex items-center justify-center mb-4 group-hover:scale-110 transition">
                    <svg class="w-8 h-8 text-purple-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-white mb-2">Laporan Otomatis</h3>
                <p class="text-white/70">Rekap kehadiran, keterlambatan, dan izin dalam satu dashboard</p>
            </div>
        </div>
    </div>

    <!-- Statistik -->
    <div id="stats" class="max-w-7xl mx-auto px-4 py-16 border-t border-white/20">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
            <div>
                <div class="text-4xl font-bold text-white">100+</div>
                <div class="text-white/60">Peserta Magang</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-white">500+</div>
                <div class="text-white/60">Presensi Harian</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-white">20+</div>
                <div class="text-white/60">Mitra Institusi</div>
            </div>
            <div>
                <div class="text-4xl font-bold text-white">99%</div>
                <div class="text-white/60">Akurasi GPS</div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer id="contact" class="border-t border-white/20 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center text-white/60">
            <p>© {{ date('Y') }} {{ config('app.name', 'Presensi Magang') }}. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>