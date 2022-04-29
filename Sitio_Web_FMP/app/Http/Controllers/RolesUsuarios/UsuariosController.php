<?php

namespace App\Http\Controllers\RolesUsuarios;

use App\Models\User;
use App\Models\General\Empleado;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UsuariosController extends Controller
{
    
    public function index()
    {
        if(Auth::user()->hasRole('super-admin')){
            $usuarios = User::orderBy('id')->get();
            $empleados = Empleado::where('estado',true)->orderBy('nombre')->orderBy('apellido')->get();
            
            return view('Seguridad.Usuarios',compact('usuarios','empleados'));
        }else{
            return response()->json(['error'=>['ACCESO DENEGADO']]);
        }
    }

    public function usuarioRol($usuario){
        if(Auth::user()->hasRole('super-admin')){
            $roles = DB::table('model_has_roles')
            ->select('name')
            ->join('roles','roles.id','=','model_has_roles.role_id')
            ->where('model_has_roles.model_id','=',$usuario)
            ->get();
            for ($i=0; $i < count($roles); $i++) {$roles[$i]->name = base64_encode($roles[$i]->name);}
            return $roles->toJson();
        }else{
            return response()->json(['error'=>['ACCESO DENEGADO']]);
        }
    }

    public function usuario($usuario){    
        if(Auth::user()->hasRole('super-admin')){     
            return User::where('id',$usuario)
            ->select('id','name','email','empleado')
            ->first()
            ->toJson();
        }else{
            return response()->json(['error'=>['ACCESO DENEGADO']]);
        }
    }

    public function store(Request $request){
        if(Auth::user()->hasRole('super-admin')){
            $roles = $request -> roles;      
            $id = $request->_id;
            $validator = Validator::make($request->all(),[
                'usuario' => 'required|string|max:255',
                'correo' => ['required','email','max:50','string','unique:users,email'.(!is_null($id) ? ','.$id : null)],
                'contraseña' =>'required|min:8',
                'empleado' => ['required','unique:users,empleado'.(!is_null($id) ? ','.$id : null)],
                'repetir_contraseña'=> 'required|same:contraseña'
            ]);
            if($validator->fails())
            {            
                return response()->json(['error'=>$validator->errors()->all()]);                
            }

            if(is_null($request -> _id))
                $user = new User();
            else{
                $user = User::findOrFail($request -> _id);
                $user -> roles() -> detach();
            }

            $user -> name     = $request -> usuario;
            $user -> email    = $request -> correo;
            $user -> empleado = $request -> empleado;
            $user -> password = Hash::make($request->contraseña);
            $b = $user -> save(); 

            if($b&&!is_null($roles)){            
                for ($i=0; $i < count($roles); $i++){$user -> assignRole(base64_decode($roles[$i]));}
            }

            return !is_null($request->_id)?
            response()->json(['mensaje'=>'Modificación exitosa']):
            response()->json(['mensaje'=>'Registro exitoso']);
        }else{
            return response()->json(['error'=>['ACCESO DENEGADO']]);
        }
    }

    public function estado(Request $request){
        if(Auth::user()->hasRole('super-admin')){
            $u = User::findOrFail($request->_id);
            $u -> estado = !$u -> estado;
            $estado = $u -> save();
            if ($estado) {
                return response()->json(['mensaje'=>'Modificacion exitosa']);
            }else{
                return response()->json(['error'=>'Error']);
            }
        }else{
            return response()->json(['error'=>['ACCESO DENEGADO']]);
        }
    }
}
