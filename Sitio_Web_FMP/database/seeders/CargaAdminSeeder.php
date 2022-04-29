<?php

namespace Database\Seeders;

use App\Models\Horarios\CargaAdmin;
use Illuminate\Database\Seeder;

class CargaAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        CargaAdmin::create([
            'nombre_carga'=>'Decanato',
            'categoria'=>'ad'
        ]);
        CargaAdmin::create([
            'nombre_carga'=>'Vicedecanato',
            'categoria'=>'ad'
        ]);
    }
}
