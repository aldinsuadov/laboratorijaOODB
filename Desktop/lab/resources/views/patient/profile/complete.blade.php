<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dovršite svoj profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Dobrodošli, {{ auth()->user()->name }}!</h3>
                        <p class="text-sm text-gray-600">
                            Molimo vas da unesete dodatne podatke kako bismo mogli nastaviti sa vašim profilom.
                        </p>
                    </div>

                    <x-validation-errors class="mb-4" />

                    @if (session('warning'))
                        <div class="mb-4 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                            <p class="text-sm text-yellow-800">{{ session('warning') }}</p>
                        </div>
                    @endif

                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-50 border border-green-200 rounded-md">
                            <p class="text-sm text-green-800">{{ session('success') }}</p>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('patient.profile.store') }}">
                        @csrf

                        <div class="space-y-4">
                            <div>
                                <x-label for="jmbg" value="{{ __('JMBG') }}" />
                                <x-input id="jmbg" class="block mt-1 w-full" type="text" name="jmbg" 
                                    :value="old('jmbg', $patient->jmbg)" 
                                    required 
                                    autofocus 
                                    maxlength="13"
                                    pattern="[0-9]{13}"
                                    placeholder="Unesite 13-cifreni JMBG" />
                                <p class="mt-1 text-sm text-gray-500">JMBG mora imati tačno 13 cifara</p>
                                @error('jmbg')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <x-label for="phone" value="{{ __('Broj telefona') }}" />
                                <x-input id="phone" class="block mt-1 w-full" type="text" name="phone" 
                                    :value="old('phone', $patient->phone)" 
                                    required 
                                    placeholder="+387 XX XXX XXX" />
                                @error('phone')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="mt-4">
                                <x-label for="date_of_birth" value="{{ __('Datum rođenja') }}" />
                                <x-input id="date_of_birth" class="block mt-1 w-full" type="date" name="date_of_birth" 
                                    :value="old('date_of_birth', $patient->date_of_birth ? $patient->date_of_birth->format('Y-m-d') : '')" 
                                    required 
                                    max="{{ date('Y-m-d', strtotime('-1 day')) }}" />
                                @error('date_of_birth')
                                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-6">
                            <x-button>
                                {{ __('Sačuvaj') }}
                            </x-button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
