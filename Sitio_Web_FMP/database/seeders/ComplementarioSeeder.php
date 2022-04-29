<?php

namespace Database\Seeders;

use App\Models\Pagina\Complementario;
use Illuminate\Database\Seeder;

class ComplementarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Complementario::create([

            'nombre'=>'Licenciatura en Administración Escolar',
            'titulo'=>'Licenciado/a en Administración Escolar',
            'modalidad'=>'Semipresencial',
            'duracion'=>'2 Años',
            'numero_asignatura'=>'12',
            'unidades_valorativas'=>'161',
            'precio'=>'Nuevo Ingreso: $11.43
            Reingreso: $5.71
            Matricula: $30.00
            Mensualidad: $30.00',
            'dirigido'=>'Egresados de Profesorado y Profesores Graduados',
            'user'=>6,
            'estado'=>1,
        ]);
    }
}
