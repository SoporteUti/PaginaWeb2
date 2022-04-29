<?php

namespace Database\Seeders;

use App\Models\Horarios\Ciclo;
use Illuminate\Database\Seeder;

class CicloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        Ciclo::create([
            'nombre'=>'Ciclo-I',
            'año'=>'2021',
        ]);
        Ciclo::create([
            'nombre'=>'Ciclo-II',
            'año'=>'2021',
        ]);
    }
}
