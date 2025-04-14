<?php

namespace App\Models;

use App\Models\Sector;
use Illuminate\Database\Eloquent\Model;

class Planta extends Model
{
    protected $fillable = [
        'name'
    ];

    public function sectores()
    {
        return $this->hasMany(Sector::class);
    }
}
