<?php

namespace App\Models\Pagina;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;
    protected $table='noticias';
    protected $guarded = ['id'];
    protected $fillable =[
        'titulo',
        'subtitulo',
        'contenido',
        'fuente',
        'urlfuente',
        'imagen'
    ];

}
