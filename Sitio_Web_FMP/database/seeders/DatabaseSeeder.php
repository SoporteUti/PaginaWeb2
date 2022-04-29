<?php

namespace Database\Seeders;

use App\Models\General\CategoriaEmpleado;
use App\Models\Jornada\Periodo;
use App\Models\Pagina\Maestria;
use App\Models\Transparencia\Transparencia;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(){
        // \App\Models\User::factory(10)->create();
        // Transparencia::factory(2000)->create();

        $this->call([
            RolesSeeder::class,
            UserSeeder::class,
            DirectorioSeeder::class,
            MaestriaSeeder::class,
            CarrucelSeeder::class,
            JuntaSeeder::class,
            PDFSeeder::class,
            DepartamentoSeeder::class,
            HoraSeeder::class,
            AulaSeeder::class,
            CargaAdminSeeder::class,
            ComplementarioSeeder::class,
            PeriodoSeeder::class,
            CategoriaEmpleadoSeeder::class,
            Tipo_ContratoSeeder::class,
            Tipo_JornadaSeeder::class,
            
            EmpleadoSeeder::class,
            CicloSeeder::class,
            
        ]);
    }
}
