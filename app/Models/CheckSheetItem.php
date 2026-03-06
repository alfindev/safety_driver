<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CheckSheetItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'check_sheet_id',
        'category',
        'item_name',
        'is_checked',
        'description'
    ];

    public function checkSheet()
    {
        return $this->belongsTo(CheckSheet::class);
    }
}