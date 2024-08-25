<?php

namespace Database\Seeders;

use App\Models\Kepsek;
use App\Models\TahunAjaran;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KepsekSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataKepsek = [
            [
                'awal_menjabat' => null,
                'akhir_menjabat' => null,
                'user_id' => 4,
                'aktif' => 1,
            ],
        ];

        foreach ($dataKepsek as $kepsek) {
            Kepsek::create($kepsek);
        }
    }
}
