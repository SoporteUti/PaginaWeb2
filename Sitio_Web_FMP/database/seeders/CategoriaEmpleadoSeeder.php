<?php

namespace Database\Seeders;

use App\Models\General\CategoriaEmpleado;
use Illuminate\Database\Seeder;

class CategoriaEmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CategoriaEmpleado::create([
            'categoria'=>'PUI'
       
            
        ]);
        //
        CategoriaEmpleado::create([
            'categoria'=>'PUII'
       
            
        ]);
        //
        CategoriaEmpleado::create([
            'categoria'=>'PUIII'
        ]);

        //
        CategoriaEmpleado::create([
            'categoria'=>'TECNICO I'     
        ]);

        //
        CategoriaEmpleado::create([

            'categoria'=>'TECNICO Ii'
       
            
        ]);
        //
        CategoriaEmpleado::create([
            'categoria'=>'TECNICO III'
       
            
        ]);
    }
}
