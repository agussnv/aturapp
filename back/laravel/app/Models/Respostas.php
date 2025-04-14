<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Respostas extends Model {
    use HasFactory;

    protected $fillable = [
        'id_pregunta',
        'resposta1',
        'resposta2',
        'resposta3',
        'id_alumno_emisor',
        'id_curs_alumno_emisor',
    ];

    public function pregunta() {
        return $this->belongsTo(Pregunta::class, 'id_pregunta');
    }

    public function userResposta1() {
        return $this->belongsTo(User::class, 'resposta1');
    }

    public function userResposta2() {
        return $this->belongsTo(User::class, 'resposta2');
    }

    public function userResposta3() {
        return $this->belongsTo(User::class, 'resposta3');
    }

    public function alumnoEmisor() {
        return $this->belongsTo(User::class, 'id_alumno_emisor');
    }

    public function curso() {
        return $this->belongsTo(Curs::class, 'id_curs_alumno_emisor');
    }
}