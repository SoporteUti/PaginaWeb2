<?php

namespace Database\Seeders;

use App\Models\Pagina\PDF;
use Illuminate\Database\Seeder;

class PDFSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PDF::create([
            'localizacion'=>'organigrama',
            'file'=>'60f9a6381c19c',
            'user'=>1,
        ]);

        PDF::create([
            'localizacion'=>'ccEdu',
            'file'=>'LicSocial.pdf',
            'user'=>1,
        ]);


    }
}
