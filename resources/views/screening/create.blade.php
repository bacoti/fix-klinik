@extends('layouts.app')

@section('title', 'Screening Pasien')

@section('content')
<div class="max-w-4xl mx-auto space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Screening Pasien</h2>
            <p class="mt-1 text-sm text-gray-600">{{ $patient->name }} ({{ $patient->medical_record_number }})</p>
        </div>
        <a href="{{ route('nurse.patients') }}" class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    <!-- Form -->
    <div class="bg-white shadow rounded-lg p-6">
        <form method="POST" action="{{ route('screening.store', $patient) }}" class="space-y-6">
            @csrf

            <!-- Vital Signs Section -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Vital Signs</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="temperature" class="block text-sm font-medium text-gray-700">Suhu Tubuh (°C) *</label>
                        <input type="number" step="0.1" name="temperature" id="temperature" value="{{ old('temperature') }}" 
                               min="30" max="45" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('temperature') border-red-500 @enderror">
                        @error('temperature')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="blood_pressure_systolic" class="block text-sm font-medium text-gray-700">Tekanan Darah Systolic (mmHg)</label>
                        <input type="number" name="blood_pressure_systolic" id="blood_pressure_systolic" value="{{ old('blood_pressure_systolic') }}" 
                               min="70" max="250"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('blood_pressure_systolic') border-red-500 @enderror">
                        @error('blood_pressure_systolic')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="blood_pressure_diastolic" class="block text-sm font-medium text-gray-700">Tekanan Darah Diastolic (mmHg)</label>
                        <input type="number" name="blood_pressure_diastolic" id="blood_pressure_diastolic" value="{{ old('blood_pressure_diastolic') }}" 
                               min="40" max="150"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('blood_pressure_diastolic') border-red-500 @enderror">
                        @error('blood_pressure_diastolic')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="heart_rate" class="block text-sm font-medium text-gray-700">Denyut Nadi (bpm)</label>
                        <input type="number" name="heart_rate" id="heart_rate" value="{{ old('heart_rate') }}" 
                               min="40" max="200"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('heart_rate') border-red-500 @enderror">
                        @error('heart_rate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="respiratory_rate" class="block text-sm font-medium text-gray-700">Respirasi (kali/menit)</label>
                        <input type="number" name="respiratory_rate" id="respiratory_rate" value="{{ old('respiratory_rate') }}" 
                               min="10" max="60"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('respiratory_rate') border-red-500 @enderror">
                        @error('respiratory_rate')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="oxygen_saturation" class="block text-sm font-medium text-gray-700">Saturasi Oksigen (%)</label>
                        <input type="number" name="oxygen_saturation" id="oxygen_saturation" value="{{ old('oxygen_saturation') }}" 
                               min="70" max="100"
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('oxygen_saturation') border-red-500 @enderror">
                        @error('oxygen_saturation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Body Measurements Section -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Pengukuran Tubuh</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label for="weight" class="block text-sm font-medium text-gray-700">Berat Badan (kg) *</label>
                        <input type="number" step="0.1" name="weight" id="weight" value="{{ old('weight') }}" 
                               min="1" max="300" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('weight') border-red-500 @enderror">
                        @error('weight')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="height" class="block text-sm font-medium text-gray-700">Tinggi Badan (cm) *</label>
                        <input type="number" step="0.1" name="height" id="height" value="{{ old('height') }}" 
                               min="50" max="250" required
                               class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('height') border-red-500 @enderror">
                        @error('height')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Complaints Section -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4">Keluhan & Catatan</h3>
                <div class="space-y-4">
                    <div>
                        <label for="complaints" class="block text-sm font-medium text-gray-700">Keluhan Pasien *</label>
                        <textarea name="complaints" id="complaints" rows="4" required
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('complaints') border-red-500 @enderror">{{ old('complaints') }}</textarea>
                        @error('complaints')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Perawat</label>
                        <textarea name="notes" id="notes" rows="3"
                                  class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 @error('notes') border-red-500 @enderror">{{ old('notes') }}</textarea>
                        <p class="mt-1 text-sm text-gray-500">Catatan tambahan atau observasi (opsional)</p>
                        @error('notes')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="flex justify-end space-x-3">
                <a href="{{ route('nurse.patients') }}" 
                   class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    Simpan Screening
                </button>
            </div>
        </form>
    </div>
</div>
@endsection