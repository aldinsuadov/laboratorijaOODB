<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Statistika') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="space-y-6">
                
                <!-- Top Test Types -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Top tipovi testova</h3>
                        <p class="text-sm text-gray-500 mb-4">Broj termina po tipu testa</p>
                        
                        @if($topTestTypes->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tip testa</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Broj termina</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Procenat</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @php
                                            $totalAppointments = $topTestTypes->sum('count');
                                        @endphp
                                        @foreach($topTestTypes as $testType)
                                            @php
                                                $percentage = $totalAppointments > 0 ? round(($testType->count / $totalAppointments) * 100, 1) : 0;
                                            @endphp
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                                    {{ $testType->name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $testType->count }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    <div class="flex items-center">
                                                        <div class="w-full bg-gray-200 rounded-full h-2.5 mr-2">
                                                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                                                        </div>
                                                        <span class="text-sm text-gray-500">{{ $percentage }}%</span>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Nema podataka</p>
                        @endif
                    </div>
                </div>

                <!-- Published vs Unpublished Results -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Status nalaza</h3>
                        <p class="text-sm text-gray-500 mb-4">Objavljeni vs neobjavljeni nalazi</p>
                        
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-green-800">Objavljeni</p>
                                        <p class="text-2xl font-bold text-green-900">{{ $resultsStatus['published'] }}</p>
                                    </div>
                                    <svg class="h-8 w-8 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-yellow-800">Neobjavljeni</p>
                                        <p class="text-2xl font-bold text-yellow-900">{{ $resultsStatus['unpublished'] }}</p>
                                    </div>
                                    <svg class="h-8 w-8 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            
                            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-blue-800">Ukupno</p>
                                        <p class="text-2xl font-bold text-blue-900">{{ $resultsStatus['total'] }}</p>
                                    </div>
                                    <svg class="h-8 w-8 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        @if($resultsStatus['total'] > 0)
                            <div class="mt-4">
                                <div class="flex items-center mb-2">
                                    <span class="text-sm font-medium text-gray-700 mr-2">Objavljeni:</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-4">
                                        <div class="bg-green-500 h-4 rounded-full" style="width: {{ ($resultsStatus['published'] / $resultsStatus['total']) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-700 ml-2">{{ round(($resultsStatus['published'] / $resultsStatus['total']) * 100, 1) }}%</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-sm font-medium text-gray-700 mr-2">Neobjavljeni:</span>
                                    <div class="flex-1 bg-gray-200 rounded-full h-4">
                                        <div class="bg-yellow-500 h-4 rounded-full" style="width: {{ ($resultsStatus['unpublished'] / $resultsStatus['total']) * 100 }}%"></div>
                                    </div>
                                    <span class="text-sm text-gray-700 ml-2">{{ round(($resultsStatus['unpublished'] / $resultsStatus['total']) * 100, 1) }}%</span>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Average Time to Publish (only in days) -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Prosječno vrijeme od termina do objave nalaza</h3>
                        
                        @if($avgDays > 0)
                            <div class="bg-purple-50 border border-purple-200 rounded-lg p-6">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-purple-800">Prosječno u danima</p>
                                        <p class="text-3xl font-bold text-purple-900 mt-2">{{ $avgDays }}</p>
                                        <p class="text-xs text-purple-600 mt-1">dana</p>
                                    </div>
                                    <svg class="h-12 w-12 text-purple-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Nema objavljenih nalaza za izračunavanje prosjeka</p>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
