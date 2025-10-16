<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Examination extends Model
{
    use HasFactory;

    protected $fillable = [
        'patient_id',
        'doctor_id',
        'anamnesis',
        'physical_examination',
        'diagnosis',
        'prescription_text',
        'additional_notes',
        'sick_letter',
        'sick_days',
        'follow_up_date',
    ];

    protected $casts = [
        'sick_letter' => 'boolean',
        'follow_up_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function prescriptions()
    {
        return $this->hasMany(Prescription::class);
    }
}
