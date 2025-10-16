@extends('layouts.app')

@section('title', 'Pharmacy Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Pharmacy Management</h2>
            <p class="mt-1 text-sm text-gray-600">Kelola stok obat dan persediaan farmasi</p>
        </div>
        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pharmacist')
        <a href="{{ route('medicines.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Tambah Obat
        </a>
        @endif
    </div>

    <!-- Alert Low Stock -->
    @if($lowStockCount > 0)
    <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4">
        <div class="flex">
            <div class="flex-shrink-0">
                <svg class="h-5 w-5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
            </div>
            <div class="ml-3">
                <p class="text-sm text-yellow-700">
                    <strong class="font-bold">Peringatan!</strong> Ada {{ $lowStockCount }} obat dengan stok rendah (≤10).
                </p>
            </div>
        </div>
    </div>
    @endif

    <!-- Success/Error Message -->
    @if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('success') }}</span>
    </div>
    @endif

    @if(session('error'))
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
        <span class="block sm:inline">{{ session('error') }}</span>
    </div>
    @endif

    <!-- Filters -->
    <div class="bg-white shadow rounded-lg p-4">
        <form method="GET" action="{{ route('pharmacy.index') }}" class="flex flex-wrap gap-4">
            <div class="flex-1 min-w-[250px]">
                <input type="text" name="search" placeholder="Cari nama obat..." 
                    value="{{ request('search') }}"
                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
            </div>
            <div class="flex items-center">
                <input type="checkbox" name="low_stock" id="low_stock" value="1" 
                    {{ request('low_stock') ? 'checked' : '' }}
                    class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <label for="low_stock" class="ml-2 text-sm text-gray-700">Stok Rendah</label>
            </div>
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                Filter
            </button>
            <a href="{{ route('pharmacy.index') }}" class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-200">
                Reset
            </a>
        </form>
    </div>

    <!-- Medicines Table -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Obat</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Unit</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($medicines as $medicine)
                    <tr class="{{ $medicine->stock <= 10 ? 'bg-yellow-50' : '' }}">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $medicine->name }}</div>
                            @if($medicine->description)
                            <div class="text-xs text-gray-500">{{ Str::limit($medicine->description, 50) }}</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ ucfirst($medicine->type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $medicine->unit }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium {{ $medicine->stock <= 10 ? 'text-red-600' : 'text-gray-900' }}">
                                {{ $medicine->stock }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            Rp {{ number_format($medicine->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <!-- Update Stock Modal Button -->
                            <button onclick="openStockModal({{ $medicine->id }}, '{{ $medicine->name }}', {{ $medicine->stock }})" 
                                class="text-green-600 hover:text-green-900">
                                Stok
                            </button>
                            
                            @if(auth()->user()->role === 'admin' || auth()->user()->role === 'pharmacist')
                            <a href="{{ route('medicines.edit', $medicine) }}" class="text-indigo-600 hover:text-indigo-900">Edit</a>
                            <form method="POST" action="{{ route('medicines.destroy', $medicine) }}" class="inline" onsubmit="return confirm('Yakin ingin menghapus obat ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                            Tidak ada obat ditemukan
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($medicines->hasPages())
        <div class="bg-white px-4 py-3 border-t border-gray-200 sm:px-6">
            {{ $medicines->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Stock Update Modal -->
<div id="stockModal" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Update Stok Obat</h3>
            <p class="text-sm text-gray-600 mb-4">Obat: <span id="medicineName" class="font-semibold"></span></p>
            <p class="text-sm text-gray-600 mb-4">Stok Saat Ini: <span id="currentStock" class="font-semibold"></span></p>
            
            <form id="stockForm" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Aksi</label>
                    <select name="action" class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="set">Set Stok</option>
                        <option value="add">Tambah Stok</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jumlah</label>
                    <input type="number" name="stock" min="0" required
                        class="w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeStockModal()"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                        Update Stok
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openStockModal(medicineId, medicineName, currentStock) {
    document.getElementById('medicineName').textContent = medicineName;
    document.getElementById('currentStock').textContent = currentStock;
    document.getElementById('stockForm').action = `/medicines/${medicineId}/stock`;
    document.getElementById('stockModal').classList.remove('hidden');
}

function closeStockModal() {
    document.getElementById('stockModal').classList.add('hidden');
}

// Close modal when clicking outside
document.getElementById('stockModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeStockModal();
    }
});
</script>
@endsection
