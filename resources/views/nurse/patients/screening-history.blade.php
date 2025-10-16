@extends('layouts.app')

@section('title', 'Riwayat Screening - ' . $patient->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Riwayat Screening</h2>
            <p class="mt-1 text-sm text-gray-600">{{ $patient->name }} ({{ $patient->medical_record_number }})</p>
        </div>
        <a href="{{ route('nurse.patients') }}" class="text-gray-600 hover:text-gray-900">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
        </a>
    </div>

    <!-- Patient Info -->
    <div class="bg-white shadow rounded-lg p-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <p class="text-sm font-medium text-gray-500">Nama Lengkap</p>
                <p class="mt-1 text-sm text-gray-900">{{ $patient->name }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Jenis Kelamin</p>
                <p class="mt-1 text-sm text-gray-900">{{ $patient->gender === 'male' ? 'Laki-laki' : 'Perempuan' }}</p>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500">Umur</p>
                <p class="mt-1 text-sm text-gray-900">{{ $patient->age }} tahun</p>
            </div>
        </div>
    </div>

    <!-- Screening History -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Riwayat Screening ({{ $screenings->total() }})</h3>
            <div class="space-y-4">
                @forelse($screenings as $screening)
                <div class="border rounded-lg p-4 hover:bg-gray-50 transition">
                    <div class="flex justify-between items-start mb-3">
                        <div>
                            <p class="text-sm font-medium text-gray-900">
                                {{ $screening->created_at->format('d F Y, H:i') }}
                            </p>
                            <p class="text-xs text-gray-500">
                                Oleh: {{ $screening->nurse->name }}
                            </p>
                        </div>
                        <a href="{{ route('screening.show', $screening) }}" 
                           class="text-indigo-600 hover:text-indigo-900 text-sm font-medium">
                            Detail →
                        </a>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mt-3">
                        <div>
                            <p class="text-xs text-gray-500">Suhu</p>
                            <p class="text-sm font-medium text-gray-900">{{ $screening->temperature }}°C</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Tekanan Darah</p>
                            <p class="text-sm font-medium text-gray-900">{{ $screening->blood_pressure ?? '-' }}</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Berat Badan</p>
                            <p class="text-sm font-medium text-gray-900">{{ $screening->weight }} kg</p>
                        </div>
                        <div>
                            <p class="text-xs text-gray-500">Tinggi Badan</p>
                            <p class="text-sm font-medium text-gray-900">{{ $screening->height }} cm</p>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <p class="text-xs text-gray-500">Keluhan</p>
                        <p class="text-sm text-gray-900">{{ $screening->complaints }}</p>
                    </div>

                    @if($screening->notes)
                    <div class="mt-2">
                        <p class="text-xs text-gray-500">Catatan</p>
                        <p class="text-sm text-gray-900">{{ $screening->notes }}</p>
                    </div>
                    @endif
                </div>
                @empty
                <div class="text-center py-8 text-gray-500">
                    Belum ada riwayat screening
                </div>
                @endforelse
            </div>
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
