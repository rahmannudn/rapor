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
                'name' => 'aman',
                'email' => 'aman@email.com',
                'password' => 'aman1234',
                'role' => 'superadmin',
                'jk' => 'l',
                'jenis_pegawai' => 'honor'
            ],
            [
                'name' => 'admin',
                'email' => 'admin@email.com',
                'password' => 'admin1234',
                'role' => 'admin',
                'jk' => 'p',
                'jenis_pegawai' => 'pppk'
            ],
            [
                'name' => 'guru',
                'email' => 'guru@email.com',
                'password' => 'guru1234',
                'role' => 'guru',
                'jk' => 'p',
                'jenis_pegawai' => 'pns'
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
