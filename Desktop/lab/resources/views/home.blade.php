<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laboratorija') }}</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    
    <!-- Styles / Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="font-sans antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <h1 class="text-xl font-bold text-gray-900">Laboratorija</h1>
                </div>
                <div class="flex items-center space-x-4">
                    @auth
                        <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-700 hover:text-gray-900 px-3 py-2 rounded-md text-sm font-medium">
                            Prijava
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                Registracija
                            </a>
                        @endif
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section with Laboratory Image -->
    <div class="relative w-full" style="height: 60vh; min-height: 400px;">
        <img src="https://images.unsplash.com/photo-1532187863566-d141819c7070?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
             alt="Laboratorija" 
             class="w-full h-full object-cover"
             style="position: absolute; top: 0; left: 0; width: 100%; height: 100%;"
             onerror="this.onerror=null; this.src='https://images.unsplash.com/photo-1582719471384-894fbb16e074?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80';">
        <!-- Overlay with text -->
        <div class="absolute inset-0 flex items-center justify-center bg-black bg-opacity-30">
            <h1 class="font-bold text-white tracking-wider uppercase leading-none" style="font-size: 100px;">LABORATORIJA</h1>
        </div>
    </div>

    <!-- Text Section -->
    <div class="bg-white py-16">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-bold text-gray-900 mb-6">Dobrodošli u Laboratoriju</h2>
            <p class="text-xl text-gray-700 mb-4">Vaš pouzdan partner za laboratorijske analize i dijagnostiku</p>
            <p class="text-lg text-gray-600">
                Pružamo vrhunske usluge laboratorijskih analiza sa najsavremenijom opremom i iskusnim timom stručnjaka
            </p>
        </div>
    </div>

    <!-- Google Maps Section -->
    <div class="bg-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-8">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Naša lokacija</h2>
                <p class="text-lg text-gray-600">Posjetite nas na našoj adresi</p>
            </div>
            
            <!-- Google Maps Embed -->
            <div class="flex justify-center">
                <div class="rounded-lg overflow-hidden shadow-xl" style="max-width: 450px; width: 100%;">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2878.1234567890!2d18.4131!3d43.8563!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNDPCsDUxJzIyLjciTiAxOMKwMjQnNDcuMiJF!5e0!3m2!1sen!2sba!4v1234567890123!5m2!1sen!2sba"
                        width="100%" 
                        height="250" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        class="w-full">
                    </iframe>
                </div>
            </div>
            
            <!-- Contact Information -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-6 text-center">
                <div class="p-6 bg-gray-50 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <h3 class="font-semibold text-gray-900 mb-2">Adresa</h3>
                    <p class="text-gray-600">Ulica i broj<br>Sarajevo, BiH</p>
                </div>
                
                <div class="p-6 bg-gray-50 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                    </svg>
                    <h3 class="font-semibold text-gray-900 mb-2">Telefon</h3>
                    <p class="text-gray-600">037 225 883</p>
                </div>
                
                <div class="p-6 bg-gray-50 rounded-lg">
                    <svg class="w-8 h-8 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="font-semibold text-gray-900 mb-2">Email</h3>
                    <p class="text-gray-600">info@laboratorija.ba</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <p class="text-gray-400">&copy; {{ date('Y') }} Laboratorija. Sva prava zadržana.</p>
        </div>
    </footer>

    @livewireScripts
</body>
</html>
