<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Uredi nalaz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('test-results.update', $testResult) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="space-y-4">
                            <div class="bg-gray-50 p-4 rounded">
                                <p class="text-sm text-gray-600"><strong>Pacijent:</strong> {{ $testResult->appointment->patient->first_name ?? $testResult->appointment->patient->name }} {{ $testResult->appointment->patient->last_name }}</p>
                                <p class="text-sm text-gray-600"><strong>Tip testa:</strong> {{ $testResult->appointment->testType->name }}</p>
                                <p class="text-sm text-gray-600"><strong>Termin:</strong> {{ $testResult->appointment->appointment_date->format('d.m.Y') }} {{ $testResult->appointment->appointment_time }}</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rezultat</label>
                                <textarea name="result_data" rows="10"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('result_data', $testResult->result_data) }}</textarea>
                                @error('result_data')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Status *</label>
                                <select name="status" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="pending" {{ $testResult->status === 'pending' ? 'selected' : '' }}>U toku</option>
                                    <option value="completed" {{ $testResult->status === 'completed' ? 'selected' : '' }}>Završen</option>
                                </select>
                                @error('status')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @if($testResult->published_at)
                                <div class="bg-blue-50 p-4 rounded">
                                    <p class="text-sm text-blue-800"><strong>Objavljen:</strong> {{ $testResult->published_at->format('d.m.Y H:i') }}</p>
                                </div>
                            @else
                                <div class="bg-yellow-50 p-4 rounded">
                                    <p class="text-sm text-yellow-800">Nalaz nije objavljen. Kliknite "Objavi nalaz" nakon što završite unos.</p>
                                </div>
                            @endif

                            <!-- File Upload Section -->
                            <div id="files" class="border-t pt-4 mt-4">
                                <h3 class="text-lg font-medium text-gray-900 mb-4">Fajlovi</h3>
                                
                                <!-- Upload Form -->
                                <form action="{{ route('test-results.upload', $testResult) }}" method="POST" enctype="multipart/form-data" class="mb-4">
                                    @csrf
                                    <div class="flex items-center gap-4">
                                        <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                        <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                            Dodaj fajl
                                        </button>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1">Dozvoljeni formati: PDF, JPG, PNG, JPEG (max 10MB)</p>
                                </form>

                                <!-- Files List -->
                                @if($testResult->resultFiles->count() > 0)
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
                                                            {{ $file->mime ?? $file->file_type }} 
                                                            @if($file->file_size)
                                                                • {{ number_format($file->file_size / 1024, 2) }} KB
                                                            @endif
                                                        </p>
                                                    </div>
                                                </div>
                                                <a href="{{ route('test-results.files.download', ['testResult' => $testResult, 'file' => $file]) }}" 
                                                   class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded text-sm">
                                                    Preuzmi
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500">Nema priloženih fajlova</p>
                                @endif
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Ažuriraj
                            </button>
                            @if(!$testResult->published_at)
                                <form action="{{ route('test-results.publish', $testResult) }}" method="POST" class="inline ml-2">
                                    @csrf
                                    <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                        Objavi nalaz
                                    </button>
                                </form>
                            @endif
                            <a href="{{ route('test-results.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                                Otkaži
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
