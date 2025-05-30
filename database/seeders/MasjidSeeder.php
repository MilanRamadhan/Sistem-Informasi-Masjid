<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Masjid;

class MasjidSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Masjid::create([
            'name' => 'Masjid Raya Baiturrahman',
            'address' => 'Jl. Moh. Jam No.1, Kp. Baru, Kec. Baiturrahman, Kota Banda Aceh, Aceh',
            'capacity' => 10000,
            'imam' => 'Tgk. H. Azman Ismail',
            'khatib' => 'Prof. Dr. H. Azhar'
        ]);

        Masjid::create([
            'name' => 'Masjid Agung Al-Falah',
            'address' => 'Jl. Jenderal Sudirman No.1, Gn. Meriah, Kec. Kuta Raja, Kota Langsa, Aceh',
            'capacity' => 5000,
            'imam' => 'Ustadz Fulan',
            'khatib' => 'Ustadz Jufri'
        ]);
    }
}