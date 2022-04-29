<?php

namespace Database\Seeders;

use App\Models\Horarios\Hora;
use Illuminate\Database\Seeder;

class HoraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Hora::create([
            'inicio'=>'08:00',
            'fin'=>'10:00',
        ]);

        Hora::create([
            'inicio'=>'10:00',
            'fin'=>'12:00',
        ]);
    }
}
