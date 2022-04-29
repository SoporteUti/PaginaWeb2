<?php

namespace App\Models\Licencias;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso_seguimiento extends Model
{
    use HasFactory;
    protected $table = 'permiso_seguimiento';

    protected $guarded = ['id'];
}
