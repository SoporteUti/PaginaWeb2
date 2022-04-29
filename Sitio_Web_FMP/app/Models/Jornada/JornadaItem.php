<?php

namespace App\Models\Jornada;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JornadaItem extends Model
{
    use HasFactory;
    protected $table = 'jornada_items';

    protected $guarded = ['id'];
    protected $fillable = ['dia', 'hora_inicio', 'hora_fin', 'id_jornada', 'estado'];
}
