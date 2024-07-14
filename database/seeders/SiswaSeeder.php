<?php

namespace Database\Seeders;

use App\Models\Siswa;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Enum values for 'agama'
        $agamaList = [
            'islam',
            'kristen protestan',
            'kristen katolik',
            'hindu',
            'buddha',
            'konghucu',
        ];

        for ($i = 0; $i < 100; $i++) {
            $siswa =   Siswa::create([
                'nisn' => $faker->unique()->numerify('##########'),
                'nidn' => $faker->unique()->numerify('##########'),
                'nama' => $faker->name,
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date,
                'jk' => $faker->randomElement(['l', 'p']),
                'agama' => $faker->randomElement($agamaList),
                'alamat' => $faker->address,
                'kelurahan' => $faker->citySuffix,
                'kecamatan' => $faker->citySuffix,
                'kota' => $faker->city,
                'provinsi' => $faker->state,
                'nama_ayah' => $faker->name('male'),
                'nama_ibu' => $faker->name('female'),
                'hp_ortu' => $faker->numerify('08##########'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert into kelas_siswa table
            DB::table('kelas_siswa')->insert([
                'siswa_id' => $siswa->id,
                'kelas_id' => $faker->numberBetween(1, 4),
                'tahun_ajaran_id' => '2',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
