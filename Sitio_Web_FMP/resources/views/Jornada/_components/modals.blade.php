{{--  Modal para mostrar el detalle de la Jornada  --}}
<div class="modal fade" id="modalView" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="lead"> <i class="fa fa-info-circle"></i> Detalle Jornada </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="col-12 col-sm-12">

                <span class="float-right">
                    <p class="lead" style="font-size: 13px;">Fecha de Registro: <span class="badge badge-dark" id="fechaRegistroDetalle"></span></p>
                </span>
                <br>

                {{--  <div class="card-box">
                    <h4 class="header-title mb-4">Información y Seguimiento</h4>  --}}

                    <ul class="nav nav-pills navtab-bg nav-justified mt-3">
                        <li class="nav-item">
                            <a href="#detalle" data-toggle="tab" aria-expanded="false" class="nav-link active">
                                <i class="fa fa-info-circle"></i> Detalle
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#seguimiento" data-toggle="tab" aria-expanded="true" class="nav-link">
                                <i class="fa fa-list-alt"></i> Seguimiento
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="detalle">
                            <table class="table table-hover table-sm" id="tableView">
                                <thead>
                                    <th>Dia</th>
                                    <th>Inicio</th>
                                    <th>Fin</th>
                                    <th>Total</th>
                                </thead>
                                <tbody id="bodyView">

                                </tbody>
                            </table>
                            <div id="rrNota">
                            </div>
                        </div>
                        <div class="tab-pane show" id="seguimiento">
                            <table class="table table-hover table-sm">
                                <thead>
                                    <th>Registro</th>
                                    <th>Proceso</th>
                                    <th>Observaciones</th>
                                    {{--  <th>Total</th>  --}}
                                </thead>
                                <tbody id="bodySeguimiento">

                                </tbody>
                            </table>
                        </div>
                    </div>
                {{--  </div>  --}}



            </div>
        </div>
    </div>
</div>

{{--  Modal para darle seguimiento a la Jornada  --}}
<div class="modal fade" id="modalProcedimiento" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="lead"> <i class="fa fa-check-circle"></i> Seguimiento para la Jornada </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formSeguimiento" action="{{ url('admin/jornada-procedimiento') }}" method="POST">
                <input type="hidden" name="jornada_id" id="jornada_id">
                <div class="modal-body">
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" role="alert" style="display:none" id="notificacion_seguimiento">
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label>Nota: <code>* Campos Obligatorio</code></label>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group">
                                <label for="tip">Proceso <span class="text-danger">*</span> </label>
                                <select class="form-group select2" data-live-search="true" data-style="btn-white" name="proceso" id="procesoSeguimiento" style="width: 100%;">
                                </select>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="FechaI">Observaciones</label>
                                <textarea type="text" class="form-control" name="observaciones" id="observaciones" placeholder="Ingrese las observaciones necesarias" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa fa-ban"  aria-hidden="true"></i> Cerrar</button>
                    <button type="button" class="btn btn-primary btn-sm" onClick="submitForm('#formSeguimiento','#notificacion')"><li class="fa fa-save"></li> Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{--  Modal para exportar a Excel las Jornadas  --}}
