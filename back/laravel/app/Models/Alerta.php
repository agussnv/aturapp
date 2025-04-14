<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alerta extends Model
{
    protected $fillable = [
        'alumno_id',
        'sector_id',
        'descripcion',
        'estado_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'alumno_id', 'id');
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function estado()
    {
        return $this->belongsTo(Estado::class, 'estado_id', 'id');
    }
}