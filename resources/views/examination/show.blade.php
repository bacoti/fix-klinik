<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Examination Details
            </h2>
            <div class="flex gap-2">
                <a href="{{ route('examination.edit', $examination) }}" class="inline-flex items-center px-4 py-2 bg-yellow-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-yellow-700">
                    Edit
                </a>
                <a href="{{ route('examination.pdf', $examination) }}" class="inline-flex items-center px-4 py-2 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-700">
                    Download PDF
                </a>
                <a href="{{ route('examination.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                    Back
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Patient & Doctor Information -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Patient Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Patient Information</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Name</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $examination->patient->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Registration Number</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $examination->patient->registration_number }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                                <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($examination->patient->date_of_birth)->format('d M Y') }} ({{ $examination->patient->age }} years)</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Gender</p>
                                <p class="mt-1 text-sm text-gray-900">{{ ucfirst($examination->patient->gender) }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Examination Info -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h3 class="text-lg font-semibold text-gray-900 mb-4">Examination Information</h3>
                        <div class="space-y-3">
                            <div>
                                <p class="text-sm font-medium text-gray-500">Doctor</p>
                                <p class="mt-1 text-sm text-gray-900">Dr. {{ $examination->doctor->name }}</p>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-500">Date & Time</p>
                                <p class="mt-1 text-sm text-gray-900">{{ $examination->created_at->format('d M Y, H:i') }}</p>
                            </div>
                            @if($examination->sick_letter)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Sick Leave</p>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        {{ $examination->sick_days }} day(s)
                                    </span>
                                </p>
                            </div>
                            @endif
                            @if($examination->follow_up_date)
                            <div>
                                <p class="text-sm font-medium text-gray-500">Follow-up Appointment</p>
                                <p class="mt-1">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $examination->follow_up_date->format('d M Y') }}
                                    </span>
                                </p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Screening Data -->
            @if($latestScreening)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Screening Data ({{ $latestScreening->created_at->format('d M Y H:i') }})</h3>
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="bg-gray-50 rounded-lg p-4">
                            <p class="text-xs font-medium text-gray-500 uppercase">Complaints</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $latestScreening->complaints }}</p>
                        </div>
                        <div class="bg-blue-50 rounded-lg p-4">
                            <p class="text-xs font-medium text-gray-500 uppercase">Blood Pressure</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $latestScreening->blood_pressure_display }}</p>
                        </div>
                        <div class="bg-red-50 rounded-lg p-4">
                            <p class="text-xs font-medium text-gray-500 uppercase">Temperature</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $latestScreening->temperature }}°C</p>
                        </div>
                        <div class="bg-green-50 rounded-lg p-4">
                            <p class="text-xs font-medium text-gray-500 uppercase">Heart Rate</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $latestScreening->heart_rate }} bpm</p>
                        </div>
                        <div class="bg-purple-50 rounded-lg p-4">
                            <p class="text-xs font-medium text-gray-500 uppercase">Respiratory Rate</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $latestScreening->respiratory_rate }} /min</p>
                        </div>
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <p class="text-xs font-medium text-gray-500 uppercase">SpO2</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ $latestScreening->oxygen_saturation }}%</p>
                        </div>
                        <div class="bg-indigo-50 rounded-lg p-4">
                            <p class="text-xs font-medium text-gray-500 uppercase">BMI</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900">{{ number_format($latestScreening->bmi, 2) }}</p>
                            <p class="text-xs text-gray-600">{{ $latestScreening->bmi_category }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Medical Examination -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Medical Examination</h3>
                    
                    <div class="space-y-6">
                        <!-- Anamnesis -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 uppercase mb-2">Anamnesis / Medical History</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $examination->anamnesis }}</p>
                            </div>
                        </div>

                        <!-- Physical Examination -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 uppercase mb-2">Physical Examination</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $examination->physical_examination }}</p>
                            </div>
                        </div>

                        <!-- Diagnosis -->
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 uppercase mb-2">Diagnosis</h4>
                            <div class="bg-blue-50 rounded-lg p-4">
                                <p class="text-sm text-gray-900 font-medium whitespace-pre-line">{{ $examination->diagnosis }}</p>
                            </div>
                        </div>

                        <!-- Additional Notes -->
                        @if($examination->additional_notes)
                        <div>
                            <h4 class="text-sm font-semibold text-gray-700 uppercase mb-2">Additional Notes</h4>
                            <div class="bg-gray-50 rounded-lg p-4">
                                <p class="text-sm text-gray-900 whitespace-pre-line">{{ $examination->additional_notes }}</p>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Prescriptions -->
            @if($examination->prescriptions->count() > 0)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Prescriptions</h3>
                    
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Medicine</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dosage</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Frequency</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Duration</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($examination->prescriptions as $prescription)
                                <tr>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-900">{{ $prescription->medicine->name }}</div>
                                        <div class="text-sm text-gray-500">{{ ucfirst($prescription->medicine->type) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $prescription->quantity }} {{ $prescription->medicine->unit }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $prescription->dosage }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $prescription->frequency }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        {{ $prescription->duration }}
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @endif

            <!-- Prescription Text -->
            @if($examination->prescription_text)
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Additional Prescription Notes</h3>
                    <div class="bg-green-50 rounded-lg p-4">
                        <p class="text-sm text-gray-900 whitespace-pre-line">{{ $examination->prescription_text }}</p>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>
</x-app-layout>
