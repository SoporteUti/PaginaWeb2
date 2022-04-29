<?php

namespace Database\Seeders;

use App\Models\Tipo_Jornada;
use Illuminate\Database\Seeder;

class Tipo_JornadaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tipo_Jornada::create([
            'tipo'=>'Tiempo Completo',
            'horas_semanales' => '40',
            'estado'=>'activo',
        ]);
        Tipo_Jornada::create([
            'tipo'=>'Medio Tiempo',
            'horas_semanales' => '20',
            'estado'=>'activo',
        ]);
    }
}