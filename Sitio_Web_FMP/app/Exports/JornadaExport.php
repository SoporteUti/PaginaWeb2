<?php

namespace App\Exports;

// use App\Models\Jornada\Jornada;
// use App\Models\Jornada\Periodo;
// use App\Models\User;
// use Maatwebsite\Excel\Concerns\Exportable;
// use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Jornada\Jornada;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class JornadaExport implements FromView{
    public $periodo;
    public $depto;

    public function __construct($periodo, $depto){
        $this->periodo = $periodo;
        $this->depto = $depto;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    // public function collection(){
    //     return User::all();
    // }

    public function view(): View{
        $query = Jornada::select('jornada.*')
                        ->where('id_periodo', $this->periodo)
                        ->join('empleado', 'empleado.id', 'jornada.id_emp')
                        // ->join('periodos as p', 'p.id', 'jornada.id_periodo')
                        ->whereIn('jornada.procedimiento',['aceptado','enviado a recursos humanos'])
                        ->whereIn('tipo_empleado', ['Académico','Administrativo'] );

        if(!is_null($this->depto)){
            $query->where('empleado.id_depto', $this->depto);
        }

        $jornadas = $query->get();

        return view('Jornada.exports.jornadas', [
            'jornadas' => $jornadas,
            'periodo' => $this->periodo
        ]);
    }
}
