<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Stock Log') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Stock Log Records</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Medicine</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Quantity</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td class="px-4 py-2">{{ $log->medicine->name }}</td>
                                <td class="px-4 py-2">{{ ucfirst($log->type) }}</td>
                                <td class="px-4 py-2">{{ $log->quantity }}</td>
                                <td class="px-4 py-2">{{ $log->description }}</td>
                                <td class="px-4 py-2">{{ $log->created_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">No stock log records found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $logs->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
