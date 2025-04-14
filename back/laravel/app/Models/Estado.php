<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{
    protected $fillable = ['name'];

    public function alertas()
    {
        return $this->hasMany(Alerta::class);
    }
}
