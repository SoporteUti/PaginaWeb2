<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class TransparenciaRoutes{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next){

        //Para validar el acceso a las categorias dendiendo el rol que tenga

        $user = Auth::user();
        $roles = $user->getRoleNames()->toArray();

        $url = $request->path();
        $url_ = Str::of($url)->explode('/');

        // $return = null;

        // dd($url_);
        if(count($url_)<=2){
            return abort(404);
        }

        $categoria = $url_[2];

        if(in_array('super-admin', $roles)){
            return  $next($request);
        }else if(in_array('Transparencia-Presupuestario', $roles)){
            return (strcmp($categoria, 'marco-presupuestario')==0)
                    ? $next($request)
                    : abort(404);
        }else if(in_array('Transparencia-Decano', $roles)){
            return (strcmp($categoria, 'marco-gestion')==0 || strcmp($categoria, 'marco-normativo')==0)
                    ? $next($request)
                    : abort(404);
        }else if(in_array('Transparencia-Secretario', $roles)){
            return (strcmp($categoria, 'repositorios')==0 || strcmp($categoria, 'marco-normativo')==0 || strcmp($categoria, 'documentos-JD')==0 || strcmp($categoria, 'marco-gestion')==0)
                    ? $next($request)
                    : abort(404);
        }else if(in_array('Transparencia-Repositorio', $roles)){
            return (strcmp($categoria, 'repositorios')==0)
                    ? $next($request)
                    : abort(404);
        }else{
            return abort(404);
        }

        // return $return;
        
    }
}
