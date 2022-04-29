<?php

namespace Database\Seeders;

use App\Models\Horarios\Departamento;
use Illuminate\Database\Seeder;

class DepartamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Departamento::create([
            'nombre_departamento'=>'Informática',
            'estado'=>true,
        ]);
        Departamento::create([
            'nombre_departamento'=>'Ciencias Económicas',
            'estado'=>true,
        ]);
        Departamento::create([
            'nombre_departamento'=>'Agronomia',
            'estado'=>true,
        ]);
        Departamento::create([
            'nombre_departamento'=>'Unidad Financiera',
            'estado'=>true,
        ]);

        Departamento::create([
            'nombre_departamento'=>'Unidad de Tecnologia',
            'estado'=>true,
        ]);
    }
}
