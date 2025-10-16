<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Patient;
use App\Models\Screening;
use App\Models\User;
use Carbon\Carbon;

class ScreeningTodaySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get first nurse user
        $nurse = User::where('role', 'nurse')->first();
        
        if (!$nurse) {
            $this->command->error('No nurse found in the system. Please create a nurse user first.');
            return;
        }

        // Get patients that don't have screening today
        $patients = Patient::whereDoesntHave('screenings', function($q) {
            $q->whereDate('created_at', Carbon::today());
        })
        ->take(4)
        ->get();

        if ($patients->isEmpty()) {
            $this->command->warn('All patients already have screening today or no patients found.');
            return;
        }

        $complaints = [
            'Demam sejak 2 hari yang lalu, disertai batuk dan pilek',
            'Sakit kepala hebat sejak pagi, mual dan pusing',
            'Nyeri dada saat bernafas, sesak nafas ringan',
            'Batuk berdahak sudah 1 minggu, demam naik turun',
            'Sakit perut, diare sejak kemarin',
            'Pusing berputar, telinga berdenging',
            'Nyeri ulu hati, mual setelah makan',
        ];

        foreach ($patients as $patient) {
            Screening::create([
                'patient_id' => $patient->id,
                'nurse_id' => $nurse->id,
                'complaints' => $complaints[array_rand($complaints)],
                'temperature' => rand(360, 385) / 10,
                'blood_pressure_systolic' => rand(110, 140),
                'blood_pressure_diastolic' => rand(70, 90),
                'heart_rate' => rand(60, 100),
                'respiratory_rate' => rand(12, 20),
                'oxygen_saturation' => rand(95, 100),
                'weight' => rand(45, 90),
                'height' => rand(150, 185),
                'notes' => 'Patient condition stable',
                'created_at' => Carbon::today()->addHours(rand(8, 11))->addMinutes(rand(0, 59)),
                'updated_at' => now(),
            ]);
        }

        $this->command->info("Created {$patients->count()} screenings for today.");
    }
}
