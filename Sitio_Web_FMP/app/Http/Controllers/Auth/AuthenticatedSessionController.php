<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     *
     * @param  \App\Http\Requests\Auth\LoginRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(LoginRequest $request){
        $request->authenticate();

        $request->session()->regenerate();

        $user = Auth::user();

        if($user->hasRole('Pagina')){
            return(redirect()->route('index'));
        }else{
            return ($user->hasRole('super-admin') ||
            $user->hasRole('Transparencia-Secretario') || 
            $user->hasRole('Transparencia-Decano') ||
            $user->hasRole('Transparencia-Presupuestario') ||
            $user->hasRole('Recurso-Humano')||
            $user->hasRole('Docente')||
            $user->hasRole('Jefe-Administrativo') ||
            $user->hasRole('Jefe-Academico') )
                ? redirect()->intended('/admin')
                : redirect()->intended(RouteServiceProvider::HOME);
        }
       
        // return redirect()->intended(RouteServiceProvider::HOME);
    }

    /**
     * Destroy an authenticated session.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }

}
