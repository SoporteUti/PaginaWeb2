<?php

namespace App\Models\Jornada;

use App\Models\Horarios\Ciclo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model{
    use HasFactory;

    protected $table = 'periodos';

    protected $guarded = ['id'];

    protected $fillable = ['ciclo_id','fecha_inicio', 'fecha_fin', 'tipo', 'estado', 'observaciones'];

    public function ciclo_rf(){
        return $this->hasOne(Ciclo::class, 'id', 'ciclo_id');
    }

}
