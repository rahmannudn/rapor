<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'email' => 'admin@email.com',
                'password' => 'admin1234',
                'role' => 'admin',
                'jk' => 'p',
                'jenis_pegawai' => 'pppk'
            ],
            [
                'name' => 'jajang sunarman',
                'email' => 'jajang@email.com',
                'password' => 'jajang1234',
                'role' => 'guru',
                'jk' => 'p',
                'jenis_pegawai' => 'pns'
            ],
            [
                'name' => 'rojak',
                'email' => 'rojak2@email.com',
                'password' => 'rojak1234',
                'role' => 'guru',
                'jk' => 'l',
                'jenis_pegawai' => 'honor'
            ],
            [
                'name' => 'kemal abunawas',
                'email' => 'kemal@email.com',
                'password' => 'kemal1234',
                'role' => 'kepsek',
                'jk' => 'l',
                'jenis_pegawai' => 'pns'
            ],
            [
                'name' => 'winston',
                'email' => 'winston@email.com',
                'password' => 'winston1234',
                'role' => 'kepsek',
                'jk' => 'p',
                'jenis_pegawai' => 'pns'
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
