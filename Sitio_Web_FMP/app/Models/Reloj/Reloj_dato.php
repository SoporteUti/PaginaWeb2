<?php

namespace App\Models\Reloj;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reloj_dato extends Model
{
    use HasFactory;
   /* protected $fillable = [
        'indice',
        'id_persona',
        'nombre_personal',
        'departamento',
        'posicion',
        'genero',
        'fecha',
        'dia_semana',
        'horario',
        'entrada',
        'salida'
    ];*/
   protected $table = 'reloj_datos';
    
    protected $guarded = ['id'];
}
