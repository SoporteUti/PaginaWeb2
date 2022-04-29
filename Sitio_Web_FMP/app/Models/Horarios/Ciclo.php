<?php

namespace App\Models\Horarios;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ciclo extends Model{
    use HasFactory;
    protected $table = 'ciclos';
    protected $guarded = ['id'];
    protected $fillable = ['nombre', 'estado', 'año'];

    public function horarios_rf(){
        return $this->hasMany(Horarios::class, 'id_ciclo', 'id')->orderBy('id', 'DESC');
    }
}
