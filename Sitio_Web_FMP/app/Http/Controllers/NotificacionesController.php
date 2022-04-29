<?php

namespace App\Http\Controllers;

use App\Models\Notificaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificacionesController extends Controller{

    public function __construct(){
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $query = Notificaciones::select('*');
        $usuario = Auth::user();
        if (!$usuario->hasRole('admin')) {
            $query->where('usuario_id', $usuario->id);
        }

        $notificaciones = $query->orderBy('created_at', 'DESC')->get();

        return view('Notificaciones.index', compact(['notificaciones']));
    }

    public function check($id)
    {
        $noti = Notificaciones::findOrFail($id);

        $noti->update([
            'estado' => false,
        ]);

        return redirect('admin/notificaciones/')->with('bandera', 'Registro modificado con éxito!');
    }
}
