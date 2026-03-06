<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
    'plate_number', 'type', 'brand', 'year', 'status',
    'stnk_number', 'stnk_expires_at',
    'insurance_number', 'insurance_expires_at',
];

protected $casts = [
    'stnk_expires_at'      => 'date',
    'insurance_expires_at' => 'date',
];

public function drivers(): BelongsToMany
{
    return $this->belongsToMany(User::class, 'driver_vehicle');
}

public function checkSheets(): HasMany
{
    return $this->hasMany(CheckSheet::class);
}

}
