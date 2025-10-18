<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Screening Pasien: {{ $patient->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <form method="POST" action="{{ route('screening.store', $patient) }}" class="space-y-8">
                        @csrf

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-3 mb-4">Vital Signs</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                                <div>
                                    <label for="temperature" class="block text-sm font-medium text-gray-700">Suhu (°C) *</label>
                                    <input type="number" step="0.1" name="temperature" id="temperature" value="{{ old('temperature') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('temperature') border-red-500 @enderror">
                                    <x-input-error :messages="$errors->get('temperature')" class="mt-1" />
                                </div>
                                <div>
                                    <label for="weight" class="block text-sm font-medium text-gray-700">Berat (kg) *</label>
                                    <input type="number" step="0.1" name="weight" id="weight" value="{{ old('weight') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('weight') border-red-500 @enderror">
                                    <x-input-error :messages="$errors->get('weight')" class="mt-1" />
                                </div>
                                <div>
                                    <label for="height" class="block text-sm font-medium text-gray-700">Tinggi (cm) *</label>
                                    <input type="number" step="0.1" name="height" id="height" value="{{ old('height') }}" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('height') border-red-500 @enderror">
                                    <x-input-error :messages="$errors->get('height')" class="mt-1" />
                                </div>
                                <div>
                                    <label for="blood_pressure_systolic" class="block text-sm font-medium text-gray-700">Tekanan Darah (Systolic)</label>
                                    <input type="number" name="blood_pressure_systolic" id="blood_pressure_systolic" value="{{ old('blood_pressure_systolic') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <div>
                                    <label for="blood_pressure_diastolic" class="block text-sm font-medium text-gray-700">Tekanan Darah (Diastolic)</label>
                                    <input type="number" name="blood_pressure_diastolic" id="blood_pressure_diastolic" value="{{ old('blood_pressure_diastolic') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                                <div>
                                    <label for="heart_rate" class="block text-sm font-medium text-gray-700">Denyut Nadi (bpm)</label>
                                    <input type="number" name="heart_rate" id="heart_rate" value="{{ old('heart_rate') }}" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div>
                            <h3 class="text-lg font-medium text-gray-900 border-b pb-3 mb-4">Keluhan & Catatan</h3>
                            <div class="space-y-4">
                                <div>
                                    <label for="complaints" class="block text-sm font-medium text-gray-700">Keluhan Pasien *</label>
                                    <textarea name="complaints" id="complaints" rows="4" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm @error('complaints') border-red-500 @enderror">{{ old('complaints') }}</textarea>
                                    <x-input-error :messages="$errors->get('complaints')" class="mt-1" />
                                </div>
                                <div>
                                    <label for="notes" class="block text-sm font-medium text-gray-700">Catatan Perawat</label>
                                    <textarea name="notes" id="notes" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">{{ old('notes') }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">Catatan tambahan atau observasi (opsional).</p>
                                </div>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-3 pt-4">
                            <a href="{{ url()->previous() }}" class="inline-flex items-center px-4 py-2 bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-gray-800 uppercase tracking-widest hover:bg-gray-300">
                                Batal
                            </a>
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                Simpan Screening
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>