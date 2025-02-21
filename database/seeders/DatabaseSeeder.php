<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            SekolahSeeder::class,
            KepsekSeeder::class,
            TahunAjaranSeeder::class,
            KelasSeeder::class,
            MapelSeeder::class,
            SiswaSeeder::class,
            GuruMapelSeeder::class,
            WaliKelasSeeder::class,
            DimensiSeeder::class,
            EkskulSeeder::class,
            ElemenSeeder::class,
            SubelemenSeeder::class,
            CapaianFaseSeeder::class,
            ProyekSeeder::class,
            // SubproyekSeeder::class,
        ]);
    }
}
