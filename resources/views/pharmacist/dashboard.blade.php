<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Pharmacist Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-blue-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-6a2 2 0 012-2h2a2 2 0 012 2v6" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Total Medicines</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $totalMedicines }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-yellow-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m4 4h-1v-4h-1" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Low Stock</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $lowStock }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-red-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Out of Stock</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $outOfStock }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 bg-gray-500 rounded-md p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3" />
                                </svg>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-gray-500">Expired</p>
                                <p class="text-2xl font-semibold text-gray-900">{{ $expired }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Prescriptions & Notifications -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Waiting Prescriptions</h3>
                        <p class="mb-2 text-sm text-gray-500">Total: <span class="font-bold">{{ $waitingPrescriptions }}</span></p>
                        <ul>
                            @foreach($recentPrescriptions->whereNull('dispensed_at')->take(5) as $prescription)
                                <li class="mb-2">
                                    <span class="font-semibold">{{ $prescription->examination->patient->name }}</span> -
                                    <span class="text-gray-500">{{ $prescription->medicine->name }}</span>
                                    <span class="text-xs text-gray-400">({{ $prescription->created_at->format('d M H:i') }})</span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('pharmacist.prescriptions') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">View All Prescriptions</a>
                    </div>
                </div>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Low Stock Medicines</h3>
                        <ul>
                            @foreach($lowStockMedicines as $medicine)
                                <li class="mb-2">
                                    <span class="font-semibold">{{ $medicine->name }}</span> -
                                    <span class="text-red-500">Stock: {{ $medicine->stock }}</span>
                                </li>
                            @endforeach
                        </ul>
                        <a href="{{ route('pharmacist.medicines') }}" class="text-blue-600 hover:underline text-sm mt-2 inline-block">View All Medicines</a>
                    </div>
                </div>
            </div>

            <!-- Expired Medicines -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Expired Medicines</h3>
                    <ul>
                        @foreach($expiredMedicines as $medicine)
                            <li class="mb-2">
                                <span class="font-semibold">{{ $medicine->name }}</span> -
                                <span class="text-gray-500">Expired: {{ $medicine->expired_at ? $medicine->expired_at->format('d M Y') : '-' }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
