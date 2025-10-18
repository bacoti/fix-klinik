<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Riwayat Screening: {{ $patient->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                     <div class="flex justify-between items-center mb-6">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Pasien: {{ $patient->name }}</h3>
                            <p class="text-sm text-gray-500">No. RM: {{ $patient->medical_record_number }}</p>
                        </div>
                        <a href="{{ route('nurse.patients') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                            &larr; Kembali
                        </a>
                    </div>
                    
                    <div class="space-y-4">
                        @forelse($screenings as $screening)
                        <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $screening->created_at->format('d F Y, H:i') }}</p>
                                    <p class="text-xs text-gray-500">Oleh: {{ $screening->nurse->name }}</p>
                                </div>
                                <a href="{{ route('screening.show', $screening) }}" class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                            
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3 text-sm">
                                <div>
                                    <p class="text-xs text-gray-500">Suhu</p>
                                    <p class="font-medium text-gray-900">{{ $screening->temperature }}°C</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Tekanan Darah</p>
                                    <p class="font-medium text-gray-900">{{ $screening->blood_pressure ?? '-' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Berat</p>
                                    <p class="font-medium text-gray-900">{{ $screening->weight }} kg</p>
                                </div>
                                <div>
                                    <p class="text-xs text-gray-500">Tinggi</p>
                                    <p class="font-medium text-gray-900">{{ $screening->height }} cm</p>
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <p class="text-xs text-gray-500">Keluhan</p>
                                <p class="text-sm text-gray-800">{{ $screening->complaints }}</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            Belum ada riwayat screening untuk pasien ini.
                        </div>
                        @endforelse
                    </div>

                    @if($screenings->hasPages())
                    <div class="mt-6">
                        {{ $screenings->links() }}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>