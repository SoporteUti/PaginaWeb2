<?php

namespace Database\Factories\Transparencia;

use App\Models\Transparencia\Transparencia;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransparenciaFactory extends Factory{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Transparencia::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'titulo' =>$this->faker->name,
            'descripcion' =>$this->faker->text,
            'documento' => 'uploads/transparencia/faker/sample.pdf',
            'publicar' => 'publicado',
            'categoria' => $this->faker->randomElement(['marco-normativo', 'marco-gestion', 'marco-presupuestario', 'repositorios', 'documentos-JD']),
            'subcategoria' => $this->faker->randomElement(['agendas', 'actas', 'acuerdos']),
            'estado' => 'activo'
        ];
    }
}
