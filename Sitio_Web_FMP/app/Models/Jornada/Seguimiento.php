<?php

namespace App\Models\Jornada;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seguimiento extends Model{
    use HasFactory;
    protected $table = 'jornada_seguimiento';

    protected $guarded = ['id'];

    protected $fillable = ['jornada_id', 'proceso', 'observaciones', 'estado'];

}
