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
            ],
            [
                'name' => 'admin',
                'email' => 'admin@email.com',
                'password' => 'admin1234',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
