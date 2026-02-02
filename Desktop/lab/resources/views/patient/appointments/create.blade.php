<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Zakazi termin') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('patient.appointments.store') }}" method="POST">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Tip testa *</label>
                                <select name="test_type_id" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    <option value="">Izaberi tip testa</option>
                                    @foreach($testTypes as $testType)
                                        <option value="{{ $testType->id }}" {{ old('test_type_id') == $testType->id ? 'selected' : '' }}>
                                            {{ $testType->name }}
                                            @if($testType->price)
                                                - {{ number_format($testType->price, 2) }} KM
                                            @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('test_type_id')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Datum *</label>
                                    <input type="date" name="appointment_date" value="{{ old('appointment_date') }}" required min="{{ date('Y-m-d') }}"
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('appointment_date')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Vrijeme *</label>
                                    <input type="time" name="appointment_time" value="{{ old('appointment_time') }}" required
                                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                    @error('appointment_time')
                                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Napomene</label>
                                <textarea name="notes" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('notes') }}</textarea>
                                @error('notes')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Zakazi termin
                            </button>
                            <a href="{{ route('patient.appointments.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                                Otkaži
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
