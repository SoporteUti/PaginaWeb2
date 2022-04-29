<?php

namespace App\Imports;

use App\Models\Reloj\Reloj_dato;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DatosImport implements
    ToModel,
    WithHeadingRow,
    WithBatchInserts,
    WithChunkReading
{
    use Importable;
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        //echo dd($row);
        //minutos de gracia
        $gracia='00:05:00';
        //PARA SINCRONIZAR EL DIA DE LA SEMANA CON DIA DE LA JORNADA
        if($row['dia_de_la_semana']=='Lun.'){
            $diaNuevo='Lunes';
        }else if($row['dia_de_la_semana']=='Mar.'){
            $diaNuevo='Martes';
        }else if($row['dia_de_la_semana']=='Mie.'){
            $diaNuevo='Miércoles';
        }else if($row['dia_de_la_semana']=='Jue.'){
            $diaNuevo='Jueves';
        }else if($row['dia_de_la_semana']=='Fri.'){
            $diaNuevo='Viernes';
        }else if($row['dia_de_la_semana']=='Sab.' || $row['dia_de_la_semana']=='Sat.'){
            $diaNuevo='Sábado';
        }else{
            $diaNuevo='Domingo';
        }
        //FIN DE SINCRONIZAR EL DIA DE LA SEMANA CON EL DIA DE LA JORNADA
        //AGREGAR CEROS A LA IZQUIERDA
        $length = 9;
        $formato = substr(str_repeat(0, $length) . $row['id_de_persona'], -$length);
        //FIN DE AGREGAR CERO A LA IZQUIERDA

        //PARA AGREGAR EL GUIÓN
        $primeros = substr($formato, 0, -1);  //primeros 8 numeros 05168001
        $ultimo = substr($formato, -1);  // ultimo numero 7
        $dui = $primeros . '-' . $ultimo;   //dui= 05168001-7
        //FIN DE AGREGAR EL GUIÓN
        //PARA QUITAR LA INCONSISTENCIA

       if (!is_numeric($row['indice'])) {

        } else {

            //VALIDACION DE QUE NO SE REPITAN LOS DATOS
            $filaExists = Reloj_dato::where([
                ['id_persona', '=', $dui],
                ['fecha', '=', $row['fecha']]
            ])->first();
            //FIN DE VALIDACIÓN PARA QUE NO SE REPITAN LOS DATOS
            //dd($filaExists);

            if (!$filaExists) {

                $data = new Reloj_dato([
                    'indice'           => $row['indice'],
                    'id_persona'       => $dui,
                    'nombre_personal'  => $row['nombre'],
                    'departamento'     => $row['departamento'],
                    'posicion'         => $row['posicion'],
                    'genero'           => $row['genero'],
                    'fecha'            => $row['fecha'],
                    'dia_semana'       => $diaNuevo,
                    'horario'          => $row['horario'],
                    'entrada'          => $row['primera_entrada'],
                    'salida'           => $row['ultima_salida'],
                    'gracia'           => $gracia
                ]);
                //echo dd($data);
                return $data;
            } else {
                return 0;
            }
        }//FIN DE QUITAR LA INCONSISTENCIA
    } //FIN DE MODELO DE INSERCION DE DATOS

    //METODO QUE INSERTA POR LOTES PARA MEJORAR EL RENDIMIENTO DEL SERVIDOR
    public function batchSize(): int
    {
        return 1000;
    }
    //FIN DEL METODO QUE INSERTA POR LOTES

    //METODO DE INTERFAZ DE LECTURA EN FRAGMENTOS
    public function chunkSize(): int
    {
        return 1000;
    }
    //FIN DE METODO DE INTERFAZ DE LECTURA EN FRAGMENTOS



    public function headingRow(): int
    {
        return 5;
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 4;
    }
}
