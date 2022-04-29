<?php

namespace Database\Seeders;

use App\Models\Tipo_Contrato;
use Illuminate\Database\Seeder;

class Tipo_ContratoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      Tipo_Contrato::create([
            'tipo'=>'Pemanente',
            'estado'=>'activo',
        ]);
        Tipo_Contrato::create([
            'tipo'=>'Ley de Salario',
            'estado'=>'activo',
        ]);
    }
}