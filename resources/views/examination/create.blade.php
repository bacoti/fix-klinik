<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Examination - {{ $patient->name }}
            </h2>
            <a href="{{ route('doctor.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Patient Info & Screening Data -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Patient Information -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Registration Number</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $patient->registration_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                                <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') }} ({{ $patient->age }} years)</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Gender</p>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($patient->gender) }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Address</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $patient->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Screening Data -->
                @if($screening)
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Screening Data</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Complaints</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $screening->complaints }}</p>
                            </div>
                            <div class="grid grid-cols-2 gap-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Blood Pressure</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $screening->blood_pressure_display }}</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Temperature</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $screening->temperature }}°C</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">Heart Rate</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $screening->heart_rate }} bpm</p>
                                </div>
                                <div>
                                    <p class="text-sm font-medium text-gray-500">SpO2</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ $screening->oxygen_saturation }}%</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">BMI</p>
                                <p class="mt-1 text-sm text-gray-900">{{ number_format($screening->bmi, 2) }} ({{ $screening->bmi_category }})</p>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Examination Form -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Examination Form</h3>

                    <form method="POST" action="{{ route('examination.store', $patient) }}" id="examinationForm">
                        @csrf

                        <div class="space-y-6">
                            <!-- Anamnesis -->
                            <div>
                                <label for="anamnesis" class="block text-sm font-medium text-gray-700">Anamnesis / Medical History <span class="text-red-500">*</span></label>
                                <textarea name="anamnesis" id="anamnesis" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Patient's medical history, symptoms timeline, previous treatments...">{{ old('anamnesis') }}</textarea>
                                @error('anamnesis')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Physical Examination -->
                            <div>
                                <label for="physical_examination" class="block text-sm font-medium text-gray-700">Physical Examination <span class="text-red-500">*</span></label>
                                <textarea name="physical_examination" id="physical_examination" rows="4" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Physical examination findings, inspection, palpation, percussion, auscultation...">{{ old('physical_examination') }}</textarea>
                                @error('physical_examination')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Diagnosis -->
                            <div>
                                <label for="diagnosis" class="block text-sm font-medium text-gray-700">Diagnosis <span class="text-red-500">*</span></label>
                                <textarea name="diagnosis" id="diagnosis" rows="3" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Primary diagnosis, differential diagnosis...">{{ old('diagnosis') }}</textarea>
                                @error('diagnosis')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Prescription Text (Optional) -->
                            <div>
                                <label for="prescription_text" class="block text-sm font-medium text-gray-700">Additional Prescription Notes</label>
                                <textarea name="prescription_text" id="prescription_text" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="General prescription instructions, advice, recommendations...">{{ old('prescription_text') }}</textarea>
                                @error('prescription_text')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Medicines Prescription -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Medicines Prescription</label>
                                <div id="medicinesList" class="space-y-3">
                                    <!-- Medicine items will be added here -->
                                </div>
                                <button type="button" onclick="addMedicine()" class="mt-2 inline-flex items-center px-3 py-2 border border-gray-300 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                                    <svg class="h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    Add Medicine
                                </button>
                            </div>

                            <!-- Additional Notes -->
                            <div>
                                <label for="additional_notes" class="block text-sm font-medium text-gray-700">Additional Notes</label>
                                <textarea name="additional_notes" id="additional_notes" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Any additional observations or notes...">{{ old('additional_notes') }}</textarea>
                                @error('additional_notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Sick Letter -->
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex items-center mb-3">
                                    <input type="checkbox" name="sick_letter" id="sick_letter" value="1" {{ old('sick_letter') ? 'checked' : '' }} class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded" onchange="toggleSickDays()">
                                    <label for="sick_letter" class="ml-2 block text-sm font-medium text-gray-900">
                                        Issue Sick Leave Certificate
                                    </label>
                                </div>
                                <div id="sickDaysDiv" style="display: {{ old('sick_letter') ? 'block' : 'none' }};">
                                    <label for="sick_days" class="block text-sm font-medium text-gray-700">Number of Days</label>
                                    <input type="number" name="sick_days" id="sick_days" min="1" max="30" value="{{ old('sick_days', 1) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:w-32">
                                    @error('sick_days')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Follow-up Date -->
                            <div>
                                <label for="follow_up_date" class="block text-sm font-medium text-gray-700">Follow-up Appointment Date</label>
                                <input type="date" name="follow_up_date" id="follow_up_date" value="{{ old('follow_up_date') }}" min="{{ date('Y-m-d', strtotime('+1 day')) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                @error('follow_up_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="mt-6 flex gap-3">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Complete Examination
                            </button>
                            <a href="{{ route('doctor.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                                Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        let medicineCount = 0;
        const medicines = @json($medicines);

        function toggleSickDays() {
            const checkbox = document.getElementById('sick_letter');
            const sickDaysDiv = document.getElementById('sickDaysDiv');
            sickDaysDiv.style.display = checkbox.checked ? 'block' : 'none';
        }

        function addMedicine() {
            const medicinesList = document.getElementById('medicinesList');
            const medicineHtml = `
                <div class="medicine-item border border-gray-200 rounded-lg p-4" id="medicine-${medicineCount}">
                    <div class="flex justify-between items-start mb-3">
                        <h4 class="text-sm font-medium text-gray-900">Medicine #${medicineCount + 1}</h4>
                        <button type="button" onclick="removeMedicine(${medicineCount})" class="text-red-600 hover:text-red-800">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Medicine</label>
                            <select name="medicines[${medicineCount}][medicine_id]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Select Medicine</option>
                                ${medicines.map(m => `<option value="${m.id}">${m.name} (${m.type}) - Stock: ${m.stock} ${m.unit}</option>`).join('')}
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Quantity</label>
                            <input type="number" name="medicines[${medicineCount}][quantity]" min="1" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., 10">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Dosage</label>
                            <input type="text" name="medicines[${medicineCount}][dosage]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., 500mg">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Frequency</label>
                            <input type="text" name="medicines[${medicineCount}][frequency]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., 3x daily">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Duration</label>
                            <input type="text" name="medicines[${medicineCount}][duration]" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="e.g., 7 days">
                        </div>
                    </div>
                </div>
            `;
            medicinesList.insertAdjacentHTML('beforeend', medicineHtml);
            medicineCount++;
        }

        function removeMedicine(index) {
            document.getElementById(`medicine-${index}`).remove();
        }
    </script>
</x-app-layout>
