<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CheckSheet extends Model
{
    use HasFactory;

    protected $fillable = [
        'driver_name', 
        'vehicle_number', 
        'check_date', 
        'check_time', 
        'status', 
        'notes'
    ];

    public function items()
    {
        return $this->hasMany(CheckSheetItem::class);
    }
}
