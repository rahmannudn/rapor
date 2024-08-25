<?php

namespace Database\Seeders;

use App\Models\Ekskul;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class EkskulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dataEkskul = [
            ['nama_ekskul' => 'rebana'],
            ['nama_ekskul' => 'silat'],
            ['nama_ekskul' => 'menari'],
            ['nama_ekskul' => 'pramuka'],
            ['nama_ekskul' => 'futsal'],
        ];
        foreach ($dataEkskul as $ekskul) {
            Ekskul::create($ekskul);
        }
    }
}
