@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Detail Profil Masjid: {{ $masjid->name }}</h1>

    <div class="mb-4">
        <p class="text-gray-700"><strong class="font-semibold">Nama Masjid:</strong> {{ $masjid->name }}</p>
    </div>
    <div class="mb-4">
        <p class="text-gray-700"><strong class="font-semibold">Alamat:</strong> {{ $masjid->address }}</p>
    </div>
    <div class="mb-4">
        <p class="text-gray-700"><strong class="font-semibold">Kapasitas Jamaah:</strong> {{ $masjid->capacity }}</p>
    </div>
    <div class="mb-4">
        <p class="text-gray-700"><strong class="font-semibold">Imam:</strong> {{ $masjid->imam ?? '-' }}</p>
    </div>
    <div class="mb-4">
        <p class="text-gray-700"><strong class="font-semibold">Khatib (Jum'at):</strong> {{ $masjid->khatib ?? '-' }}
        </p>
    </div>

    <div class="mt-6 flex space-x-2">
        @auth {{-- Pastikan user sudah login dulu --}}
        @if (Auth::user()->role === 'admin') {{-- Hanya tampilkan jika admin --}}
        <a href="{{ route('masjids.edit', $masjid->id) }}"
            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-2 px-4 rounded">Edit</a>
        @endif
        @endauth
        <a href="{{ route('masjids.index') }}"
            class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">Kembali</a>
    </div>
</div>
@endsection