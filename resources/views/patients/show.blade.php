<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Patient Details') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Basic Information</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
                    <div>
                        <p class="text-gray-500">Name</p>
                        <p class="font-medium text-gray-900">{{ $patient->name }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Registration Number</p>
                        <p class="font-medium text-gray-900">{{ $patient->registration_number }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Email Address</p>
                        <p class="font-medium text-gray-900">{{ $patient->email }}</p>
                    </div>
                    <div>
                        <p class="text-gray-500">Phone Number</p>
                        <p class="font-medium text-gray-900">{{ $patient->phone_number }}</p>
                    </div>
                    <div class="col-span-2">
                        <p class="text-gray-500">Address</p>
                        <p class="font-medium text-gray-900">{{ $patient->address }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Medical Records</h2>
                @if($patient->medicalRecords->isEmpty())
                    <p class="text-gray-600">No medical records available.</p>
                @else
                    <div class="space-y-4">
                        @foreach($patient->medicalRecords as $record)
                            <div class="border-b border-gray-200 py-4">
                                <p><strong>Type:</strong> {{ ucfirst($record->activity_type) }}</p>
                                @if(isset($record->details) && is_array($record->details))
                                    @if($record->activity_type === 'examination')
                                        <p><strong>Diagnosis:</strong> {{ $record->details['diagnosis'] ?? 'N/A' }}</p>
                                        @if(!empty($record->details['prescription_text']))
                                            <p><strong>Prescription:</strong> {{ $record->details['prescription_text'] }}</p>
                                        @endif
                                        @if($record->details['sick_letter'])
                                            <p><strong>Sick Letter:</strong> Yes, for {{ $record->details['sick_days'] ?? 'N/A' }} days</p>
                                        @endif
                                    @endif
                                @endif
                                <p class="text-xs text-gray-500 mt-1">{{ \Carbon\Carbon::parse($record->activity_date)->format('d M Y H:i') }}</p>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h2 class="text-xl font-semibold text-gray-800 border-b pb-3 mb-4">Recent Examinations</h2>
                @if($patient->examinations->isEmpty())
                    <p class="text-gray-600">No examinations available.</p>
                @else
                    <ul class="divide-y divide-gray-200">
                        @foreach($patient->examinations as $examination)
                            <li class="py-3">
                                <div class="flex justify-between">
                                    <div>
                                        <p class="font-medium text-gray-900">Diagnosis: {{ $examination->diagnosis }}</p>
                                        <p class="text-sm text-gray-500">By Dr. {{ $examination->doctor->name }} on {{ $examination->created_at->format('d M Y') }}</p>
                                    </div>
                                    <div>
                                        <a href="{{ route('examination.show', $examination) }}" class="text-blue-600 hover:text-blue-800 text-sm">View Details</a>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
