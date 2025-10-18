<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'address',
        'date_of_birth',
        'gender',
        'verified',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'date_of_birth' => 'date',
    ];

    public function screenings()
    {
        return $this->hasMany(Screening::class);
    }

    /**
     * Latest screening relation (for eager loading)
     */
    public function latestScreening()
    {
        // Use latestOfMany if available (Laravel 8.42+), fallback to hasOne ordered
        if (method_exists($this->hasOne(Screening::class), 'latestOfMany')) {
            return $this->hasOne(Screening::class)->latestOfMany();
        }

        return $this->hasOne(Screening::class)->latest();
    }

    public function examinations()
    {
        return $this->hasMany(Examination::class);
    }

    public function medicalRecords()
    {
        return $this->hasMany(MedicalRecord::class);
    }

    /**
     * Get the patient's age
     */
    public function getAgeAttribute()
    {
        return $this->date_of_birth ? $this->date_of_birth->age : null;
    }

    /**
     * Get the patient's medical record number
     */
    public function getMedicalRecordNumberAttribute()
    {
        return 'MR' . str_pad($this->id, 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get the patient's registration number (alias for medical record number)
     */
    public function getRegistrationNumberAttribute()
    {
        return $this->medical_record_number;
    }

    /**
     * Check if patient has screening today
     */
    public function getHasScreeningTodayAttribute()
    {
        return $this->screenings()
            ->whereDate('created_at', today())
            ->exists();
    }

    /**
     * Check if patient has examination today
     */
    public function getHasExaminationTodayAttribute()
    {
        return $this->examinations()
            ->whereDate('created_at', today())
            ->exists();
    }

    /**
     * Get latest screening
     */
    public function getLatestScreeningAttribute()
    {
        return $this->screenings()->latest()->first();
    }
}
