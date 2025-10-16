<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in as " . auth()->user()->role . "!") }}

                    @if(auth()->user()->role === 'admin')
                        <div class="mt-4">
                            <a href="{{ route('admin.dashboard') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Admin Dashboard
                            </a>
                            <a href="{{ route('patients.index') }}" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded mr-2">
                                Manage Patients
                            </a>
                            <a href="{{ route('registration.create') }}" class="bg-purple-500 hover:bg-purple-700 text-white font-bold py-2 px-4 rounded">
                                Register New Patient
                            </a>
                        </div>
                    @elseif(auth()->user()->role === 'nurse')
                        <div class="mt-4">
                            <a href="{{ route('patients.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                View Patients
                            </a>
                        </div>
                    @elseif(auth()->user()->role === 'doctor')
                        <div class="mt-4">
                            <a href="{{ route('patients.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                View Patients
                            </a>
                        </div>
                    @elseif(auth()->user()->role === 'pharmacist')
                        <div class="mt-4">
                            <a href="{{ route('pharmacy.index') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                                Manage Pharmacy
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
