<?php

namespace App\Http\Controllers;

use App\Models\Masjid;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class MasjidController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    // Data ini akan kita gunakan dalam MasjidController
private $cities = [
    'banda_aceh' => [
        'name' => 'Banda Aceh',
        'latitude' => 5.5583,
        'longitude' => 95.3197,
        'timezone' => 'Asia/Jakarta'
    ],
    'medan' => [
        'name' => 'Medan',
        'latitude' => 3.5952,
        'longitude' => 98.6775,
        'timezone' => 'Asia/Jakarta'
    ],
    'pekanbaru' => [
        'name' => 'Pekanbaru',
        'latitude' => 0.5097,
        'longitude' => 101.4475,
        'timezone' => 'Asia/Jakarta'
    ],
    'tanjung_pinang' => [
        'name' => 'Tanjung Pinang',
        'latitude' => 0.9234,
        'longitude' => 104.4533,
        'timezone' => 'Asia/Jakarta'
    ],
    'jambi' => [
        'name' => 'Jambi',
        'latitude' => -1.5902,
        'longitude' => 103.6105,
        'timezone' => 'Asia/Jakarta'
    ],
    'palembang' => [
        'name' => 'Palembang',
        'latitude' => -2.9761,
        'longitude' => 104.7754,
        'timezone' => 'Asia/Jakarta'
    ],
    'bengkulu' => [
        'name' => 'Bengkulu',
        'latitude' => -3.7924,
        'longitude' => 102.2612,
        'timezone' => 'Asia/Jakarta'
    ],
    'bandar_lampung' => [
        'name' => 'Bandar Lampung',
        'latitude' => -5.4500,
        'longitude' => 105.2667,
        'timezone' => 'Asia/Jakarta'
    ],
    'pangkal_pinang' => [
        'name' => 'Pangkal Pinang',
        'latitude' => -2.1333,
        'longitude' => 106.1333,
        'timezone' => 'Asia/Jakarta'
    ],
    'padang' => [
        'name' => 'Padang',
        'latitude' => -0.9405,
        'longitude' => 100.3541,
        'timezone' => 'Asia/Jakarta'
    ],
];

    public function index(Request $request)
    {
        $masjids = Masjid::all(); // Mengambil semua data masjid

        $prayerTimes = null;
        $selectedCityKey = $request->input('city', 'banda_aceh'); // Nama lokasi default

        if (!array_key_exists($selectedCityKey, $this->cities)) {
            $selectedCityKey = 'banda_aceh';
        }

        $currentCity = $this->cities[$selectedCityKey];
        $locationName = $currentCity['name'];
        $latitude = $currentCity['latitude'];
        $longitude = $currentCity['longitude'];
        $timezone = $currentCity['timezone'];

        try {
            $today = Carbon::now();
            $year = $today->year;
            $month = $today->month;
            $day = $today->day;

            // Mengambil jadwal sholat dari API Aladhan
            $response = Http::get("http://api.aladhan.com/v1/timings/{$day}-{$month}-{$year}", [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'method' => 2, // Islamic Society of North America (ISNA)
                'school' => 0, // Shafii, Maliki, Hanbali
                'timezone' => $timezone,
            ]);

            $data = $response->json();

            if ($data && $data['code'] == 200 && $data['status'] == 'OK') {
                $prayerTimes = $data['data']['timings'];
                // Membersihkan data waktu sholat (menghilangkan bagian dalam kurung seperti (WIB))
                foreach ($prayerTimes as $key => $value) {
                    $prayerTimes[$key] = preg_replace('/\s*\(.*\)\s*/', '', $value);
                }
            } else {
                \Log::error('Gagal mengambil jadwal sholat dari API untuk ' . $locationName . ': ' . ($data['data'] ?? 'Unknown Error'));
                session()->flash('error', 'Gagal mengambil jadwal sholat untuk ' . $locationName . '. Pastikan koneksi internet aktif.');
            }
        } catch (\Exception $e) {
            \Log::error('Error saat mengambil jadwal sholat untuk ' . $locationName . ': ' . $e->getMessage());
            session()->flash('error', 'Terjadi kesalahan saat mengambil jadwal sholat untuk ' . $locationName . ': ' . $e->getMessage());
        }

        // Mengirim semua data yang diperlukan ke view
    return view('masjids.index', compact('masjids', 'prayerTimes', 'locationName', 'selectedCityKey'))->with('cities', $this->cities);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('masjids.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required',
            'capacity' => 'nullable|integer',
            'imam' => 'nullable|string|max:255',
            'khatib' => 'nullable|string|max:255',
        ]);

        Masjid::create($validatedData); // Langsung create dengan data yang divalidasi

        return redirect()->route('masjids.index')->with('success', 'Profil masjid berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Masjid $masjid)
    {
        return view('masjids.show', compact('masjid'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Masjid $masjid)
    {
        return view('masjids.edit', compact('masjid')); // Menampilkan form edit masjid
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Masjid $masjid)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'address' => 'required',
            'capacity' => 'nullable|integer',
            'imam' => 'nullable|string|max:255',
            'khatib' => 'nullable|string|max:255',
        ]);

        $masjid->update($validatedData);

        return redirect()->route('masjids.index')->with('success', 'Profil masjid berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Masjid $masjid)
    {
        $masjid->delete();
        return redirect()->route('masjids.index')->with('success', 'Profil masjid berhasil dihapus!');
    }
}