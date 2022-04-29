<?php

namespace App\Models\Pagina;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ImagenesCarrusel extends Model
{
    use HasFactory;
    protected $table='imagenes_carrusels';
    protected $guarded = ['id'];
    protected $fillable =['imagen'];
}
