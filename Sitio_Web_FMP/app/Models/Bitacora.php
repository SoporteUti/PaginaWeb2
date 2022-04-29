<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model{
    use HasFactory;
    protected $table = 'bitacora';
    protected $guarded = ['id'];
    protected $fillable = ['id_usuario', 'evento', 'accion', 'modulo'];

    public function usuario(){
        return $this->hasOne(User::class, 'id', 'id_usuario');
    }
}
