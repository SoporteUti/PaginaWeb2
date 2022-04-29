<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tipo_Contrato extends Model
{
    use HasFactory;
    protected $table = 'tipo_contrato';

    protected $guarded = ['id'];
    protected $fillable = ['tipo','estado'];
}
