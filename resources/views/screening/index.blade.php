@extends('layouts.app')

@section('title', 'Riwayat Screening')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <h2 class="text-2xl font-bold text-gray-900">Riwayat Screening</h2>
        <p class="mt-1 text-sm text-gray-600">Semua data screening pasien</p>
    </div>

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-4">
        <form method="GET" action="{{ route('screening.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[250px]">
                <input type="text" name="search" placeholder="Cari nama pasien atau No. RM..." 
                    value="{{ request('search') }}"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div class="min-w-[150px]">
                <input type="date" name="date" value="{{ request('date') }}"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Filter
            </button>
            <a href="{{ route('screening.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-200">
                Reset
            </a>
        </form>
    </div>

    <!-- Screenings Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal/Waktu</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pasien</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Perawat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Vital Signs</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Keluhan</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($screenings as $screening)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $screening->created_at->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $screening->patient->name }}</div>
                            <div class="text-xs text-gray-500">{{ $screening->patient->medical_record_number }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $screening->nurse->name }}
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            <div>Suhu: {{ $screening->temperature }}°C</div>
                            <div>TD: {{ $screening->blood_pressure ?? '-' }}</div>
                            <div>BB: {{ $screening->weight }}kg / TB: {{ $screening->height }}cm</div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500">
                            {{ Str::limit($screening->complaints, 50) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('screening.show', $screening) }}" class="text-indigo-600 hover:text-indigo-900">Detail</a>
                            @if(auth()->id() === $screening->nurse_id)
                            <a href="{{ route('screening.edit', $screening) }}" class="text-green-600 hover:text-green-900">Edit</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada data screening
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($screenings->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $screenings->links() }}
        </div>
        @endif
    </div>
</div>
@endsection
