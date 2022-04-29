<?php

namespace Database\Seeders;

use App\Models\Horarios\Aula;
use Illuminate\Database\Seeder;

class AulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Aula::create([
            'codigo_aula'=>'AESIP',
            'nombre_aula'=>'Asociación de Estudiantes de Sistemas Informaticos Paracentral',
            'ubicacion_aula'=>'Asociaciones',
            'capacidad_aula'=>30,
            'estado'=>true,
        ]);

        Aula::create([
            'codigo_aula'=>'A 2-1',
            'nombre_aula'=>'Aula 1-1',
            'ubicacion_aula'=>'1a planta Edificio A',
            'capacidad_aula'=>30,
            'estado'=>true,
        ]);
    }
}
