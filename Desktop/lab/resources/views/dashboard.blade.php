<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if(in_array(auth()->user()->role, ['admin', 'laborant']))
                <!-- Statistics Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Pacijenti</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Patient::count() }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('patients.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">Pogledaj sve →</a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-green-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Tipovi testova</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\TestType::count() }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('test-types.index') }}" class="text-green-600 hover:text-green-800 text-sm font-medium">Pogledaj sve →</a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Termini</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\Appointment::count() }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('appointments.index') }}" class="text-yellow-600 hover:text-yellow-800 text-sm font-medium">Pogledaj sve →</a>
                        </div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-purple-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Nalazi</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ \App\Models\TestResult::count() }}</p>
                            </div>
                        </div>
                        <div class="mt-4">
                            <a href="{{ route('test-results.index') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium">Pogledaj sve →</a>
                        </div>
                    </div>
                </div>

                <!-- Recent Appointments -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-lg font-medium text-gray-900">Najnoviji termini</h3>
                            <a href="{{ route('appointments.index') }}" class="text-sm text-blue-600 hover:text-blue-800">Pogledaj sve →</a>
                        </div>
                        @php
                            $recentAppointments = \App\Models\Appointment::with(['patient', 'testType'])
                                ->orderBy('appointment_date', 'desc')
                                ->orderBy('appointment_time', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        @if($recentAppointments->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pacijent</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tip testa</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datum</th>
                                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                        @foreach($recentAppointments as $appointment)
                                            <tr>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                                    {{ $appointment->patient->first_name ?? $appointment->patient->name }} {{ $appointment->patient->last_name }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $appointment->testType->name }}</td>
                                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                    {{ $appointment->appointment_date->format('d.m.Y') }} {{ $appointment->appointment_time }}
                                                </td>
                                                <td class="px-6 py-4 whitespace-nowrap">
                                                    @if($appointment->status === 'scheduled')
                                                        <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">Zakazan</span>
                                                    @elseif($appointment->status === 'done')
                                                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Završen</span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">Otkazan</span>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <p class="text-sm text-gray-500">Nema termina</p>
                        @endif
                    </div>
                </div>
            @else
                <!-- Patient Dashboard -->
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Dobrodošli, {{ auth()->user()->name }}!</h3>
                        <p class="text-gray-600 mb-4">Ovdje možete pronaći svoje termine i nalaze.</p>
                        
                        @if(auth()->user()->patient)
                            @php
                                $myAppointments = \App\Models\Appointment::where('patient_id', auth()->user()->patient->id)
                                    ->with(['testType', 'testResult'])
                                    ->orderBy('appointment_date', 'desc')
                                    ->limit(5)
                                    ->get();
                            @endphp
                            
                            @if($myAppointments->count() > 0)
                                <h4 class="text-md font-medium text-gray-900 mt-6 mb-3">Moji termini</h4>
                                <div class="space-y-3">
                                    @foreach($myAppointments as $appointment)
                                        <div class="border border-gray-200 rounded-lg p-4">
                                            <div class="flex justify-between items-start">
                                                <div>
                                                    <p class="font-medium text-gray-900">{{ $appointment->testType->name }}</p>
                                                    <p class="text-sm text-gray-500">{{ $appointment->appointment_date->format('d.m.Y') }} {{ $appointment->appointment_time }}</p>
                                                </div>
                                                <div>
                                                    @if($appointment->status === 'scheduled')
                                                        <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">Zakazan</span>
                                                    @elseif($appointment->status === 'done')
                                                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Završen</span>
                                                    @else
                                                        <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">Otkazan</span>
                                                    @endif
                                                </div>
                                            </div>
                                            @if($appointment->testResult && $appointment->testResult->published_at)
                                                <div class="mt-2">
                                                    <a href="{{ route('test-results.edit', $appointment->testResult) }}" class="text-sm text-blue-600 hover:text-blue-800">
                                                        Pogledaj nalaz →
                                                    </a>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-sm text-gray-500">Nemate zakazanih termina</p>
                            @endif
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
