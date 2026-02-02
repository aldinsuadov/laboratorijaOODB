<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Nalaz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="space-y-6">
                        <!-- Patient and Test Info -->
                        <div class="bg-gray-50 p-4 rounded">
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Informacije o testu</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-600"><strong>Tip testa:</strong> {{ $testResult->appointment->testType->name }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600"><strong>Datum termina:</strong> {{ $testResult->appointment->appointment_date->format('d.m.Y') }} {{ $testResult->appointment->appointment_time }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-600"><strong>Objavljen:</strong> {{ $testResult->published_at->format('d.m.Y H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Result Data -->
                        @if($testResult->result_data)
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 mb-3">Rezultat</h3>
                                <div class="bg-white border border-gray-200 rounded p-4">
                                    <pre class="whitespace-pre-wrap text-sm text-gray-700">{{ $testResult->result_data }}</pre>
                                </div>
                            </div>
                        @endif

                        <!-- Files -->
                        <div>
                            <h3 class="text-lg font-medium text-gray-900 mb-3">Priloženi fajlovi</h3>
                            @if($testResult->resultFiles && $testResult->resultFiles->count() > 0)
                                <div class="space-y-2">
                                    @foreach($testResult->resultFiles as $file)
                                        <div class="flex items-center justify-between bg-gray-50 p-3 rounded">
                                            <div class="flex items-center gap-3">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                                </svg>
                                                <div>
                                                    <p class="text-sm font-medium text-gray-900">{{ $file->original_name ?? $file->file_name }}</p>
                                                    <p class="text-xs text-gray-500">
                                                        {{ $file->mime ?? $file->file_type ?? 'PDF' }} 
                                                        @if($file->file_size)
                                                            • {{ number_format($file->file_size / 1024, 2) }} KB
                                                        @endif
                                                    </p>
                                                </div>
                                            </div>
                                            <a href="{{ route('test-results.files.download', ['testResult' => $testResult->id, 'file' => $file->id]) }}" 
                                               class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                Preuzmi
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="bg-gray-50 p-4 rounded">
                                    <p class="text-sm text-gray-500">Nema priloženih fajlova za ovaj nalaz.</p>
                                </div>
                            @endif
                        </div>

                        <div class="mt-6">
                            <a href="{{ route('patient.test-results.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                                Nazad
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
