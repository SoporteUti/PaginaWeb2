<?php

namespace App\Models\Transparencia;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transparencia extends Model{
    use HasFactory;
    protected $table = 'transparencia';
    protected $guarded = ['id'];
    protected $fillable = [
        'titulo',
        'descripcion',
        'documento',
        'publicar',
        'categoria',
        'subcategoria',
        'estado',
        // 'created_at'
    ];
}
