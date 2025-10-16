<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Prescriptions') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold mb-4">Waiting to be Dispensed</h3>
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Patient</th>
                                <th class="px-4 py-2">Medicine</th>
                                <th class="px-4 py-2">Quantity</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($prescriptions as $prescription)
                            <tr>
                                <td class="px-4 py-2">{{ $prescription->examination->patient->name }}</td>
                                <td class="px-4 py-2">{{ $prescription->medicine->name }}</td>
                                <td class="px-4 py-2">{{ $prescription->quantity }}</td>
                                <td class="px-4 py-2">
                                    @if($prescription->dispensed_at)
                                        <span class="text-green-600">Dispensed</span>
                                    @else
                                        <span class="text-yellow-600">Waiting</span>
                                    @endif
                                </td>
                                <td class="px-4 py-2">
                                    @if(!$prescription->dispensed_at)
                                    <form method="POST" action="{{ route('pharmacist.dispense', $prescription->id) }}">
                                        @csrf
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded">Dispense</button>
                                    </form>
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-4 text-gray-500">No prescriptions found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
