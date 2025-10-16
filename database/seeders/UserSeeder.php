<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Nurse One', 'email' => 'nurse@clinic.com', 'role' => 'nurse'],
            ['name' => 'Doctor One', 'email' => 'doctor@clinic.com', 'role' => 'doctor'],
            ['name' => 'Pharmacist One', 'email' => 'pharmacist@clinic.com', 'role' => 'pharmacist'],
        ];

        foreach ($users as $user) {
            \App\Models\User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt('password'),
                'role' => $user['role'],
            ]);
        }
    }
}
