<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Medicines') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Medicine List</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Stock</th>
                                <th class="px-4 py-2">Expired At</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($medicines as $medicine)
                            <tr>
                                <td class="px-4 py-2">{{ $medicine->name }}</td>
                                <td class="px-4 py-2">
                                    @if($medicine->stock <= 0)
                                        <span class="text-red-600">Out of Stock</span>
                                    @elseif($medicine->stock < 10)
                                        <span class="text-yellow-600">Low ({{ $medicine->stock }})</span>
                                    @else
                                        {{ $medicine->stock }}
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if($medicine->expired_at && $medicine->expired_at->isPast())
                                        <span class="text-red-600">{{ $medicine->expired_at->format('d M Y') }}</span>
                                    @else
                                        {{ $medicine->expired_at ? $medicine->expired_at->format('d M Y') : '-' }}
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4 text-gray-500">No medicines found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
