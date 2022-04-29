<?php

namespace App\Models\General;

use App\Models\Horarios\Departamento;
use App\Models\Tipo_Jornada;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;

class Empleado extends Model
{
    use HasFactory;
    protected $table = 'empleado';
    protected $guarded = ['id'];
    protected $fillable = [
        'id_depto',
        'nombre',
        'apellido',
        'dui',
        'nit',
        'telefono',
        'urlfoto',
        'estado',
        'categoria',
        'jefe',
        'salario',
        'tipo_empleado',
        'id_tipo_jornada',
        'id_tipo_contrato',
    ];

    public function tipo_jornada_rf(){
        return $this->hasOne(Tipo_Jornada::class, 'id', 'id_tipo_jornada');
    }

    public function tipo_contrato_rf(){
        return $this->hasOne(Tipo_Contrato::class, 'id', 'id_tipo_contrato');
    }

    public function jefe_rf(){
        return $this->hasOne(Empleado::class, 'id', 'jefe');
    }
    
    public function usuario_rf(){
        return $this->hasOne(User::class, 'empleado', 'id');
    }

    public function departamento_rf(){
        return $this->hasOne(Departamento::class, 'id', 'id_depto');
    }
}

