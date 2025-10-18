<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detail Screening
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 border-b">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Informasi Pasien</h3>
                        </div>
                         <a href="{{ url()->previous() }}" class="text-sm text-blue-600 hover:text-blue-800">
                            &larr; Kembali
                        </a>
                    </div>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                        <p class="mt-1 text-gray-900">{{ $screening->patient->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">No. Rekam Medis</p>
                        <p class="mt-1 text-gray-900">{{ $screening->patient->medical_record_number }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                        <p class="mt-1 text-gray-900">{{ $screening->patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-gray-500">Umur</p>
                        <p class="mt-1 text-gray-900">{{ $screening->patient->age }} tahun</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg">
                <div class="p-6 border-b flex justify-between items-center">
                    <h3 class="text-lg font-medium text-gray-900">Data Screening</h3>
                    <div class="text-sm text-gray-500">
                        {{ $screening->created_at->format('d F Y, H:i') }}
                    </div>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <h4 class="text-md font-medium text-gray-900 mb-3">Vital Signs</h4>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-500">Suhu</p>
                                <p class="mt-1 text-2xl font-bold text-blue-600">{{ $screening->temperature }}°C</p>
                            </div>
                            @if($screening->blood_pressure)
                            <div class="bg-red-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-500">Tekanan Darah</p>
                                <p class="mt-1 text-2xl font-bold text-red-600">{{ $screening->blood_pressure }}</p>
                                <p class="text-xs text-gray-500">mmHg</p>
                            </div>
                            @endif
                             @if($screening->heart_rate)
                            <div class="bg-pink-50 p-4 rounded-lg">
                                <p class="text-sm font-medium text-gray-500">Denyut Nadi</p>
                                <p class="mt-1 text-2xl font-bold text-pink-600">{{ $screening->heart_rate }}</p>
                                <p class="text-xs text-gray-500">bpm</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-2">Keluhan Pasien</h4>
                            <div class="bg-gray-50 p-4 rounded-lg h-full">
                                <p class="text-sm text-gray-900">{{ $screening->complaints }}</p>
                            </div>
                        </div>
                        @if($screening->notes)
                        <div>
                            <h4 class="text-md font-medium text-gray-900 mb-2">Catatan Perawat</h4>
                            <div class="bg-gray-50 p-4 rounded-lg h-full">
                                <p class="text-sm text-gray-900">{{ $screening->notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                 @if(auth()->id() === $screening->nurse_id)
                <div class="p-6 bg-gray-50 border-t flex justify-end">
                    <a href="{{ route('screening.edit', $screening) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                        Edit Screening
                    </a>
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>