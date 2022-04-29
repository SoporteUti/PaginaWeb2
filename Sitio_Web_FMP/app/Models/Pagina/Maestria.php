<?php

namespace App\Models\Pagina;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maestria extends Model
{
    use HasFactory;
    protected $table='maestrias';
    protected $guarded = ['id'];
    protected $fillable =['nombre, titulo, modalidad, duracion,numero_asignatura, unidades_valorativas, precio, contenido, user, PDF'];
    
}
