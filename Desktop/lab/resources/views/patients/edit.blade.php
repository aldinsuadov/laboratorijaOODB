<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Uredi pacijenta') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <form action="{{ route('patients.update', $patient) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ime *</label>
                                <input type="text" name="first_name" value="{{ old('first_name', $patient->first_name ?? $patient->name) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('first_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Prezime *</label>
                                <input type="text" name="last_name" value="{{ old('last_name', $patient->last_name) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('last_name')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">JMBG *</label>
                                <input type="text" name="jmbg" value="{{ old('jmbg', $patient->jmbg) }}" required maxlength="13"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('jmbg')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Datum rođenja *</label>
                                <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $patient->date_of_birth?->format('Y-m-d')) }}" required
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('date_of_birth')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input type="email" name="email" value="{{ old('email', $patient->email) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('email')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Telefon</label>
                                <input type="text" name="phone" value="{{ old('phone', $patient->phone) }}"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Adresa</label>
                                <textarea name="address" rows="3"
                                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">{{ old('address', $patient->address) }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Ažuriraj
                            </button>
                            <a href="{{ route('patients.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded ml-2">
                                Otkaži
                            </a>
                        </div>
                    </form>

                    @if(!$patient->user_id)
                        <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded">
                            <h3 class="text-lg font-medium text-yellow-800 mb-2">Poveži sa korisnikom</h3>
                            <form action="{{ route('patients.link-user', $patient) }}" method="POST" class="flex gap-2">
                                @csrf
                                <input type="email" name="email" placeholder="Email korisnika" required
                                    class="flex-1 rounded-md border-gray-300 shadow-sm">
                                <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    Poveži
                                </button>
                            </form>
                            @if(session('error'))
                                <p class="text-red-500 text-sm mt-2">{{ session('error') }}</p>
                            @endif
                        </div>
                    @else
                        <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded">
                            <p class="text-green-800">
                                <strong>Povezan sa korisnikom:</strong> {{ $patient->user->email }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
