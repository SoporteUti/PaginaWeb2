<?php

namespace App\Models\Pagina;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Directorio extends Model
{
    use HasFactory;
    protected $table='directorios';
    protected $guarded = ['id'];
    protected $fillable =['nombre,contacto,user'];
}
