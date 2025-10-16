<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prescription History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Dispensed Prescriptions</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Patient</th>
                                <th class="px-4 py-2">Medicine</th>
                                <th class="px-4 py-2">Quantity</th>
                                <th class="px-4 py-2">Dispensed By</th>
                                <th class="px-4 py-2">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($prescriptions as $prescription)
                            <tr>
                                <td class="px-4 py-2">{{ $prescription->examination->patient->name }}</td>
                                <td class="px-4 py-2">{{ $prescription->medicine->name }}</td>
                                <td class="px-4 py-2">{{ $prescription->quantity }}</td>
                                <td class="px-4 py-2">{{ $prescription->dispensed_by }}</td>
                                <td class="px-4 py-2">{{ $prescription->dispensed_at->format('Y-m-d H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">No dispensed prescriptions found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $prescriptions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
