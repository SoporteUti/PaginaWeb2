<?php

namespace App\Models\General;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CategoriaEmpleado extends Model
{
    use HasFactory;
    protected $table = 'categoria_empleados';
    protected $guarded = ['id'];
    protected $fillable = ['categoria',];

}