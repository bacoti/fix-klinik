<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Examination History - {{ $patient->name }}
            </h2>
            <a href="{{ route('doctor.patients') }}" class="inline-flex items-center px-4 py-2 bg-gray-300 border border-transparent rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-400">
                Back to Patients
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Patient Info -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500">Registration Number</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $patient->registration_number }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Date of Birth</p>
                            <p class="mt-1 text-sm text-gray-900">{{ \Carbon\Carbon::parse($patient->date_of_birth)->format('d M Y') }} ({{ $patient->age }} years)</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Contact</p>
                            <p class="mt-1 text-sm text-gray-900">{{ $patient->phone_number }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Examinations History -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Examination History</h3>
                    
                    @if($examinations->count() > 0)
                    <div class="space-y-6">
                        @foreach($examinations as $examination)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <div class="flex justify-between items-start mb-3">
                                <div>
                                    <p class="text-sm font-medium text-gray-900">{{ $examination->created_at->format('d M Y H:i') }}</p>
                                    <p class="text-sm text-gray-500">Dr. {{ $examination->doctor->name }}</p>
                                </div>
                                <div class="flex gap-2">
                                    <a href="{{ route('examination.show', $examination) }}" class="inline-flex items-center px-3 py-1 border border-blue-600 text-sm font-medium rounded-md text-blue-600 hover:bg-blue-50">
                                        View Details
                                    </a>
                                    <a href="{{ route('examination.pdf', $examination) }}" class="inline-flex items-center px-3 py-1 border border-green-600 text-sm font-medium rounded-md text-green-600 hover:bg-green-50">
                                        Download PDF
                                    </a>
                                </div>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase">Anamnesis</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ Str::limit($examination->anamnesis, 100) }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-500 uppercase">Physical Examination</p>
                                    <p class="mt-1 text-sm text-gray-900">{{ Str::limit($examination->physical_examination, 100) }}</p>
                                </div>
                            </div>

                            <div class="mt-3 pt-3 border-t border-gray-200">
                                <p class="text-xs font-medium text-gray-500 uppercase">Diagnosis</p>
                                <p class="mt-1 text-sm font-semibold text-gray-900">{{ $examination->diagnosis }}</p>
                            </div>

                            @if($examination->prescriptions->count() > 0)
                            <div class="mt-3">
                                <p class="text-xs font-medium text-gray-500 uppercase mb-2">Prescriptions</p>
                                <div class="bg-gray-50 rounded-md p-3">
                                    <ul class="space-y-1">
                                        @foreach($examination->prescriptions as $prescription)
                                        <li class="text-sm text-gray-900">
                                            • {{ $prescription->medicine->name }} - {{ $prescription->dosage }}, {{ $prescription->frequency }}, {{ $prescription->duration }}
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            @endif

                            @if($examination->sick_letter)
                            <div class="mt-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    Sick Leave: {{ $examination->sick_days }} day(s)
                                </span>
                            </div>
                            @endif

                            @if($examination->follow_up_date)
                            <div class="mt-3">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                    Follow-up: {{ $examination->follow_up_date->format('d M Y') }}
                                </span>
                            </div>
                            @endif
                        </div>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="mt-6">
                        {{ $examinations->links() }}
                    </div>
                    @else
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="mt-2 text-sm text-gray-500">No examination history</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