@hasanyrole('super-admin|Jefe-Academico|Recurso-Humano')
    <div id="modalExport" class="modal fade bs-example-modal-center" tabindex="-1"  role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myCenterModalLabel"><i class="fa fa-file-excel mdi-24px"></i> Exportar</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="frmExport" action="{{ route('admin.jornada.export') }}" method="POST">
                        @csrf
                        <div class="row py-3 text-center">
                            <div class="col-lg-2 fa fa-file-export text-success fa-4x"></div>
                            <div class="col-lg-10 text-black">
                                <h4 class="font-17 text-justify font-weight-bold">Información: Se exportaran todas las jornadas de los empleados tipo Académicos</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label for="periodo">Seleccione un Periodo <span class="text-danger">*</span> </label>
                                    <select class="form-control select2" style="width: 100%" data-live-search="true" data-style="btn-white" name="periodo">
                                        @foreach ($periodos as $item)
                                            @if(strcmp('Académico', $item->tipo)==0 || strcmp('Administrativo', $item->tipo)==0)
                                                <option value="{{ $item->id }}">{{ $item->tipo }} -> {{ $item->nombre }} / {{ date('d-m-Y', strtotime($item->fecha_inicio)) }} - {{ date('d-m-Y', strtotime($item->fecha_fin)) }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            @hasanyrole('super-admin|Recurso-Humano')
                                <div class="col-12">
                                    <div class="form-group">
                                    <label for="depto">Seleccione un Departamento <span class="text-danger">*</span> </label>
                                        <select class="form-control select2" style="width: 100%" data-live-search="true" data-style="btn-white" name="depto">
                                            @foreach ($deptos as $item)
                                                <option value="{{ $item->id }}">{!!$item->nombre_departamento!!}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            @endhasanyrole
                        </div>
                        <div class="row">
                            <button type="submit" class="btn p-1 btn-light waves-effect waves-light btn-block font-24 btn-block"> <i class="mdi mdi-check mdi-16px"></i>Exportar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endhasanyrole


<!-- inicio Modal de registro -->
@if(is_null($emp) || $emp->tipo_empleado=='Académico')
    <div class="modal fade" tabindex="-1" role="dialog" id="modalNewJonarda" tabindex="-1" aria-hidden="true" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title"><i class=" mdi mdi-account-badge-horizontal mdi-24px" aria-hidden="true" ></i> Jornada</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                </div>
                <form id="frmJornada"  action="{{ route('admin.jornada.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="_id" id="_id">
                    <input type="hidden" name="_idaux" id="_idaux">
                    <div class="modal-body">
                        <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" role="alert" style="display:none" id="notificacion_jornada"></div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label>Nota: <code>* Campos Obligatorio</code></label>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-between">
                            <div class="col-12 col-sm-12">
                                <div class="form-group">
                                    <input type="hidden" name="is_edited" id="is_edited" value="false" disabled>
                                    <input type="hidden" name="id_periodo" id="id_periodo_text" disabled>
                                    <label for="periodo" class="control-label">{{ 'Periodo' }} <span class="text-danger">*</span> </label>
                                    <select class="form-group select2" data-live-search="true" style="width: 100%" data-style="btn-white" name="id_periodo" id="id_periodo">
                                        <option value="">Seleccione un Periodo</option>
                                        @foreach ($periodos as $item)
                                            @if (@Auth::user()->hasRole('super-admin') || @Auth::user()->hasRole('Recurso-Humano'))
                                                <option value="{{ $item->id }}"> ({{ ucfirst($item->estado) }}) {{ $item->tipo }} -> {{ $item->nombre }} / {{ date('d-m-Y', strtotime($item->fecha_inicio)) }} - {{ date('d-m-Y', strtotime($item->fecha_fin)) }}</option>
                                            @elseif (@Auth::user()->hasRole('Jefe-Academico') || @Auth::user()->hasRole('Jefe-Administrativo') || @Auth::user()->hasRole('Docente'))
                                                @if (strcmp($item->estado, 'activo')==0)
                                                    <option value="{{ $item->id }}"> ({{ ucfirst($item->estado) }}) {{ $item->tipo }} -> {{ $item->nombre }} / {{ date('d-m-Y', strtotime($item->fecha_inicio)) }} - {{ date('d-m-Y', strtotime($item->fecha_fin)) }}</option>
                                                @endif
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-8">
                                <input type="hidden" name="id_emp" id="id_emp_text" disabled>
                                <div class="form-group">
                                    <label for="empleado" class="control-label">{{ 'Empleado' }} <span class="text-danger">*</span> </label>
                                    <select class="form-control select2" style="width: 100%" data-live-search="true" data-style="btn-white" name="id_emp" id="id_emp">
                                        <option value="">Seleccione un Empleado</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <div class="form-group">
                                    <label for="thoras" class="control-label">{{ 'Horas' }} <span class="text-danger"></span></label>
                                    <input type="text" id="auxJornada" class="form-control total-horas" for="auxJornada" readonly="readonly" value="0">
                                </div>
                            </div>
                            <div class="col-12 col-sm-2">
                                <div class="form-group">
                                    <label for="thoras" class="control-label text-primary">{{ 'Libres' }} <span class="text-danger"></span></label>
                                    <input type="text" id="_horas" class="form-control" for="_horas" readonly="readonly" value="0"></input>
                                </div>
                            </div>
                        </div>
                        <div class="row" id="jornada-div">
                            <div class="col-12">
                                <h5 class="mb-3">Detalle de la Jornada
                                    <span class="float-right">
                                        <button type="button" class="btn btn-sm btn-primary" name="btnNewRow" id="btnNewRow"> <i class="fa fa-plus"></i> </button>
                                    </span>
                                </h5>
                                <div id="days-table"></div>
                            </div>
                        </div>

                        @if (@Auth::user()->hasRole('super-admin') || @Auth::user()->hasRole('Recurso-Humano'))
                            <div class="row" style="padding-top: 15px;" >
                                <div class="col-12 col-sm-12" id="nota_div" style="display:none">
                                    <div class="form-group">
                                        <label for="tnota" class="control-label">{{ 'Nota' }} <span class="text-danger">*</span> </label>
                                        <input type="text" class="form-control" name="observaciones" id="observaciones" placeholder="Ingrese una Nota de Modificación a esté registro" ></input>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" data-dismiss="modal"><i class="fa fa-ban"  aria-hidden="true"></i> Cerrar</button>
                        <button type="submit" class="btn btn-primary btn-sm" id="btnSaveJornada"><li class="fa fa-save"></li> Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endif


{{--  Modal para notificar al recurso humano --}}
@hasanyrole('Jefe-Academico|Jefe-Administrativo')
    <div id="modalEmail" class="modal fade bs-example-modal-center" tabindex="-1"  role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myCenterModalLabel"><i class="fa fa-envelope-square mdi-24px"></i> Correo Electrónico</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form id="frmExport" action="{{ route('admin.jornada.notificacion') }}" method="POST">
                        @csrf
                        <div class="row py-3 text-center">
                            <div class="col-lg-2 fa fa-envelope-square text-primary fa-4x"></div>
                            <div class="col-lg-10 text-black">
                                <h4 class="font-17 text-justify font-weight-bold">Información: Se notificara de Jornadas completadas a Recursos Humanos</h4>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 mt-2">
                                <div class="form-group">
                                    <label for="periodo">Seleccione un Periodo <span class="text-danger">*</span> </label>
                                    <select class="custom-select" name="periodo" required>
                                        @foreach ($periodos as $item)
                                            @if (strcmp('activo', $item->estado)==0)
                                                <option value="{{ $item->id }}">{{ $item->tipo }} -> {{ $item->nombre }} / {{ date('d-m-Y', strtotime($item->fecha_inicio)) }} - {{ date('d-m-Y', strtotime($item->fecha_fin)) }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <button type="submit" class="btn p-1 btn-light waves-effect waves-light btn-block font-24 btn-block"> <i class="fa fa-paper-plane"></i>  Notificar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endhasanyrole
