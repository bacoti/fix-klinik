<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screening extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'nurse_id',
        'temperature',
        'blood_pressure_systolic',
        'blood_pressure_diastolic',
        'heart_rate',
        'respiratory_rate',
        'oxygen_saturation',
        'weight',
        'height',
        'complaints',
        'notes',
    ];

    protected $casts = [
        'temperature' => 'decimal:1',
        'weight' => 'decimal:2',
        'height' => 'decimal:2',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function nurse()
    {
        return $this->belongsTo(User::class, 'nurse_id');
    }

    /**
     * Get BMI calculation
     */
    public function getBmiAttribute()
    {
        if ($this->weight && $this->height) {
            $heightInMeters = $this->height / 100;
            return round($this->weight / ($heightInMeters * $heightInMeters), 2);
        }
        return null;
    }

    /**
     * Get BMI category
     */
    public function getBmiCategoryAttribute()
    {
        $bmi = $this->bmi;
        if (!$bmi) return null;

        if ($bmi < 18.5) return 'Underweight';
        if ($bmi < 25) return 'Normal';
        if ($bmi < 30) return 'Overweight';
        return 'Obese';
    }

    /**
     * Get blood pressure reading
     */
    public function getBloodPressureAttribute()
    {
        if ($this->blood_pressure_systolic && $this->blood_pressure_diastolic) {
            return $this->blood_pressure_systolic . '/' . $this->blood_pressure_diastolic;
        }
        return null;
    }
}
