<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }} - Register</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans text-gray-900 antialiased">
    <div class="flex flex-col sm:flex-row min-h-screen bg-gray-100">

        <div class="w-full sm:w-1/2 lg:w-2/5 bg-blue-600 text-white p-12 flex flex-col justify-center items-center relative">
             <div class="absolute top-0 left-0 w-full h-full bg-cover opacity-20" style="background-image: url('https://images.unsplash.com/photo-1584982299241-868352a5de38?q=80&w=1964&auto=format&fit=crop');"></div>
             <div class="relative z-10 text-center">
                 <a href="/" class="flex items-center justify-center mb-8 space-x-2">
                    <svg class="h-10 w-auto text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12z" />
                    </svg>
                    <span class="text-3xl font-bold">Klinik-Q</span>
                </a>
                <h2 class="text-3xl font-bold mb-4">Bergabung dengan Tim Profesional Kami</h2>
                <p class="text-blue-200">Daftarkan diri Anda sebagai staf untuk menjadi bagian dari sistem pelayanan kesehatan yang modern.</p>
            </div>
        </div>

        <div class="w-full sm:w-1/2 lg:w-3/5 bg-white flex justify-center items-center p-8 sm:p-12">
            <div class="w-full max-w-md">
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Buat Akun Staf Baru</h2>
                <p class="text-gray-600 mb-6">Isi data di bawah untuk mendaftar.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="name" :value="__('Nama Lengkap')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password" :value="__('Password')" />
                        <x-text-input id="password" class="block mt-1 w-full"
                                        type="password"
                                        name="password"
                                        required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                        type="password"
                                        name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <div>
                        <x-primary-button class="w-full flex justify-center">
                            {{ __('Register') }}
                        </x-primary-button>
                    </div>
                </form>

                <p class="mt-8 text-center text-sm text-gray-600">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-medium text-blue-600 hover:text-blue-800">
                        Login di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>