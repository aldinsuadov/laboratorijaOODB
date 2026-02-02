<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tipovi testova') }}
            </h2>
            <a href="{{ route('test-types.create') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                + Dodaj tip testa
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Naziv</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Opis</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Cijena</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Akcije</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($testTypes as $testType)
                                    <tr>
                                        <td class="px-6 py-4">{{ $testType->name }}</td>
                                        <td class="px-6 py-4">{{ Str::limit($testType->description, 50) }}</td>
                                        <td class="px-6 py-4">{{ $testType->price ? number_format($testType->price, 2) . ' KM' : '-' }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('test-types.edit', $testType) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Uredi</a>
                                            <form action="{{ route('test-types.destroy', $testType) }}" method="POST" class="inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Da li ste sigurni?')">Obriši</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="px-6 py-4 text-center text-gray-500">Nema tipova testova</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $testTypes->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
