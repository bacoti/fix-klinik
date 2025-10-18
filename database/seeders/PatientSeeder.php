<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // create 100 random patients
        Patient::factory()->count(100)->create();

        // create a known patient for tests/demo
        Patient::factory()->create([
            'name' => 'Test Patient',
            'email' => 'patient@example.test',
            'phone' => '081234567890',
            'address' => 'Jl. Contoh No.1, Kota Contoh',
            'date_of_birth' => '1990-01-01',
            'gender' => 'female',
            'verified' => true,
        ]);

        // some fixed example patients
        $fixed = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@example.test',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
                'date_of_birth' => '1985-05-15',
                'gender' => 'male',
                'verified' => true,
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.aminah@example.test',
                'phone' => '081234567891',
                'address' => 'Jl. Sudirman No. 25, Bandung',
                'date_of_birth' => '1990-08-20',
                'gender' => 'female',
                'verified' => true,
            ],
        ];

        foreach ($fixed as $data) {
            Patient::firstOrCreate(['email' => $data['email']], $data);
        }
    }
}
