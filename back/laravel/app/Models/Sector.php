<?php

namespace App\Models;

use App\Models\Planta;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $fillable = ['sector', 'planta_id'];

    public function alertas()
    {
        return $this->hasMany(Alerta::class);
    }

    public function planta()
    {
        return $this->belongsTo(Planta::class);
    }
}