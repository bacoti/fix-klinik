@extends('layouts.app')

@section('title', 'Daftar Pasien')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Daftar Pasien</h2>
            <p class="mt-1 text-sm text-gray-600">Kelola screening pasien</p>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-4">
        <form method="GET" action="{{ route('nurse.patients') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[250px]">
                <input type="text" name="search" placeholder="Cari nama, No. RM, atau telepon..." 
                    value="{{ request('search') }}"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div class="min-w-[180px]">
                <select name="status" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">Semua Status</option>
                    <option value="not_screened" {{ request('status') == 'not_screened' ? 'selected' : '' }}>Belum Screening</option>
                    <option value="screened" {{ request('status') == 'screened' ? 'selected' : '' }}>Sudah Screening</option>
                </select>
            </div>
            <div class="min-w-[150px]">
                <input type="date" name="date" value="{{ request('date') }}"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Filter
            </button>
            <a href="{{ route('nurse.patients') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-200">
                Reset
            </a>
        </form>
    </div>

    <!-- Patients Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. RM</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Umur</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No. Telp</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status Screening</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($patients as $patient)
                    <tr class="{{ $patient->screenings->isEmpty() ? 'bg-yellow-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $patient->medical_record_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $patient->name }}</div>
                            <div class="text-xs text-gray-500">{{ $patient->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $patient->age }} tahun
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $patient->phone }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($patient->screenings->isEmpty())
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                    Belum Screening
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Sudah Screening ({{ $patient->screenings->count() }}x)
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('patients.show', $patient) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                            
                            @if($patient->screenings->isEmpty())
                                <a href="{{ route('screening.create', $patient) }}" class="text-green-600 hover:text-green-900">Screening</a>
                            @else
                                <a href="{{ route('nurse.screening-history', $patient) }}" class="text-blue-600 hover:text-blue-900">Riwayat</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada pasien ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($patients->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $patients->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
