<?php

namespace Database\Seeders;

use App\Models\Pagina\Directorio;
use Illuminate\Database\Seeder;

class DirectorioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Directorio::create([
            'nombre'=>'Decanato',
            'contacto'=>'2393 - 1992<br />
            decanato.fmp@ues.edu.sv',
            'user'=>1,
            'tipo'=>0,
        ]);
        Directorio::create([
            'nombre'=>'Administración Académica',
            'contacto'=>'2393 - 1993<br />
            academica.fmp@ues.edu.sv',
            'user'=>1,
            'tipo'=>0,
        ]);

        Directorio::create([
            'nombre'=>'Proyección Social',
            'contacto'=>'proyeccionsocial.fmp@ues.edu.sv',
            'user'=>1,
            'tipo'=>0,
        ]);

        Directorio::create([
            'nombre'=>'Recursos Humanos',
            'contacto'=>'recursos.humanos@ues.edu.sv',
            'user'=>1,
            'tipo'=>0,
        ]);
        Directorio::create([
            'nombre'=>'Unidad de Tecnología de la Información',
            'contacto'=>'soporte.tifmp@ues.edu.sv',
            'user'=>1,
            'tipo'=>0,
        ]);

        Directorio::create([
            'nombre'=>'Unidad de Postgrado',
            'contacto'=>'postgardo.fmp@ues.edu.sv',
            'user'=>1,
            'tipo'=>0,
        ]);

        Directorio::create([
            'nombre'=>'Licenciaturas en Educación - Plan Complementario',
            'contacto'=>'7662 - 5484',
            'user'=>1,
            'tipo'=>0,
        ]);

        Directorio::create([
            'nombre'=>'Administración Financiera',
            'contacto'=>'2393 -',
            'user'=>1,
            'tipo'=>0,
        ]);
    }
}
