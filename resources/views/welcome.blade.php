<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Selamat Datang di Klinik-Q</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .hero-bg {
                background-color: #f8fafc;
                background-image:
                    linear-gradient(to bottom, rgba(255, 255, 255, 0.9), rgba(248, 250, 252, 1)),
                    url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 800 800'%3E%3Cg fill='none' stroke='%23e2e8f0' stroke-width='1'%3E%3Cpath d='M769 229L1037 260.9M927 880L731 737 520 660 309 538 40 599 -197 493 102 382-31 229 123 79 332 39 541 3 750 26 851 125 851 229 851 332 750 436 541 538 332 639 123 743-31 847-197 951 102 1054 309 1157 520 1261 731 1364 927 1468'/%3E%3Cpath d='M-31 229L237 261 390 382 603 493 758 599 851 660 927 737 1037 880M1232 660L1037 737M237 261L261 79 332 3 541 3 750 26 851 125 851 229 851 332 750 436 541 538 332 639 123 743-31 847-197 951 102 1054 309 1157 520 1261 731 1364 927 1468'/%3E%3Cpath d='M-197 493L102 382 309 538 40 599-197 493zM102 382L-31 229 123 79 332 3 541 3 750 26 851 125 851 229 851 332 750 436 541 538 332 639 123 743-31 847-197 951 102 1054 309 1157 520 1261 731 1364 927 1468'/%3E%3C/g%3E%3C/svg%3E");
                background-size: cover;
            }
        </style>
    </head>
    <body class="font-sans antialiased text-gray-800 bg-gray-50">
        <div class="min-h-screen flex flex-col">
            <header class="bg-white shadow-sm sticky top-0 z-50">
                <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between items-center py-4">
                        <div class="flex items-center space-x-2">
                            <svg class="h-8 w-auto text-blue-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                            </svg>
                            <span class="text-xl font-bold text-gray-800">Klinik-Q</span>
                        </div>

                        <div class="flex items-center space-x-4">
                            @if (Route::has('login'))
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="text-sm font-medium text-gray-600 hover:text-blue-600 transition-colors">Log in</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="hidden sm:inline-block px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-colors">Register</a>
                                    @endif
                                @endauth
                            @endif
                        </div>
                    </div>
                </nav>
            </header>

            <main class="flex-grow">
                <section class="hero-bg">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
                        <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold text-gray-900 leading-tight">
                            Manajemen Klinik Modern <br class="hidden md:block" /> di Ujung Jari Anda
                        </h1>
                        <p class="mt-6 max-w-2xl mx-auto text-lg text-gray-600">
                            Klinik-Q adalah sistem informasi terintegrasi yang dirancang untuk menyederhanakan alur kerja, meningkatkan efisiensi, dan memberikan pelayanan terbaik bagi pasien Anda.
                        </p>
                        <div class="mt-8 flex justify-center space-x-4">
                            <a href="{{ route('login') }}" class="px-8 py-3 text-base font-medium text-white bg-blue-600 rounded-md hover:bg-blue-700 transition-transform hover:scale-105">
                                Masuk ke Sistem
                            </a>
                            <a href="{{ route('registration.create') }}" class="px-8 py-3 text-base font-medium text-blue-700 bg-blue-100 rounded-md hover:bg-blue-200 transition-transform hover:scale-105">
                                Daftar Pasien Baru
                            </a>
                        </div>
                    </div>
                </section>

                <section class="bg-white py-20">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <div class="text-center">
                            <h2 class="text-3xl font-bold text-gray-900">Solusi Lengkap untuk Klinik Anda</h2>
                            <p class="mt-4 text-lg text-gray-600">
                                Dari pendaftaran hingga apotek, semua terkelola dalam satu platform.
                            </p>
                        </div>
                        <div class="mt-12 grid gap-10 md:grid-cols-3">
                            <div class="text-center">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M15 21a6 6 0 00-9-5.197m9 5.197a6 6 0 01-3.464-12.428 4 4 0 110-5.292" /></svg>
                                </div>
                                <h3 class="mt-5 text-lg font-medium text-gray-900">Manajemen Staf & Pasien</h3>
                                <p class="mt-2 text-base text-gray-600">
                                    Kelola data staf dan riwayat pasien dengan mudah dan aman. Verifikasi data pasien untuk memastikan validitas.
                                </p>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                                </div>
                                <h3 class="mt-5 text-lg font-medium text-gray-900">Rekam Medis Elektronik</h3>
                                <p class="mt-2 text-base text-gray-600">
                                    Pencatatan hasil screening, pemeriksaan, diagnosis, dan resep digital yang terstruktur dan mudah diakses.
                                </p>
                            </div>
                            <div class="text-center">
                                <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                </div>
                                <h3 class="mt-5 text-lg font-medium text-gray-900">Integrasi Apotek</h3>
                                <p class="mt-2 text-base text-gray-600">
                                    Manajemen stok obat, pencatatan resep, dan riwayat pengeluaran obat yang terhubung langsung dengan data pemeriksaan.
                                </p>
                            </div>
                        </div>
                    </div>
                </section>
            </main>

            <footer class="bg-white border-t">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
                    <p>&copy; {{ date('Y') }} Klinik-Q. All rights reserved.</p>
                </div>
            </footer>
        </div>
    </body>
</html>
