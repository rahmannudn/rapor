<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Sekolah;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(UserSeeder::class);

        Sekolah::create([
            'npsn' => '30304125',
            'nama_sekolah' => 'SD Negeri Kuin Utara 7',
            'alamat_sekolah' => 'JL Kuin Utara Gg Al-Mizan',
            'kode_pos' => '70127',
            'kelurahan' => 'Kuin Utara',
            'kecamatan' => 'Banjarmasin Utara',
            'kota' => 'Banjarmasin',
            'provinsi' => 'Kalimantan Selatan',
            'email' => 'sdkuinutara7@gmail.com',
            'nss' => '12325',
        ]);
    }
}
