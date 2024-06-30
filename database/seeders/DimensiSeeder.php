<?php

namespace Database\Seeders;

use App\Models\Dimensi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DimensiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dimensiData = [
            ['deskripsi' => 'Beriman, Bertakwa Kepada Tuhan Yang Maha Esa, dan Berakhlak Mulia'],
            ['deskripsi' => 'Berkebhinekaan Global'],
            ['deskripsi' => 'Bergotong-Royong'],
            ['deskripsi' => 'Mandiri'],
            ['deskripsi' => 'Bernalar Kritis'],
            ['deskripsi' => 'Kreatif'],
        ];

        foreach ($dimensiData as $dimensi) {
            Dimensi::create(
                $dimensi
            );
        }
    }
}
