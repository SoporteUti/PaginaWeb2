<?php

namespace App\Models\Horarios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horarios extends Model{
    use HasFactory;

    protected $table = 'horarios';

    protected $guarded = ['id'];

    protected $fillable = ['numero_grupo','tipo_grupo', 'dias','ciclo','id_materia','id_aula','id_empleado','id_hora','id_ciclo'];

    public function ciclo_rf(){
        return $this->hasOne(Ciclo::class, 'id', 'id_ciclo');
    }
}
