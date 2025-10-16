<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'examination_id',
        'medicine_id',
        'quantity',
        'instructions',
        'dispensed_at',
        'dispensed_by',
    ];

    protected $casts = [
        'dispensed_at' => 'datetime',
    ];

    public function examination()
    {
        return $this->belongsTo(Examination::class);
    }

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    public function dispensedBy()
    {
        return $this->belongsTo(User::class, 'dispensed_by');
    }
}
