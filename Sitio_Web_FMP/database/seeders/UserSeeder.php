<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(){

        $usu = User::create([
            'name'=>'Liseth Guadalupe Merino de Córdova',
            'email'=>'liseth.merino@ues.edu.sv',
            'password'=>Hash::make('12345678'),
            'estado' => true,
        ]);
        
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'estado' => true,
        ]);
        $presupuestario = User::create([
            'name' => 'Presupuestario',
            'email' => 'presupuestario@gmail.com',
            'password' => Hash::make('presupuestario'),
            'estado' => true,
        ]);
        $decano = User::create([
            'name' => 'Decano',
            'email' => 'decano@gmail.com',
            'password' => Hash::make('decano'),
            'estado' => true,
        ]);
        $secretario = User::create([
            'name' => 'Secretario',
            'email' => 'secretario@gmail.com',
            'password' => Hash::make('secretario'),
            'estado' => true,
        ]);

        $repositorio = User::create([
            'name' => 'Repositorio',
            'email' => 'repositorio@gmail.com',
            'password' => Hash::make('repositorio'),
            'estado' => true,
        ]);

        $pg = User::create([
            'name' => 'Pagina Admin',
            'email' => 'Pagina@ues.edu.sv',
            'password' => Hash::make('Pagina'),
            'estado' => true,
        ]);
        $user = User::create([
            'name'=>'Jefe Academico',
            'email'=> 'jefe@ues.edu.sv',
            'password'=>Hash::make('jefe'),
            'estado' => true,
        ]);

        $rrhh = User::create([
            'name'=>'Recurso Humano',
            'email'=> 'rrhh@ues.edu.sv',
            'password'=>Hash::make('rrhh'),
            'estado' => true,
        ]);

        $docente = User::create([
            'name'=>'Docente',
            'email'=> 'docente@ues.edu.sv',
            'password'=>Hash::make('docente'),
            'estado' => true,
        ]);

        $jefea = User::create([
            'name'=>'Jefe Administrativo',
            'email'=> 'jefea@ues.edu.sv',
            'password'=>Hash::make('jefea'),
            'estado' => true,
        ]);
        
        //Asignar el role usuario
        $usu->assignRole('super-admin');
        $admin->assignRole('super-admin');
        $pg->assignRole('super-admin');
        $presupuestario->assignRole('Transparencia-Presupuestario');
        $repositorio->assignRole('Transparencia-Repositorio');
        $decano->assignRole('Transparencia-Decano');
        $secretario->assignRole('Transparencia-Secretario');
        $user->assignRole('Jefe-Academico');
        $jefea->assignRole('Jefe-Administrativo');
        $rrhh->assignRole('Recurso-Humano');
        $docente->assignRole('Docente');
        $docente->assignRole('Jefe-Academico');

        
    }
}
