@extends('layouts.app')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md mb-8">
    {{-- Form untuk memilih lokasi --}}
    <form action="{{ route('masjids.index') }}" method="GET" class="mb-6 flex items-center justify-between">
        <div>
            <label for="city_select" class="block text-gray-700 text-sm font-bold mb-2">Pilih Lokasi Jadwal
                Ibadah:</label>
            <select name="city" id="city_select"
                class="shadow appearance-none border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline w-auto">
                @foreach ($cities as $key => $city)
                <option value="{{ $key }}" {{ $selectedCityKey == $key ? 'selected' : '' }}>
                    {{ $city['name'] }}
                </option>
                @endforeach
            </select>
            <button type="submit"
                class="ml-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Tampilkan
                Jadwal</button>
        </div>
    </form>

    <h1 class="text-2xl font-bold mb-4">Jadwal Ibadah Hari Ini ({{ $locationName }})</h1>
    @if ($prayerTimes)
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 text-center">
        <div class="p-3 bg-blue-500 text-white rounded-lg">
            <h3 class="font-semibold text-lg">Subuh</h3>
            <p class="text-xl">{{ $prayerTimes['Fajr'] ?? '-' }}</p>
        </div>
        <div class="p-3 bg-blue-500 text-white rounded-lg">
            <h3 class="font-semibold text-lg">Dzuhur</h3>
            <p class="text-xl">{{ $prayerTimes['Dhuhr'] ?? '-' }}</p>
        </div>
        <div class="p-3 bg-blue-500 text-white rounded-lg">
            <h3 class="font-semibold text-lg">Ashar</h3>
            <p class="text-xl">{{ $prayerTimes['Asr'] ?? '-' }}</p>
        </div>
        <div class="p-3 bg-blue-500 text-white rounded-lg">
            <h3 class="font-semibold text-lg">Maghrib</h3>
            <p class="text-xl">{{ $prayerTimes['Maghrib'] ?? '-' }}</p>
        </div>
        <div class="p-3 bg-blue-500 text-white rounded-lg">
            <h3 class="font-semibold text-lg">Isya</h3>
            <p class="text-xl">{{ $prayerTimes['Isha'] ?? '-' }}</p>
        </div>
        <div class="p-3 bg-green-600 text-white rounded-lg">
            <h3 class="font-semibold text-lg">Syuruq</h3>
            <p class="text-xl">{{ $prayerTimes['Sunrise'] ?? '-' }}</p>
        </div>
    </div>
    <p class="text-gray-600 text-sm mt-4">Jadwal ini diambil dari API berdasarkan lokasi {{ $locationName }}. Waktu
        Imsak: {{ $prayerTimes['Imsak'] ?? '-' }}</p>
    @else
    <p class="text-red-500">Gagal memuat jadwal ibadah. Pastikan koneksi internet aktif.</p>
    @endif
</div>

<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6">Daftar Profil Masjid</h1>

    {{-- Tampilkan tombol "Tambah Masjid Baru" hanya jika user adalah admin --}}
    @auth
    @if (Auth::user()->role === 'admin')
    <a href="{{ route('masjids.create_form') }}"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mb-4 inline-block">Tambah Masjid
        Baru</a>
    @endif
    @endauth

    @if ($masjids->isEmpty())
    <p class="mt-4 text-gray-600">Belum ada data masjid.</p>
    @else
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 mt-4">
            <thead>
                <tr class="bg-gray-100 border-b">
                    <th class="py-2 px-4 text-left text-gray-600">Nama Masjid</th>
                    <th class="py-2 px-4 text-left text-gray-600">Alamat</th>
                    <th class="py-2 px-4 text-left text-gray-600">Kapasitas</th>
                    <th class="py-2 px-4 text-left text-gray-600">Imam</th>
                    <th class="py-2 px-4 text-left text-gray-600">Khatib</th>
                    {{-- Kolom Aksi hanya jika user adalah admin --}}
                    @auth
                    @if (Auth::user()->role === 'admin')
                    <th class="py-2 px-4 text-left text-gray-600">Aksi</th>
                    @endif
                    @endauth
                </tr>
            </thead>
            <tbody>
                @foreach ($masjids as $masjid)
                <tr class="border-b">
                    <td class="py-2 px-4">{{ $masjid->name }}</td>
                    <td class="py-2 px-4">{{ $masjid->address }}</td>
                    <td class="py-2 px-4">{{ $masjid->capacity }}</td>
                    <td class="py-2 px-4">{{ $masjid->imam }}</td>
                    <td class="py-2 px-4">{{ $masjid->khatib }}</td>
                    {{-- Tombol Aksi hanya jika user adalah admin --}}
                    @auth
                    @if (Auth::user()->role === 'admin')
                    <td class="py-2 px-4 flex space-x-2">
                        <a href="{{ route('masjids.show', $masjid->id) }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">Lihat</a>
                        <a href="{{ route('masjids.edit', $masjid->id) }}"
                            class="bg-yellow-500 hover:bg-yellow-700 text-white font-bold py-1 px-3 rounded text-sm">Edit</a>
                        <form action="{{ route('masjids.destroy', $masjid->id) }}" method="POST"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus masjid ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-3 rounded text-sm">Hapus</button>
                        </form>
                    </td>
                    @else {{-- Jika bukan admin, hanya tampilkan tombol Lihat --}}
                    <td class="py-2 px-4 flex space-x-2">
                        <a href="{{ route('masjids.show', $masjid->id) }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">Lihat</a>
                    </td>
                    @endif
                    @else {{-- Jika belum login, hanya tampilkan tombol Lihat --}}
                    <td class="py-2 px-4 flex space-x-2">
                        <a href="{{ route('masjids.show', $masjid->id) }}"
                            class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-3 rounded text-sm">Lihat</a>
                    </td>
                    @endauth
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
@endsection