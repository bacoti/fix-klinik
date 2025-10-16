<!-- Full implementation of the show.blade.php file for viewing patient details -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-gray-800 mb-4">Patient Details</h1>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700">Basic Information</h2>
        <p><strong>Name:</strong> {{ $patient->name }}</p>
        <p><strong>Email:</strong> {{ $patient->email }}</p>
        <p><strong>Phone:</strong> {{ $patient->phone }}</p>
        <p><strong>Address:</strong> {{ $patient->address }}</p>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h2 class="text-xl font-semibold text-gray-700">Medical Records</h2>
        @if($patient->medicalRecords->isEmpty())
            <p class="text-gray-600">No medical records available.</p>
        @else
            @foreach($patient->medicalRecords as $record)
                <div class="border-b border-gray-200 py-4">
                    <p><strong>Type:</strong> {{ ucfirst($record->activity_type) }}</p>
                    @if($record->activity_type === 'examination')
                        <p><strong>Diagnosis:</strong> {{ $record->details['diagnosis'] }}</p>
                        <p><strong>Prescription:</strong> {{ $record->details['prescription_text'] }}</p>
                        @if($record->details['sick_letter'])
                            <p><strong>Sick Letter:</strong> Yes</p>
                        @endif
                        @if($patient->examinations->where('id', $record->id)->first())
                            <a href="{{ route('examination.pdf', $patient->examinations->where('id', $record->id)->first()) }}" class="text-blue-600 hover:text-blue-900">Download PDF</a>
                        @endif
                    @endif
                </div>
            @endforeach
        @endif
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <h2 class="text-xl font-semibold text-gray-700">Recent Examinations</h2>
        @if($patient->examinations->isEmpty())
            <p class="text-gray-600">No examinations available.</p>
        @else
            <ul class="list-disc list-inside">
                @foreach($patient->examinations as $examination)
                    <li>
                        <p><strong>Date:</strong> {{ $examination->created_at->format('d M Y') }}</p>
                        <p><strong>Details:</strong> {{ $examination->details }}</p>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection
