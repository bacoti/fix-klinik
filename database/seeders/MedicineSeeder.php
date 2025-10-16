<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MedicineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $medicines = [
            [
                'name' => 'Paracetamol 500mg',
                'type' => 'tablet',
                'unit' => 'strip',
                'description' => 'Pain reliever and fever reducer',
                'stock' => 100,
                'price' => 5000
            ],
            [
                'name' => 'Amoxicillin 500mg',
                'type' => 'capsule',
                'unit' => 'strip',
                'description' => 'Antibiotic for bacterial infections',
                'stock' => 50,
                'price' => 15000
            ],
            [
                'name' => 'Ibuprofen 400mg',
                'type' => 'tablet',
                'unit' => 'strip',
                'description' => 'Anti-inflammatory and pain reliever',
                'stock' => 75,
                'price' => 8000
            ],
            [
                'name' => 'Vitamin C 1000mg',
                'type' => 'tablet',
                'unit' => 'botol',
                'description' => 'Immune system support',
                'stock' => 200,
                'price' => 25000
            ],
            [
                'name' => 'OBH Combi',
                'type' => 'syrup',
                'unit' => 'botol',
                'description' => 'For cough relief',
                'stock' => 30,
                'price' => 18000
            ],
            [
                'name' => 'Betadine Solution',
                'type' => 'injection',
                'unit' => 'botol',
                'description' => 'Antiseptic solution',
                'stock' => 8,
                'price' => 12000
            ],
            [
                'name' => 'Salep 88',
                'type' => 'ointment',
                'unit' => 'tube',
                'description' => 'Ointment for skin irritation',
                'stock' => 45,
                'price' => 6500
            ],
            [
                'name' => 'Bioplacenton',
                'type' => 'cream',
                'unit' => 'tube',
                'description' => 'Cream for wound healing',
                'stock' => 5,
                'price' => 22000
            ],
        ];

        foreach ($medicines as $medicine) {
            \App\Models\Medicine::create($medicine);
        }
    }
}
