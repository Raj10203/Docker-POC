<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Site extends Model
{
    /** @use HasFactory<\Database\Factories\SiteFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'city',
        'state',
        'is_active',
        'size_in_mw',
        'size_in_acre',
        'url',
    ];

    public function inspections()
    {
        return $this->hasMany(Inspection::class);
    }
}
