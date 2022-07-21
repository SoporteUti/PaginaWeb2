@extends('layouts.admin')

@section('content')
    @if (!is_null(auth()->user()->empleado) and
        \Illuminate\Support\Facades\DB::table('permisos')->where('jefatura', auth()->user()->empleado)->exists())
        <!--modal paraaceptar -->
        <div id="modalAceptar" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
            aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myCenterModalLabel">
                            <i class="fa fa-check mdi-24px" style="margin: 0px;"></i> Aceptar
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form action="{{ route('jf/aceptar') }}" method="POST" id="cancelarModal">
                        @csrf
                        <div class="modal-body">
                            <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                                role="alert" style="display:none" id="notificacion1">
                            </div>
                            <input type="hidden" name="_id" id="aceptar_id">
                            <div class="row py-3">
                                <div class="col-xl-2 fa fa-check text-success fa-4x mr-1"></div>
                                <div class="col-xl-9 text-black">
                                    <h3 class="font-17 text-justify font-weight-bold">
                                        Nota: Se aceptara esta licencia,
                                        ¿Desea continuar?
                                    </h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6 p-1">
                                    <button type="submit"
                                        class="btn p-1 btn-light waves-effect waves-light btn-block font-24">
                                        <i class="mdi mdi-check mdi-16px"></i>
                                        Si
                                    </button>
                                </div>
                                <div class="col-xl-6 p-1">
                                    <button type="reset"
                                        class="btn btn-light p-1 waves-light waves-effect btn-block font-24"
                                        data-dismiss="modal">
                                        <i class="mdi mdi-block-helper mdi-16px" aria-hidden="true"></i>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal-->
        <!--Modal para dar alta fin-->

        <!--MODAL ACEPTAR CONSTANCIA-->
        <div id="modalAceptarConst" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
            aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myCenterModalLabel">
                            <i class="fa fa-check mdi-24px" style="margin: 0px;"></i> Aceptar
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <form action="{{ route('jf/aceptar') }}" method="POST" id="cancelarModal">
                        @csrf
                        <div class="modal-body">
                            <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                                role="alert" style="display:none" id="notificacion1">
                            </div>
                            <input type="hidden" name="_id" id="aceptarr_id">
                            <div class="row py-3">
                                <div class="col-xl-2 fa fa-check text-success fa-4x mr-1"></div>
                                <div class="col-xl-9 text-black">
                                    <h3 class="font-17 text-justify font-weight-bold">
                                        Nota: Se aceptara esta Constancia olvido de Marcaje,
                                        ¿Desea continuar?
                                    </h3>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6 p-1">
                                    <button type="submit"
                                        class="btn p-1 btn-light waves-effect waves-light btn-block font-24">
                                        <i class="mdi mdi-check mdi-16px"></i>
                                        Si
                                    </button>
                                </div>
                                <div class="col-xl-6 p-1">
                                    <button type="reset"
                                        class="btn btn-light p-1 waves-light waves-effect btn-block font-24"
                                        data-dismiss="modal">
                                        <i class="mdi mdi-block-helper mdi-16px" aria-hidden="true"></i>
                                        No
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal-->
        <!--FIN DE MODAL ACEPTAR CONSTANCIA-->

        <div id="modalObservaciones" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog"
            aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id="myCenterModalLabel">
                            <i class="fa fa-eye mdi-36px" style="margin: 0px;"></i> Observaciones
                        </h3>
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    </div>
                    <div class="modal-body">
                        <div class="container-fluid py-2">
                            <table style="width: 100%" class="table" id="obs-table">
                                <thead>
                                    <tr>
                                        <th>Fecha</th>
                                        <th>Procedimiento</th>
                                        <th>Observaciones</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <!--MODAL CONSTANCIA DE OLVIDO DE MARCAJE-->
        <!-- inicio Modal de registro -->
        <div class="modal fade bs-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel"
            id="modalConstancia" tabindex="-1">
            <div class="modal-dialog modal-lg-8" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id=" exampleModalLongTitle"><i class="icon-notebook mdi-36px"></i> Const.
                            Olvido de Marcaje</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="registroFormC" action="{{ route('jf/observacionConst') }}" method="POST">
                        @csrf

                        <div class="modal-body">
                            <input type="hidden" id="idPermisoC" name="_id" />
                            <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                                role="alert" style="display:none" id="notificacionC">
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Nota: <code>* Campos Obligatorio</code></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="">Nombre <code>*</code></label>
                                        <input type="text" class="form-control" value="" autocomplete="off"
                                            placeholder="Digite el nombre" id="nombreC" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="">Apellido <code>*</code></label>
                                        <input type="text" class="form-control" value="" autocomplete="off"
                                            placeholder="Digite el apellido" id="apellidoC" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <!--para el campo fecha-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="fecha_de_uso">Fecha<code>*</code></label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                            <input type="date" class="form-control" tyle="width: 100%;"
                                                id="fecha" readonly>
                                        </div>
                                    </div>
                                </div>
                                <!--fin del campo fecha-->
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="exampleInputNombre">Marcaje de:<code>*</code></label>
                                        <select class="form-control select2" style="width: 100%" data-live-search="true"
                                            data-style="btn-white" id="marcaje">
                                            <option value="">Seleccione</option>
                                            <option value="Entrada">Entrada</option>
                                            <option value="Salida">Salida</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">

                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="fecha_de_presentacion">Hora <code>*</code></label>
                                        <div class="input-group">
                                            <div class="input-group-append" style="width: 100%;">
                                                <span class="input-group-text"><i
                                                        class=" mdi mdi-account-clock "></i></span>
                                                <input type="time" class="form-control" style="width: 100%;"
                                                    id="hora" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="exampleInputNombre">Justificación<code>*</code></label>
                                        <textarea value=" " class="form-control summernote-config" id="justificacionConst" rows="6" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="observaciones_jefatura_ocultar">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="observacionesConst">Observaciones </label>
                                        <textarea value=" " class="form-control summernote-config" name="observaciones_jefatura_constancia"
                                            rows="4"></textarea>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban"
                                    aria-hidden="true"></i> Cerrar</button>
                            <button type="button" class="btn btn-primary" id='guardar_registro_constancia'
                                onClick="submitForm('#registroFormC','#notificacionC')">
                                <li class="fa fa-save"></li> Guardar
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
        <!--fin modal de registro-->
        <!--FIN DE MODAL CONSTANCIA DE OLVIDO DE MARCAJE-->

        <!-- inicio Modal de registro -->
        <div class="modal fade bs-example-modal-lg" role="dialog" aria-labelledby="myLargeModalLabel"
            id="modalRegistro" tabindex="-1">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" id=" exampleModalLongTitle"><i class="icon-notebook mdi-36px"></i>
                            Licencia</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form id="registroForm" action="{{ route('jf/observacion') }}" method="POST">
                        @csrf

                        <div class="modal-body">
                            <input type="hidden" id="idPermiso" name="_id" />
                            <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                                role="alert" style="display:none" id="notificacion">
                            </div>
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label>Nota: <code>* Campos Obligatorio</code></label>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="">Nombre </label>
                                        <input type="text" class="form-control" value="" autocomplete="off"
                                            placeholder="Digite el nombre" id="nombre" readonly>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="">Apellido </label>
                                        <input type="text" class="form-control" value="" autocomplete="off"
                                            placeholder="Digite el correo" id="apellido" readonly>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label for="tipo_permiso">Tipo de permiso </label>
                                        <select name="tipo_de_permiso" class="form-control select2" style="width: 100%"
                                            data-live-search="true" data-style="btn-white" id="tipo_permiso"
                                            name="tipo_permiso" readonly>
                                            <option value="">Seleccione</option>
                                            <option value="LC/GS">L.C./G.S.</option>
                                            <option value="LS/GS">L.S./G.S.</option>
                                            <option value="INCAP">INCAP</option>
                                            <option value="L OFICIAL">L.OFICIAL</option>
                                            <option value="T COMP">T.COMP.</option>
                                            <option value="CITA MEDICA">CITA MEDICA</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label for="tipo_representante">Representantes </label>
                                        <select name="representante" class="form-control select2" style="width: 100%"
                                            data-style="btn-white" id="tipo_representante" readonly>
                                            <option value="">Seleccione</option>
                                            <option value="C.S.U">C.S.U</option>
                                            <option value="AGU">AGU</option>
                                            <option value="J.D">J.D</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label for="hora_anual">Horas Disponible Año</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend" style="width: 100%;">
                                                <span class="input-group-text" id="basic-addon1">
                                                    <i class="mdi mdi-clock-outline"></i>
                                                </span>
                                                <input type="text" name="" value="Ilimitado"
                                                    class="form-control" style="width: 100%" id="hora_anual" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label for="hora_disponible">Horas Disponible Mes</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend" style="width: 100%;">
                                                <span class="input-group-text"><i
                                                        class="mdi mdi-clock-outline"></i></span>
                                                <input type="text" value="Ilimitado" name="hora_disponible"
                                                    class="form-control " style="width: 100%" id="hora_mensual" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="fecha_de_uso">Fecha de Uso </label>
                                        <div class="input-group">
                                            <div class="input-group-append">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                            </div>
                                            <input type="date" name="fecha_de_uso" class="form-control"
                                                tyle="width: 100%;" id="fecha_de_uso" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="fecha_de_presentacion">Fecha de Presentación </label>
                                        <div class="input-group">
                                            <div class="input-group-append" style="width: 100%;">
                                                <span class="input-group-text"><i class="mdi mdi-calendar"></i></span>
                                                <input type="text" name="fecha_de_presentación" class="form-control"
                                                    readonly style="width: 100%;" id="fecha_de_presentacion">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label for="hora_inicio">Hora Inicio </label>
                                        <div class="input-group">
                                            <div class="input-group-append" style="width: 100%;">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="mdi mdi-clock-outline"></i></span>
                                                <input type="time" name="hora_inicio" class="form-control"
                                                    style="width: 100%" id="hora_inicio" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="form-group">
                                        <label for="hora_final">Hora Final </label>
                                        <div class="input-group">
                                            <div class="input-group-prepend" style="width: 100%;">
                                                <span class="input-group-text" id="basic-addon1"><i
                                                        class="mdi mdi-clock-outline"></i></span>
                                                <input type="time" name="hora_final" class="form-control"
                                                    style="width: 100%" id="hora_final" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="hora_actuales">Horas Utilizar</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend" style="width: 100%;">
                                                <span class="input-group-text"><i
                                                        class="mdi mdi-clock-outline"></i></span>
                                                <input type="text" value="Ilimitado" name="hora_actuales"
                                                    class="form-control" style="width: 100%" id="hora_actuales" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="justificacion">Justificación </label>
                                        <textarea value=" " class="form-control summernote-config" name="justificación" id="justificacion"
                                            rows="4" readonly></textarea>
                                    </div>
                                </div>
                                <div class="col-xl-6">
                                    <div class="form-group">
                                        <label for="observaciones">Observaciones </label>
                                        <textarea value=" " class="form-control summernote-config" name="observaciones" id="observaciones"
                                            rows="4" readonly></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="observaciones_jefatura">
                                <div class="col-xl-12">
                                    <div class="form-group">
                                        <label for="observaciones">Observaciones Jefatura <code>*</code></label>
                                        <textarea value=" " class="form-control summernote-config" name="observaciones_jefatura" rows="4"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban"
                                    aria-hidden="true"></i> Cerrar</button>
                            <button type="button" class="btn btn-primary" id='guardar_registro_lic'
                                onClick="submitForm('#registroForm','#notificacion')">
                                <li class="fa fa-save"></li> Guardar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--fin modal de registro-->

        <!-- start page title -->
        <div class="row">
            <div class="col-xl-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                            <li class="breadcrumb-item active">Jefatura</li>
                        </ol>
                    </div>
                    <h4 class="page-title">&nbsp;</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row py-2">
                        <div class="col order-first">
                            <h3>
                                Licencias Jefatura
                            </h3>
                        </div>
                        <div class="col-lg-1 order-last">
                        </div>
                    </div>
                    <table id="tableJefatura" class="table" style="width: 100%">
                        <thead>
                            <tr>
                                <th class="col-sm-2">Fecha de Uso</th>
                                <th class="col-xs-2">Empleado</th>
                                <th class="col-sm-1">Tipo</th>
                                <th class="col-sm-1">Hora Inicio</th>
                                <th class="col-sm-1">Hora final</th>
                                <th class="col-sm-2">Horas</th>
                                <th class="col-sm-2">Estado</th>
                                <th class="col-sm-1 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($permisos as $item)
                                <tr>
                                    <th class="align-middle ">
                                        {{ Carbon\Carbon::parse($item->fecha_uso)->format('d/m/Y') }}</th>
                                    <td class="align-middle ">{{ $item->nombre . ' ' . $item->apellido }}</td>
                                    <td class="align-middle "><span
                                            class="badge badge-primary">{{ $item->tipo_permiso }}</span></td>

                                    @if ($item->olvido == 'Entrada')
                                        <td class="align-middle ">{{ date('H:i', strtotime($item->hora_inicio)) }}</td>
                                        <td class="align-middle ">{{ date('H:i', strtotime($item->hora_final)) }}</td>
                                        <td class="align-middle ">{{ date('H:i', strtotime($item->hora_final)) }}</td>

                                        @if ($item->estado == 'Aceptado')
                                            <td class="align-middle "><span
                                                    class="badge badge-success">{{ $item->estado }}</span></td>
                                        @elseif($item->estado == 'Enviado a RRHH')
                                            <td class="align-middle "><span class="badge badge-danger">Pendiente de
                                                    Aceptación RRHH</span></td>
                                        @else
                                                @if($item->estado == 'Observaciones de Jefatura')
                                                <td class="align-middle "><span class="badge badge-danger">Pendiente de
                                                    Correción</span></td>
                                                    @elseif($item->estado == 'Observaciones de Jefatura')
                                                    <td class="align-middle "><span class="badge badge-danger">{{$item->estado}}</span></td>
                                                    @else
                                                    <td class="align-middle "><span class="badge badge-secondary">Pendiente de
                                                        Aceptación Jefatura</span></td>
                                                    @endif
                                        @endif

                                        <!--PARA LOS BOTONES-->
                                        <td class="align-middle ">
                                            <div class="row">
                                                <div class="col text-center">

                                                    <div class="btn-group" role="group">
                                                        <button title="Ver Datos" class="btn btn-outline-primary btn-sm"
                                                            value="{{ $item->permiso }}" onclick="observaciones(this)">
                                                            <i class="fa fa-eye font-16 my-1" aria-hidden="true"></i>
                                                        </button>

                                                        <button title="Agregar Observacion"
                                                            class="btn btn-outline-primary btn-sm"
                                                            value="{{ $item->permiso }}" onclick="verDatosConst(this)">
                                                            <i class="fa fa-file-alt font-16 my-1 mx-0"
                                                                aria-hidden="true"></i>
                                                        </button>

                                                        <button title="Aceptar Const. olvido"
                                                            class="btn btn-outline-success btn-sm"
                                                            @if ($item->estado === 'Enviado a Jefatura') value="{{ $item->permiso }}" onclick="aceptarConst(this)" @else disabled @endif>
                                                            <i class="fa fa-check font-16 my-1" aria-hidden="true"></i>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!--FIN DE PARA LOS BOTONES-->
                                    @elseif ($item->olvido == 'Salida')
                                        <td class="align-middle ">{{ date('H:i', strtotime($item->hora_final)) }}</td>
                                        <td class="align-middle ">{{ date('H:i', strtotime($item->hora_inicio)) }}</td>
                                        <td class="align-middle ">{{ date('H:i', strtotime($item->hora_final)) }}</td>
                                        @if ($item->estado == 'Aceptado')
                                            <td class="align-middle "><span
                                                    class="badge badge-success">{{ $item->estado }}</span></td>
                                        @elseif($item->estado == 'Enviado a RRHH')
                                            <td class="align-middle "><span class="badge badge-danger">Pendiente de
                                                    Aceptación RRHH</span></td>
                                        @else
                                            <td class="align-middle "><span class="badge badge-secondary">Pendiente de
                                                    Aceptación Jefatura</span></td>
                                        @endif

                                        <!--PARA LOS BOTONES-->
                                        <td class="align-middle ">
                                            <div class="row">
                                                <div class="col text-center">

                                                    <div class="btn-group" role="group">
                                                        <button title="Ver Datos" class="btn btn-outline-primary btn-sm"
                                                            value="{{ $item->permiso }}" onclick="observaciones(this)">
                                                            <i class="fa fa-eye font-16 my-1" aria-hidden="true"></i>
                                                        </button>

                                                        <button title="Agregar Observacion"
                                                            class="btn btn-outline-primary btn-sm"
                                                            value="{{ $item->permiso }}"
                                                            onclick=" verDatosConst(this)">
                                                            <i class="fa fa-file-alt font-16 my-1 mx-0"
                                                                aria-hidden="true"></i>
                                                        </button>

                                                        <button title="Aceptar Const. olvido"
                                                            class="btn btn-outline-success btn-sm"
                                                            @if ($item->estado === 'Enviado a Jefatura') value="{{ $item->permiso }}" onclick="aceptarConst(this)" @else disabled @endif>
                                                            <i class="fa fa-check font-16 my-1" aria-hidden="true"></i>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                        <!--FIN DE PARA LOS BOTONES-->
                                    @else
                                        <td class="align-middle ">{{ date('H:i', strtotime($item->hora_inicio)) }}</td>
                                        <td class="align-middle ">{{ date('H:i', strtotime($item->hora_final)) }}</td>
                                        <td class="align-middle ">
                                            {{ Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_inicio)->diffAsCarbonInterval(Carbon\Carbon::parse($item->fecha_uso . 'T' . $item->hora_final)) }}
                                        </td>
                                        @if ($item->estado == 'Aceptado')
                                            <td class="align-middle "><span
                                                    class="badge badge-success">{{ $item->estado }}</span></td>
                                        @elseif($item->estado == 'Enviado a RRHH')
                                            <td class="align-middle "><span class="badge badge-danger">Pendiente de
                                                    Aceptación RRHH</span></td>
                                        @else
                                            <td class="align-middle "><span class="badge badge-secondary">Pendiente de
                                                    Aceptación Jefatura</span></td>
                                        @endif
                                        <td class="align-middle ">
                                            <div class="row">
                                                <div class="col text-center">

                                                    <div class="btn-group" role="group">
                                                        <button title="Ver Datos" class="btn btn-outline-primary btn-sm"
                                                            value="{{ $item->permiso }}" onclick="observaciones(this)">
                                                            <i class="fa fa-eye font-16 my-1" aria-hidden="true"></i>
                                                        </button>

                                                        <button title="Agregar Observacion"
                                                            class="btn btn-outline-primary btn-sm"
                                                            value="{{ $item->permiso }}" onclick="verDatos(this)">
                                                            <i class="fa fa-file-alt font-16 my-1 mx-0"
                                                                aria-hidden="true"></i>
                                                        </button>
                                                        <button title="Aceptar Licencia"
                                                            class="btn btn-outline-success btn-sm"
                                                            @if ($item->estado === 'Enviado a Jefatura') value="{{ $item->permiso }}" onclick="aceptar(this)" @else disabled @endif>
                                                            <i class="fa fa-check font-16 my-1" aria-hidden="true"></i>
                                                        </button>

                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div> <!-- end card-box -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->
    @else
        <div class="row m-3">
            <div class="col-xl-12">
                <div class="card-box p-2 border">
                    <p> <i class="fa fa-info-circle"></i> No es posible cargar la información perteneciente a <strong>
                            {{ auth()->user()->name }} </strong>.</p>
                    <label> A continuación se detallan las posibles causas: </label>
                    <ul>
                        <li>El Usuario no se encuentra vinculado con ningun <strong>Empleado</strong> registrado en el
                            sistema.</li>
                        <li>El Usuario no es <strong>Jefe</strong>.</li>
                    </ul>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('plugins')
    <link href="{{ asset('template-admin/dist/assets/libs/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('template-admin/dist/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}"
        rel="stylesheet" />
    <style>

    </style>
@endsection

@section('plugins-js')
    <!-- Bootstrap Select -->
    <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}">
    </script>
    <script src="{{ asset('js/scripts/configuracion.js') }}"></script>
    <script src="{{ asset('js/licencias/calcularHoras.js') }}"></script>
    <script src="{{ asset('js/scripts/data-table.js') }}"></script>
    <script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/lang/summernote-es-ES.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}">
    </script>
    <script src="{{ asset('js/licencias/jefatura.js') }}"></script>
@endsection
