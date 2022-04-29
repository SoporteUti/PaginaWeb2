<?php

namespace App\Models\Pagina;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JuntaJefatura extends Model
{
    use HasFactory;
    protected $table='junta_jefaturas';
    protected $guarded = ['id'];
    protected $fillable =['nombre, sector_dep_unid, tipo, user'];
}
