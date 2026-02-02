<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dobrodošli') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!-- Hero Section with Laboratory Image -->
                <div class="relative h-64 md:h-96 bg-gradient-to-r from-blue-600 to-blue-800">
                    <!-- Placeholder for laboratory image - you can replace this with actual image -->
                    <div class="absolute inset-0 bg-cover bg-center opacity-30" style="background-image: url('https://images.unsplash.com/photo-1559757148-5c350d0d3c56?ixlib=rb-4.0.3&auto=format&fit=crop&w=2000&q=80');"></div>
                    <div class="relative h-full flex items-center justify-center">
                        <div class="text-center text-white px-4">
                            <h1 class="text-4xl md:text-5xl font-bold mb-4">Laboratorija</h1>
                            <p class="text-xl md:text-2xl">Vaš pouzdan partner za laboratorijske analize</p>
                        </div>
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                        <!-- Moji termini Card -->
                        <a href="{{ route('patient.appointments.index') }}" class="block bg-gradient-to-br from-blue-50 to-blue-100 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-blue-500 rounded-lg p-4">
                                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-xl font-semibold text-gray-900">Moji termini</h3>
                                    <p class="text-sm text-gray-600 mt-1">Pregledajte i zakazujte termine</p>
                                </div>
                            </div>
                        </a>

                        <!-- Moji nalazi Card -->
                        <a href="{{ route('patient.test-results.index') }}" class="block bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6 hover:shadow-lg transition-shadow">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 bg-green-500 rounded-lg p-4">
                                    <svg class="h-8 w-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-xl font-semibold text-gray-900">Moji nalazi</h3>
                                    <p class="text-sm text-gray-600 mt-1">Pregledajte svoje laboratorijske nalaze</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Welcome Message -->
                    <div class="bg-gray-50 rounded-lg p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Dobrodošli, {{ auth()->user()->name }}!</h3>
                        <p class="text-gray-600">
                            Ovdje možete pronaći sve informacije o vašim terminima i laboratorijskim nalazima. 
                            Koristite gornje kartice za brz pristup vašim podacima.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
