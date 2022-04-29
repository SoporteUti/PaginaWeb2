<?php

namespace App\Models\Jornada;

use App\Models\General\Empleado;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Jornada extends Model
{
    use HasFactory;
    protected $table = 'jornada';

    protected $guarded = 'id';

    protected $fillable = ['id_emp', 'id_periodo', 'procedimiento','estado', 'observaciones'];

    public function items(){
        return $this->hasMany(JornadaItem::class, 'id_jornada', 'id');
    }

    public function seguimiento(){
        return $this->hasMany(Seguimiento::class, 'jornada_id', 'id')->orderBy('id','DESC');
    }

    public function items_enabled($estado){
        return $this->items()->select('dia', 'hora_inicio', 'hora_fin', 'id_jornada')->where('estado', $estado)->get();
    }

    public function periodo_rf(){
        return $this->hasOne(Periodo::class, 'id', 'id_periodo');
    }

    public function empleado_rf(){
        return $this->hasOne(Empleado::class, 'id', 'id_emp');
    }

    public function horas($dia, $empleado, $periodo = 1, $jornada){
        $query = $this->items()
                    ->join('jornada', 'jornada.id', 'jornada_items.id_jornada')
                    ->join('empleado' , 'empleado.id', 'jornada.id_emp')
                    ->where('jornada_items.dia', $dia)
                    ->where('empleado.id', $empleado)
                    ->where('jornada.id', $jornada)
                    ->where('jornada.id_periodo', $periodo)
                    ->where('jornada.estado', 'activo')
                    ->where('jornada_items.estado', 'activo')
                    ->first();
        return $query;
    }

}
