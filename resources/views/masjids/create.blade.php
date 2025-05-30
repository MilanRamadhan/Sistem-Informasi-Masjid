@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Tambah Profil Masjid Baru</h1>

    <form action="{{ route('masjids.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Nama Masjid:</label>
            <input type="text" name="name" id="name"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                value="{{ old('name') }}" required>
            @error('name')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="address" class="block text-gray-700 text-sm font-bold mb-2">Alamat:</label>
            <textarea name="address" id="address" rows="3"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('address') border-red-500 @enderror"
                required>{{ old('address') }}</textarea>
            @error('address')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="capacity" class="block text-gray-700 text-sm font-bold mb-2">Kapasitas Jamaah:</label>
            <input type="number" name="capacity" id="capacity"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('capacity') border-red-500 @enderror"
                value="{{ old('capacity') }}">
            @error('capacity')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="imam" class="block text-gray-700 text-sm font-bold mb-2">Nama Imam:</label>
            <input type="text" name="imam" id="imam"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('imam') border-red-500 @enderror"
                value="{{ old('imam') }}">
            @error('imam')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>
        <div class="mb-4">
            <label for="khatib" class="block text-gray-700 text-sm font-bold mb-2">Nama Khatib (Jum'at):</label>
            <input type="text" name="khatib" id="khatib"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('khatib') border-red-500 @enderror"
                value="{{ old('khatib') }}">
            @error('khatib')
            <p class="text-red-500 text-xs italic">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit"
                class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Simpan
                Masjid</button>
            <a href="{{ route('masjids.index') }}"
                class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800">Batal</a>
        </div>
    </form>
</div>
@endsection