<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Tipo_Jornada extends Model
{
    use HasFactory;
    protected $table = 'tipo_jornada';
    protected $guarded = ['id'];
    protected $fillable = ['tipo', 'horas_semanales', 'estado'];
}
