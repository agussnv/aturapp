<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Torn extends Model
{
    protected $fillable = ['torn'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
}
