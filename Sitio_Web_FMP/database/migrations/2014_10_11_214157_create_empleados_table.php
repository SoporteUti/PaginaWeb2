<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmpleadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empleado', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('apellido');
            $table->string('dui')->nullable();
            $table->string('nit')->nullable();
            $table->string('telefono')->nullable();
            $table->string('urlfoto')->nullable();
            $table->boolean("estado")->default(true);
            $table->enum('tipo_empleado',['Administrativo','Académico']);
            $table->bigInteger('jefe')->nullable();
            $table->bigInteger('id_depto');
            $table->bigInteger('categoria');
           

            $table->foreign('jefe')
            ->references('id')
            ->on('empleado')
            ->onDelete('cascade');
            
            $table->foreign('id_depto')
            ->references('id')
            ->on('departamentos')
            ->onDelete('cascade');
            
            $table->foreign('categoria')
            ->references('id')
            ->on('categoria_empleados')
            ->onDelete('cascade');

            $table->timestamps();         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empleado');
    }
}
