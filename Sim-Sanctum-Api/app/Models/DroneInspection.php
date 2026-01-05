<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;

class DroneInspection extends Pivot
{
    use HasFactory;
    protected $table = 'drone_inspections';
    protected $fillable = [
        'drone_id',
        'inspection_id',
    ];
    //
}
