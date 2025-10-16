<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Screening;
use Carbon\Carbon;

class PatientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first nurse user
        $nurse = \App\Models\User::where('role', 'nurse')->first();
        
        if (!$nurse) {
            $this->command->error('No nurse found in the system. Please create a nurse user first.');
            return;
        }

        $patients = [
            [
                'name' => 'Budi Santoso',
                'email' => 'budi.santoso@email.com',
                'phone' => '081234567890',
                'address' => 'Jl. Merdeka No. 10, Jakarta',
                'date_of_birth' => '1985-05-15',
                'gender' => 'male',
                'verified' => true,
            ],
            [
                'name' => 'Siti Aminah',
                'email' => 'siti.aminah@email.com',
                'phone' => '081234567891',
                'address' => 'Jl. Sudirman No. 25, Bandung',
                'date_of_birth' => '1990-08-20',
                'gender' => 'female',
                'verified' => true,
            ],
            [
                'name' => 'Ahmad Hidayat',
                'email' => 'ahmad.hidayat@email.com',
                'phone' => '081234567892',
                'address' => 'Jl. Gatot Subroto No. 5, Surabaya',
                'date_of_birth' => '1978-12-10',
                'gender' => 'male',
                'verified' => true,
            ],
            [
                'name' => 'Dewi Lestari',
                'email' => 'dewi.lestari@email.com',
                'phone' => '081234567893',
                'address' => 'Jl. Diponegoro No. 15, Yogyakarta',
                'date_of_birth' => '1995-03-25',
                'gender' => 'female',
                'verified' => true,
            ],
            [
                'name' => 'Eko Prasetyo',
                'email' => 'eko.prasetyo@email.com',
                'phone' => '081234567894',
                'address' => 'Jl. Ahmad Yani No. 30, Semarang',
                'date_of_birth' => '1982-07-18',
                'gender' => 'male',
                'verified' => true,
            ],
        ];

        foreach ($patients as $patientData) {
            $patient = Patient::create($patientData);

            // Create screening for today (waiting for examination)
            Screening::create([
                'patient_id' => $patient->id,
                'nurse_id' => $nurse->id,
                'complaints' => $this->getRandomComplaint(),
                'temperature' => rand(360, 380) / 10,
                'blood_pressure_systolic' => rand(110, 140),
                'blood_pressure_diastolic' => rand(70, 90),
                'heart_rate' => rand(60, 100),
                'respiratory_rate' => rand(12, 20),
                'oxygen_saturation' => rand(95, 100),
                'weight' => rand(45, 90),
                'height' => rand(150, 185),
                'notes' => 'Patient appears stable',
                'created_at' => Carbon::today()->addHours(rand(8, 12)),
            ]);
        }

        // Add more patients without screening today
        $morePatients = [
            [
                'name' => 'Rina Susanti',
                'email' => 'rina.susanti@email.com',
                'phone' => '081234567895',
                'address' => 'Jl. Pemuda No. 12, Malang',
                'date_of_birth' => '1988-09-05',
                'gender' => 'female',
                'verified' => true,
            ],
            [
                'name' => 'Hendra Wijaya',
                'email' => 'hendra.wijaya@email.com',
                'phone' => '081234567896',
                'address' => 'Jl. Pahlawan No. 8, Solo',
                'date_of_birth' => '1975-11-22',
                'gender' => 'male',
                'verified' => true,
            ],
        ];

        foreach ($morePatients as $patientData) {
            Patient::create($patientData);
        }
    }

    private function getRandomComplaint(): string
    {
        $complaints = [
            'Demam sejak 2 hari yang lalu, disertai batuk dan pilek',
            'Sakit kepala hebat sejak pagi, mual dan pusing',
            'Nyeri dada saat bernafas, sesak nafas ringan',
            'Batuk berdahak sudah 1 minggu, demam naik turun',
            'Sakit perut, diare sejak kemarin',
        ];

        return $complaints[array_rand($complaints)];
    }
}
