<x-app-layout>
    {{-- Mengatur judul halaman menggunakan named slot --}}
    <x-slot:title>
        Tambah Obat
    </x-slot:title>

    {{-- Konten utama halaman dimasukkan langsung ke dalam slot default --}}
    <x-form-layout title="Tambah Obat Baru" :backRoute="route('pharmacy.index')">
        
        <form method="POST" action="{{ route('medicines.store') }}" class="space-y-6">
            @csrf

            {{-- Name --}}
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Nama Obat *</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('name') border-red-500 @enderror">
                @error('name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Type --}}
            <div>
                <label for="type" class="block text-sm font-medium text-gray-700">Tipe Obat *</label>
                <select name="type" id="type" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('type') border-red-500 @enderror">
                    <option value="">Pilih Tipe</option>
                    <option value="tablet" {{ old('type') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="capsule" {{ old('type') == 'capsule' ? 'selected' : '' }}>Kapsul</option>
                    <option value="syrup" {{ old('type') == 'syrup' ? 'selected' : '' }}>Sirup</option>
                    <option value="injection" {{ old('type') == 'injection' ? 'selected' : '' }}>Injeksi</option>
                    <option value="cream" {{ old('type') == 'cream' ? 'selected' : '' }}>Krim</option>
                    <option value="ointment" {{ old('type') == 'ointment' ? 'selected' : '' }}>Salep</option>
                </select>
                @error('type')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Unit --}}
            <div>
                <label for="unit" class="block text-sm font-medium text-gray-700">Satuan *</label>
                <input type="text" name="unit" id="unit" value="{{ old('unit') }}" required
                    placeholder="Contoh: strip, botol, tube"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('unit') border-red-500 @enderror">
                @error('unit')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Stock --}}
            <div>
                <label for="stock" class="block text-sm font-medium text-gray-700">Stok Awal *</label>
                <input type="number" name="stock" id="stock" value="{{ old('stock', 0) }}" min="0" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('stock') border-red-500 @enderror">
                @error('stock')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Price --}}
            <div>
                <label for="price" class="block text-sm font-medium text-gray-700">Harga (Rp) *</label>
                <input type="number" name="price" id="price" value="{{ old('price', 0) }}" min="0" step="100" required
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('price') border-red-500 @enderror">
                @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="description" id="description" rows="4"
                    class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                <p class="mt-1 text-sm text-gray-500">Keterangan tambahan tentang obat (opsional)</p>
                @error('description')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Buttons --}}
            <div class="flex justify-end space-x-3">
                <a href="{{ route('pharmacy.index') }}" 
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-bold py-2 px-4 rounded-lg transition duration-200">
                    Batal
                </a>
                <button type="submit" 
                    class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg transition duration-200">
                    Simpan Obat
                </button>
            </div>
        </form>

    </x-form-layout>
</x-app-layout>