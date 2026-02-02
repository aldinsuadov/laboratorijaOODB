<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Moji termini') }}
            </h2>
            <a href="{{ route('patient.appointments.create') }}" class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-150 ease-in-out whitespace-nowrap">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Zakazi termin
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">

                    @if(session('success'))
                        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tip testa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Datum</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Vrijeme</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nalaz</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($appointments as $appointment)
                                    <tr>
                                        <td class="px-6 py-4">{{ $appointment->testType->name }}</td>
                                        <td class="px-6 py-4">{{ $appointment->appointment_date->format('d.m.Y') }}</td>
                                        <td class="px-6 py-4">{{ $appointment->appointment_time }}</td>
                                        <td class="px-6 py-4">
                                            @if($appointment->status === 'scheduled')
                                                <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">Zakazan</span>
                                            @elseif($appointment->status === 'done')
                                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Završen</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded bg-red-100 text-red-800">Otkazan</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($appointment->testResult && $appointment->testResult->published_at)
                                                <a href="{{ route('patient.test-results.show', $appointment->testResult) }}" class="text-blue-600 hover:text-blue-900">
                                                    Pogledaj nalaz
                                                </a>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nemate zakazanih termina</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $appointments->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
