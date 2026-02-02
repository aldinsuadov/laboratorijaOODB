<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 w-full">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Nalazi') }}
            </h2>
            <a href="{{ route('test-results.create') }}" class="inline-flex items-center bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded shadow-md transition duration-150 ease-in-out whitespace-nowrap">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                Dodaj nalaz
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
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Pacijent</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Tip testa</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Objavljen</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Akcije</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($testResults as $testResult)
                                    <tr>
                                        <td class="px-6 py-4">{{ $testResult->appointment->patient->first_name ?? $testResult->appointment->patient->name }} {{ $testResult->appointment->patient->last_name }}</td>
                                        <td class="px-6 py-4">{{ $testResult->appointment->testType->name }}</td>
                                        <td class="px-6 py-4">
                                            @if($testResult->status === 'completed')
                                                <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">Završen</span>
                                            @else
                                                <span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-800">U toku</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            @if($testResult->published_at)
                                                <span class="px-2 py-1 text-xs rounded bg-blue-100 text-blue-800">{{ $testResult->published_at->format('d.m.Y H:i') }}</span>
                                            @else
                                                <span class="text-gray-400">-</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ route('test-results.edit', $testResult) }}" class="text-indigo-600 hover:text-indigo-900">Uredi</a>
                                                <a href="{{ route('test-results.edit', $testResult) }}#files" class="text-blue-600 hover:text-blue-900">Dodaj fajl</a>
                                                @if(!$testResult->published_at)
                                                    <form action="{{ route('test-results.publish', $testResult) }}" method="POST" class="inline">
                                                        @csrf
                                                        <button type="submit" class="text-green-600 hover:text-green-900">Objavi</button>
                                                    </form>
                                                @endif
                                                <form action="{{ route('test-results.destroy', $testResult) }}" method="POST" class="inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Da li ste sigurni?')">Obriši</button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">Nema nalaza</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $testResults->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
