<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CheckItem extends Model
{
    protected $fillable = [
        'category', 'item_number', 'item_name',
        'standard', 'is_active', 'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}