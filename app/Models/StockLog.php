<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'medicine_id',
        'type',
        'quantity',
        'description',
        'created_at',
    ];

    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }
}