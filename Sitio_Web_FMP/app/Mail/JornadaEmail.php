<?php

namespace App\Mail;

use App\Models\General\Empleado;
use App\Models\Horarios\Departamento;
use App\Models\Jornada\Periodo;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JornadaEmail extends Mailable{
    use Queueable, SerializesModels;
    public $jefe;
    public $empleados;
    public $periodo;
    public $deptos;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Empleado $jefe, Periodo $periodo, $deptos, $empleados){
        $this->jefe = $jefe;
        $this->periodo = $periodo;
        $this->deptos = $deptos;
        $this->empleados = $empleados;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(){
        return $this->subject('Jornadas')->view('Mails.jornada');
    }
}
