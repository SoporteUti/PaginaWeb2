<?php

namespace App\Models\Pagina;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContenidoHtml extends Model
{
    use HasFactory;
    protected $table='contenido_htmls';
    protected $guarded = ['id'];
    protected $fillable =['localizacion,contenido,user'];
}
