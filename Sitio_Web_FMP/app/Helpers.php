<?php

use App\Models\Notificaciones;
use Illuminate\Support\Facades\Auth;

function notificaciones(){
    $notificaciones = Notificaciones::where('estado', true)
        ->where('usuario_id', Auth::user()->id)
        ->orderBy('created_at', 'DESC')
        ->get();

    return $notificaciones;
}
