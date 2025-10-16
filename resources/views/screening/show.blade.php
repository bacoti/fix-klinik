@extends('layouts.app')

@section('title', 'Detail Screening')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Detail Screening</h2>
        <a href="{{ route('screening.index') }}" class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    <!-- Patient Info Card -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <h3 class="text-lg font-medium text-gray-900">Informasi Pasien</h3>
        </div>
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $screening->patient->name }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">No. Rekam Medis</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $screening->patient->medical_record_number }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $screening->patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Umur</p>
                    <p class="mt-1 text-sm text-gray-900">{{ $screening->patient->age }} tahun</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Screening Info Card -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex justify-between items-center">
            <h3 class="text-lg font-medium text-gray-900">Data Screening</h3>
            <div class="text-sm text-gray-500">
                {{ $screening->created_at->format('d F Y, H:i') }}
            </div>
        </div>
        <div class="px-6 py-4">
            <div class="space-y-6">
                <!-- Vital Signs -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 mb-3">Vital Signs</h4>
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        <div class="bg-blue-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Suhu Tubuh</p>
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

                        @if($screening->respiratory_rate)
                        <div class="bg-green-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Respirasi</p>
                            <p class="mt-1 text-2xl font-bold text-green-600">{{ $screening->respiratory_rate }}</p>
                            <p class="text-xs text-gray-500">kali/menit</p>
                        </div>
                        @endif

                        @if($screening->oxygen_saturation)
                        <div class="bg-indigo-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Saturasi Oksigen</p>
                            <p class="mt-1 text-2xl font-bold text-indigo-600">{{ $screening->oxygen_saturation }}%</p>
                            <p class="text-xs text-gray-500">SpO2</p>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Body Measurements -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 mb-3">Pengukuran Tubuh</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="bg-purple-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Berat Badan</p>
                            <p class="mt-1 text-2xl font-bold text-purple-600">{{ $screening->weight }}</p>
                            <p class="text-xs text-gray-500">kg</p>
                        </div>
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">Tinggi Badan</p>
                            <p class="mt-1 text-2xl font-bold text-yellow-600">{{ $screening->height }}</p>
                            <p class="text-xs text-gray-500">cm</p>
                        </div>
                        <div class="bg-orange-50 p-4 rounded-lg">
                            <p class="text-sm font-medium text-gray-500">BMI</p>
                            <p class="mt-1 text-2xl font-bold text-orange-600">{{ $screening->bmi }}</p>
                            <p class="text-xs text-gray-500">{{ $screening->bmi_category }}</p>
                        </div>
                    </div>
                </div>

                <!-- Complaints -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 mb-2">Keluhan Pasien</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-900">{{ $screening->complaints }}</p>
                    </div>
                </div>

                <!-- Notes -->
                @if($screening->notes)
                <div>
                    <h4 class="text-md font-medium text-gray-900 mb-2">Catatan Perawat</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-900">{{ $screening->notes }}</p>
                    </div>
                </div>
                @endif

                <!-- Nurse Info -->
                <div>
                    <h4 class="text-md font-medium text-gray-900 mb-2">Perawat yang Melayani</h4>
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-sm text-gray-900">{{ $screening->nurse->name }}</p>
                        <p class="text-xs text-gray-500">{{ $screening->nurse->email }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions -->
    @if(auth()->id() === $screening->nurse_id)
    <div class="flex justify-end space-x-3">
        <a href="{{ route('screening.edit', $screening) }}" 
           class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
            Edit Screening
        </a>
    </div>
    @endif
</div>
@endsection
