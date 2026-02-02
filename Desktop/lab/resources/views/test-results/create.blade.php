<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dodaj nalaz') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('test-results.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Termin *</label>
                                <select name="appointment_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Izaberi termin</option>
                                    @foreach($appointments as $appointment)
                                        <option value="{{ $appointment->id }}">
                                            {{ $appointment->patient->first_name ?? $appointment->patient->name }} {{ $appointment->patient->last_name }} - 
                                            {{ $appointment->testType->name }} - 
                                            {{ $appointment->appointment_date->format('d.m.Y') }} {{ $appointment->appointment_time }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('appointment_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">PDF nalaz</label>
                                <input type="file" name="result_file" accept=".pdf" 
                                    class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                                <p class="text-xs text-gray-500 mt-1">Dozvoljen format: PDF (max 10MB)</p>
                                @error('result_file')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Rezultat (opciono - ako nije u PDF-u)</label>
                                <textarea name="result_data" rows="10"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('result_data') }}</textarea>
                                @error('result_data')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input type="checkbox" name="publish" id="publish" value="1" 
                                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                                <label for="publish" class="ml-2 text-sm font-medium text-gray-700">
                                    Objavi nalaz odmah
                                </label>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" name="action" value="save" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Sačuvaj
                            </button>
                            <button type="submit" name="action" value="publish" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded ml-2">
                                Objavi nalaz
                            </button>
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
