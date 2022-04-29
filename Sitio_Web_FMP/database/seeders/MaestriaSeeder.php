<?php

namespace Database\Seeders;

use App\Models\Pagina\Maestria;
use Illuminate\Database\Seeder;

class MaestriaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Maestria::create([
            'nombre'=>'MAESTRIA EN ADMINISTRACION FINANICERA',
            'titulo'=>'Maestro/a en Administración Financiera',
            'modalidad'=>'Virtual',
            'duracion'=>'2 años y 6 meses de trabajo de Graduación',
            'numero_asignatura'=>'20',
            'unidades_valorativas'=>'63',
            'precio'=>'Matricula de $100.00 dólares anuales, 12 mensualidades de $110.00, matrícula de Proceso de Graduación de $100.00, mas seguimiento al Trabajo de Tesis de $100.00 mensuales',
            'contenido'=>'Contenido',
            'user'=>1,
            'estado'=>true,
        ]);

        Maestria::create([
            'nombre'=>'MAESTRIA EN DESARROLLO LOCAL',
            'titulo'=>'Maestro/a en Desarrollo Local Sostenible',
            'modalidad'=>'Virtual',
            'duracion'=>'2 años y 6 meses de trabajo de Graduación',
            'numero_asignatura'=>'11',
            'unidades_valorativas'=>'68',
            'precio'=>'100',
            'contenido'=>'Contenido',
            'user'=>1,
            'estado'=>true,
        ]);
    }
}
