@extends('layouts.admin')
@section('content')
    <!--Modal para generar la asistencia mensual-->
    <div id="ModificacionIncon" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
        aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myCenterModalLabel">
                        <i class=" fa fa-calendar mdi-24px" style="margin: 0px;"></i> Asistencia Laboral Mensual
                    </h3>

                </div>
                <form action="{{ route('Importaciones/cambio') }}" method="POST" id="AsisMensual"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">

                        <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                            role="alert" style="display:none" id="notificacion">
                        </div>

                        <input type="hidden" name="dui" id="dui">
                        <div class="row py-3">
                            <div class="col-xl-2 fa fa-check text-success fa-3x mr-1"></div>
                            <div class="col-xl-9 text-black">
                                <h3 class="font-17 text-justify font-weight-bold">
                                    Nota: Los cambios que se realizaran son debidos a inconsistensitencias del reloj
                                </h3>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-xl-2 p-1">
                            </div>
                            <div class="col-xl-6 p-1">
                                <label for="mes">Entrada o Salida</label>
                                <select id="mod" name="mod" class="form-control select2 asisMen" style="width: 100%"
                                    required>
                                    <option value="">Seleccione</option>
                                    <option value="1">Entrada</option>
                                    <option value="2">Salida</option>

                                </select>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-xl-6 p-1">
                                <button type="button"  class="btn p-1 btn-light waves-effect waves-light btn-block font-24" id='guardar_registro'
                                    onClick="submitForm('#AsisMensual','#notificacion')">
                                    <i class="mdi mdi-check mdi-16px"></i> Enviar
                                </button>
                            </div>
                            <div class="col-xl-6 p-1">
                                <button type="reset" class="btn btn-light p-1 waves-light waves-effect btn-block font-24"
                                    onclick="AsisMenSubmit()">
                                    <i class="mdi mdi-block-helper mdi-16px"></i>
                                    Cancelar
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal-->
    <!--Modal para generar reporte de la asistencia mensual-->

    <div class="row">
        <div class="col-xl-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                        <li class="breadcrumb-item active">Lista de Marcaje</li>
                    </ol>
                </div>
                <h4 class="page-title">&nbsp;</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card-box">
                <div class="row py-2">
                    <div class="col-lg-10 order-first">
                        <h3>
                            Modificación de Marcaje
                        </h3>
                        <div class="row my-1">
                            <div class="col-xl-4">
                                <label for="depto">Mes</label>
                                <select id="mes_modificacion" class="form-control select2" style="width: 100%" required>

                                    <option value="selected" selected>Seleccione</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                                </select>
                            </div>

                            <div class="col-xl-4">
                                <label for="depto">Año</label>
                                <select id="anio_modificacion" class="form-control select2" style="width: 100%" required>

                                    <option value="selected" selected>Seleccione</option>
                                    @foreach ($años as $item)
                                        <option value="{{ $item->año }}">{{ $item->año }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-2 text-right order-last">

                    </div>

                </div>
                <table id="reloj_cambios" class="table" style="width: 100%;">
                    <thead>
                        <tr>

                            <th data-priority="3">Nombre</th>
                            <th data-priority="3" class="col-sm-1 text-center">Dui</th>
                            <th data-priority="3" class="col-sm-1 text-center">Fecha</th>
                            <th data-priority="3" class="col-sm-2 text-center">Entrada</th>
                            <th data-priority="3" class="col-sm-2 text-center">Salida</th>
                            <th data-priority="1" class="col-sm-1 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>



                    </tbody>
                </table>

            </div> <!-- end card-box -->
        </div> <!-- end col -->
    </div>
@endsection


@section('plugins')
    <link href="{{ asset('template-admin/dist/assets/libs/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.css') }}"
        rel="stylesheet" />
@endsection

@section('plugins-js')
    <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/select2/select2.min.js') }}"></script>


    <script src="{{ asset('js/scripts/configuracion.js') }}"></script>
    <script src="{{ asset('js/licencias/modificacionReloj.js') }}"></script>
    <script src="{{ asset('js/licencias/http.js') }}"></script>


    <script>
        $(
            function() {
                $('.select2').select2();
            });
    </script>
@endsection
