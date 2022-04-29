<?php

namespace App\Models\Pagina;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PDF extends Model
{
    use HasFactory;
    protected $table='p_d_f_s';
    protected $guarded = ['id'];
    protected $fillable =[
        'localizacion',
        'file',
        'user'
    ];
}
