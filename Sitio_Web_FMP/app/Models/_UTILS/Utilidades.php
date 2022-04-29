<?php

namespace App\Models\_UTILS;

use App\Models\Bitacora;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Utilidades extends Model{
    use HasFactory;

    public static function fnSaveBitacora($evento, $accion, $modulo){
        $user = Auth::user();
        Bitacora::create([
            'id_usuario' => $user->id,
            'evento' => $evento,
            'accion' => $accion,
            'modulo' => $modulo,
        ]);
    }

}
