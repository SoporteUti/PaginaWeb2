<?php

namespace Database\Seeders;

use App\Models\Pagina\ImagenesCarrusel;
use Illuminate\Database\Seeder;

class CarrucelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ImagenesCarrusel::create([
            'imagen'=>'60f9a605c8214',
            'user'=>1,
            'tipo'=>1,
        ]);

        ImagenesCarrusel::create([
            'imagen'=>'61002d567932c',
            'user'=>1,
            'tipo'=>2,
        ]);

        ImagenesCarrusel::create([
            'imagen'=>'61003032a904d',
            'user'=>1,
            'tipo'=>2,
        ]);

        ImagenesCarrusel::create([
            'imagen'=>'6100303350ecd',
            'user'=>1,
            'tipo'=>2,
        ]);

        ImagenesCarrusel::create([
            'imagen'=>'6100369124390',
            'user'=>1,
            'tipo'=>3,
        ]);

        ImagenesCarrusel::create([
            'imagen'=>'6100609c38df0',
            'user'=>1,
            'tipo'=>1,
        ]);

        ImagenesCarrusel::create([
            'imagen'=>'6100609c702dd',
            'user'=>1,
            'tipo'=>1,
        ]);

        ImagenesCarrusel::create([
            'imagen'=>'6100609cc4a6e',
            'user'=>1,
            'tipo'=>1,
        ]);

        ImagenesCarrusel::create([
            'imagen'=>'6100656f49168',
            'user'=>1,
            'tipo'=>1,
        ]);

    }
}
