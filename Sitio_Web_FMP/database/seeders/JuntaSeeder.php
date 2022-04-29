<?php

namespace Database\Seeders;

use App\Models\Pagina\JuntaJefatura;
use Illuminate\Database\Seeder;

class JuntaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        JuntaJefatura::create([
            'nombre'=>'periodo',
            'sector_dep_unid'=>'PERIODO 2019 - 2023',
            'tipo'=>2,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'periodo',
            'sector_dep_unid'=>'PERIODO 2019 - 2023',
            'tipo'=>3,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'Ing. Roberto Antonio Díaz Flores',
            'sector_dep_unid'=>'Decano',
            'tipo'=>0,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'MSc. Luis Alberto Mejía Orellana',
            'sector_dep_unid'=>'Vice-Decano',
            'tipo'=>0,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'MSc. Wilber Samuel Escoto Umaña',
            'sector_dep_unid'=>'Miembro Propietario del Personal  Académico',
            'tipo'=>0,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'Lic. Manuel de Jesús Medina Amaya',
            'sector_dep_unid'=>'Miembro Propietario del Personal  Académico',
            'tipo'=>0,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'MSc. Mercedes Guadalupe Catalán Granadino',
            'sector_dep_unid'=>'Miembro Suplente del Personal  Académico',
            'tipo'=>0,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'MSc. Jossué Humberto Henríquez García',
            'sector_dep_unid'=>'Miembro Suplente del Personal  Académico',
            'tipo'=>0,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'Br. Arístides Yancarlos García Gutiérrez',
            'sector_dep_unid'=>'Miembro Propietario del Sector Estudiantil',
            'tipo'=>0,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'Br. Oscar Javier Cruz Centeno',
            'sector_dep_unid'=>'Miembro Propietario del Sector Estudiantil',
            'tipo'=>0,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'Br. Zuleyma Lisseth Erazo Pineda',
            'sector_dep_unid'=>'Miembro Suplente del Sector Estudiantil',
            'tipo'=>0,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'Br. Meybelin Catalina Portillo Alvarado',
            'sector_dep_unid'=>'Miembro Suplente del Sector Estudiantil',
            'tipo'=>0,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'Prof. Geovanny Antonio Quintanilla Panameño',
            'sector_dep_unid'=>'Miembro Propietario del Sector Profesional no Docente',
            'tipo'=>0,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'Prof. José Francisco Aguilar',
            'sector_dep_unid'=>'Miembro Suplente del Sector Profesional no Docente',
            'tipo'=>0,
            'user'=>1,
        ]);

        //otros************************
        JuntaJefatura::create([
            'nombre'=>'Ing. Roberto Antonio Díaz Flores',
            'sector_dep_unid'=>'Decano',
            'tipo'=>1,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'MSc. Luis Alberto Mejía Orellana',
            'sector_dep_unid'=>'Vice-Decano',
            'tipo'=>1,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'MSc. Carlos Marcelo Torres Araujo',
            'sector_dep_unid'=>'Secretario',
            'tipo'=>1,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'MSc. Yanira Yolanda Guardado Jovel',
            'sector_dep_unid'=>'Jefa de Departamento de Ciencias Económicas',
            'tipo'=>1,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'Inga. Virna Yasmina Urquilla Cuéllar',
            'sector_dep_unid'=>'Jefa de Departamento de Informática',
            'tipo'=>1,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'MSc. José Fredy Cruz Centeno',
            'sector_dep_unid'=>'Jefe de Departamento de Ciencias Agronómicas',
            'tipo'=>1,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'MSc. Glenn Roosel Muñoz Santillana',
            'sector_dep_unid'=>'Jefe de Departamento de Ciencias de la Educación',
            'tipo'=>1,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'MSc. René Francisco Vásquez',
            'sector_dep_unid'=>'Jefe de Unidad de Postgrado',
            'tipo'=>1,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'MSc. Edwin Arnoldo Cerón Chávez',
            'sector_dep_unid'=>'Jefe de la Unidad de Proyección Social',
            'tipo'=>1,
            'user'=>1,
        ]);

        JuntaJefatura::create([
            'nombre'=>'MSc. Esmeralda del Carmen Quintanilla Segovia',
            'sector_dep_unid'=>'Jefa de la Unidad de Biblioteca',
            'tipo'=>1,
            'user'=>1,
        ]);



    }
}
