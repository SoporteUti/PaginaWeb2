<?php

namespace App\Models\Transparencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directorio extends Model{
    use HasFactory;
    protected $table = 'transparencia_directorios';
    protected $guarded = ['id'];
    protected $fillable = [
        'nombre',
        'contacto',
        'estado',
    ];
}
