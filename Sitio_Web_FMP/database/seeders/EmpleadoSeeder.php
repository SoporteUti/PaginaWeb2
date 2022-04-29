<?php

namespace Database\Seeders;
use App\Models\General\Empleado;
use Illuminate\Database\Seeder;

class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //Jefes
        Empleado::create([
            'id_depto'=>1,
            'nombre'=>'Martín',
            'apellido'=>'Moz Montoya',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
            
        ]);
        
        Empleado::create([
            'id_depto'=>2,
            'nombre'=>' Fabian',
            'apellido'=>'Zelaya',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Académico',
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
        ]);

        Empleado::create([
            'id_depto'=>3,
            'nombre'=>'Samuel',
            'apellido'=>'Fernández',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
            
        ]);

        Empleado::create([
            'id_depto'=>4,
            'nombre'=>'Paula',
            'apellido'=>'Romero',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>5,
            'tipo_empleado'=>'Administrativo',
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
            
        ]);

        Empleado::create([
            'id_depto'=>5,
            'nombre'=>' Nicolle',
            'apellido'=>'Gamez',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>4,
            'tipo_empleado'=>'Administrativo',
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        //Empleados 

        Empleado::create([
            'id_depto'=>1,
            'nombre'=>' Jonathan Adrian',
            'apellido'=>'Aguilar Garcia',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Académico',
            'jefe'=>1,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        Empleado::create([
            'id_depto'=>1,
            'nombre'=>'Ronaldo',
            'apellido'=>'Aguilar',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Académico',
            'jefe'=>1,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        Empleado::create([
            'id_depto'=>1,
            'nombre'=>'Esmeralda',
            'apellido'=>'Aguilar Garcia',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Académico',
            'jefe'=>1,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        Empleado::create([
            'id_depto'=>1,
            'nombre'=>'Ana',
            'apellido'=>'Aguilar',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Académico',
            'jefe'=>1,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        Empleado::create([
            'id_depto'=>1,
            'nombre'=>'Karla',
            'apellido'=>'Aguilar Garcia',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Académico',
            'jefe'=>1,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        Empleado::create([
            'id_depto'=>1,
            'nombre'=>'Victor',
            'apellido'=>'Aguilar',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Académico',
            'jefe'=>1,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        Empleado::create([
            'id_depto'=>1,
            'nombre'=>'Paulino',
            'apellido'=>'Aguilar Garcia',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Académico',
            'jefe'=>1,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        Empleado::create([
            'id_depto'=>1,
            'nombre'=>'Mariana',
            'apellido'=>'Aguilar',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Académico',
            'jefe'=>1,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        //

        Empleado::create([
            'id_depto'=>2,
            'nombre'=>'Raul',
            'apellido'=>'Garcia',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>2,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        

        Empleado::create([
            'id_depto'=>2,
            'nombre'=>'Gilberto',
            'apellido'=>'Gómez',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'jefe'=>2,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        Empleado::create([
            'id_depto'=>2,
            'nombre'=>'Elias',
            'apellido'=>'Garcia',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>2,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        

        Empleado::create([
            'id_depto'=>2,
            'nombre'=>'Walter',
            'apellido'=>'Gómez',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'jefe'=>2,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        Empleado::create([
            'id_depto'=>2,
            'nombre'=>'Enrique',
            'apellido'=>'Garcia',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>2,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        

        Empleado::create([
            'id_depto'=>2,
            'nombre'=>'Adrian',
            'apellido'=>'Gómez',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'jefe'=>2,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        Empleado::create([
            'id_depto'=>2,
            'nombre'=>'Miguel',
            'apellido'=>'Garcia',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>2,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>2,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        

        Empleado::create([
            'id_depto'=>2,
            'nombre'=>'Adonay',
            'apellido'=>'Gómez',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'jefe'=>2,
            'id_tipo_jornada'=>2,
            'id_tipo_contrato'=>2
            
        ]);

        //

        Empleado::create([
            'id_depto'=>3,
            'nombre'=>'Lucía',
            'apellido'=>'López',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'jefe'=>3,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
            
        ]);

        Empleado::create([
            'id_depto'=>3,
            'nombre'=>'Sofía',
            'apellido'=>'García',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'jefe'=>3,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
            
        ]);

        Empleado::create([
            'id_depto'=>3,
            'nombre'=>'Marcelo',
            'apellido'=>'López',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'jefe'=>3,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
            
        ]);

        Empleado::create([
            'id_depto'=>3,
            'nombre'=>'Julio',
            'apellido'=>'García',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'jefe'=>3,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
            
        ]);

        Empleado::create([
            'id_depto'=>3,
            'nombre'=>'Francisco',
            'apellido'=>'López',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'jefe'=>3,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
            
        ]);

        Empleado::create([
            'id_depto'=>3,
            'nombre'=>'Luisa',
            'apellido'=>'García',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'jefe'=>3,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
            
        ]);

        Empleado::create([
            'id_depto'=>3,
            'nombre'=>'Agatha',
            'apellido'=>'López',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'jefe'=>3,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
            
        ]);

        Empleado::create([
            'id_depto'=>3,
            'nombre'=>'Martina',
            'apellido'=>'García',
            'dui'=>'0987896-4',
            'nit'=>'0614-180560-020-6',
            'telefono'=>'7890-6574',
            'categoria'=>1,
            'tipo_empleado'=>'Académico',
            'jefe'=>3,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
            
        ]);

        //

        Empleado::create([
            'id_depto'=>4,
            'nombre'=>' Valeria',
            'apellido'=>'Sánchez',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>5,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>4,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>4,
            'nombre'=>' Federico',
            'apellido'=>'Fuentes',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>5,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>4,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>4,
            'nombre'=>' Oscar',
            'apellido'=>'Sánchez',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>5,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>4,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>4,
            'nombre'=>' Manuel',
            'apellido'=>'Fuentes',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>5,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>4,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>4,
            'nombre'=>' Mario',
            'apellido'=>'Sánchez',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>5,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>4,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>4,
            'nombre'=>' Beatriz',
            'apellido'=>'Fuentes',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>5,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>4,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>4,
            'nombre'=>' Martin',
            'apellido'=>'Sánchez',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>5,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>4,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>4,
            'nombre'=>' Federica',
            'apellido'=>'Fuentes',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>5,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>4,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        //

        Empleado::create([
            'id_depto'=>5,
            'nombre'=>' Daniel',
            'apellido'=>'Castillo',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>4,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>5,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>5,
            'nombre'=>' César',
            'apellido'=>'Campos	',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>4,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>5,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>5,
            'nombre'=>' Gisel',
            'apellido'=>'Castillo',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>4,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>5,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>5,
            'nombre'=>' Silvia',
            'apellido'=>'Campos	',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>4,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>5,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>5,
            'nombre'=>' Kevin',
            'apellido'=>'Castillo',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>4,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>5,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>5,
            'nombre'=>' Bryan',
            'apellido'=>'Campos	',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>4,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>5,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>5,
            'nombre'=>' Raul',
            'apellido'=>'Castillo',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>4,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>5,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

        Empleado::create([
            'id_depto'=>5,
            'nombre'=>' Manuel',
            'apellido'=>'Campos	',
            'dui'=>'03379875-5',
            'nit'=>'0614-130985-125-5',
            'telefono'=>'7696-6969',
            'categoria'=>4,
            'tipo_empleado'=>'Administrativo',
            'jefe'=>5,
            'id_tipo_jornada'=>1,
            'id_tipo_contrato'=>1
        ]);

    }
}
