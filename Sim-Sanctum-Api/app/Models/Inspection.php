<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    /** @use HasFactory<\Database\Factories\InspectionFactory> */
    use HasFactory;

    protected $fillable = [
        'site_id',
        'inspection_date',
        'inspector_id',
        'status'
    ];

    public function site()
    {
        return $this->belongsTo(Site::class);
    }

    public function drones()
    {
        return $this->belongsToMany(Drone::class, 'drone_inspections', 'drone_id','inspection_id')
            ->using(DroneInspection::class);
    }

    public function inspector()
    {
        return $this->belongsTo(User::class, 'inspector_id');
    }
}
