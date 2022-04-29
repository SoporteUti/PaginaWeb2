@extends('layouts.admin')

@section('content')
<!-- Modal -->
<div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id=" exampleModalLongTitle">Agregar Horario</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="empleadoForm" action="" method="POST">
            <div class="modal-body">
                    @csrf
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" 
                        role="alert" style="display:none" id="notificacion">                                               
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="exampleInputUbicacion">Grupo</label>
                                <select class="custom-select" name="tipo_grupo">
                                    <option value="">Seleccione</option>
                                    <option value="Teórico">Teórico</option>
                                    <option value="Laboratorio">Laboratorio</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="exampleInputNumGrupo">Número de grupo</label>
                                <input type="number" class="form-control" name="numero_grupo" placeholder="Digite el numero">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="exampleInputDocente">Docente</label>
                                <select class="custom-select" name="id_empleado">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="exampleInputMateria">Materia</label>
                                <select class="custom-select" name="id_materia">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="exampleInputNombre">Cupo</label>
                                <input type="number" class="form-control" name="cupo" placeholder="Ingres el cupo">
                           
                            </div>
                        </div>
                       
                    </div>

                    <div class="row">
                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="exampleInputHora">Hora</label>
                                <select class="custom-select" name="id_hora">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-xl-6">
                            <div class="form-group">
                                <label for="exampleInputDias">Día</label>
                                <select class="custom-select" name="dias">
                                    <option value="">Seleccione</option>
                                    <option value="Lunes">Lunes</option>
                                    <option value="Martes">Martes</option>
                                    <option value="Miércoles">Miércoles</option>
                                    <option value="Jueves">Jueves</option>
                                    <option value="Viernes">Viernes</option>
                                    <option value="Sábado">Sábado</option>
                                </select>
                            </div>
                        </div>
                        
                    </div>

                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label for="exampleInputAula">Aula</label>
                                <select class="custom-select" name="id_aula">
                                    <option value="">Seleccione</option>
                                </select>
                            </div>
                        </div>
                    </div>


                   
                    

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-ban" aria-hidden="true"></i>Cerrar</button>
                <button type="button" class="btn btn-primary" onClick="submitForm('#empleadoForm','#notificacion')"><li class="fa fa-save"></li>Guardar</button>
            </div>
        </form>
      </div>
    </div>
  </div>
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box">
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                    <li class="breadcrumb-item active">Horarios de clase</li>
                </ol>
            </div>
            <h4 class="page-title">Creación de horarios de clases</h4>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-12">
        <div class="card-box">
            <div class="row">
                <div class="col-6">
                    <h3>
                        Horarios de clases Registrados
                    </h3>      
                </div>
                <div class="col-3">
                    <!-- Button trigger modal -->
                 <button type="button" title="Agregar Horario" style="margin-left: 450px;" class="btn btn-primary dripicons-plus" data-toggle="modal" data-target="#exampleModalCenter"></button>
                </div>
            </div>
            <table  class="table table-sm" id="table-horarios">
                <thead>
                <tr>
                    <th data-priority="1">Código</th>
                    <th data-priority="1">Materia</th>
                    <th data-priority="1">T</th>
                    <th data-priority="1">GRP</th>
                    <th data-priority="1">Cupo</th>
                    <th data-priority="1">Modalidad</th>
                    <th data-priority="1">Carrera</th>
                    <th data-priority="1">Horario</th>
                    <th data-priority="1">Días</th>
                    <th data-priority="1">Aula</th>
                    <th data-priority="1">Docente</th>
                    <th data-priority="1">Acciones</th>
                  
                </tr>
                </thead>
                <tbody>
                <tr>
                    <th>GOOG <span class="co-name">Google Inc.</span></th>
                    <td>597.74</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td><a href="" title="Editar Horario">
                        <button class="btn btn-outline-primary btn-sm"><i class="fa fa-edit fa-fw" aria-hidden="true"></i>
                        </button></a>
                        <a href="" title="Eliminar Horario">
                            <button class="btn btn-outline-primary btn-sm"><i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button></a>
                    </td>
               
                </tr>
                <tr>
                    <th>AAPL <span class="co-name">Apple Inc.</span></th>
                    <td>378.94</td>
                    <td>12:22PM</td>
                    <td>597.74</td>
                    <td>5.74 (1.54%)</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td><a href="" title="Editar Horario ">
                        <button class="btn btn-outline-primary btn-sm"><i class="fa fa-edit fa-fw" aria-hidden="true"></i>
                        </button></a>
                        <a href="" title="Eliminar Horario">
                            <button class="btn btn-outline-primary btn-sm"><i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button></a>
                    </td>
                </tr>
                <tr>
                    <th>AMZN <span class="co-name">Amazon.com Inc.</span></th>
                    <td>191.55</td>
                    <td>12:23PM</td>
                    <td>597.74</td>
                    <td>3.16 (1.68%)</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td><a href="" title="Editar Horario">
                        <button class="btn btn-outline-primary btn-sm"><i class="fa fa-edit fa-fw" aria-hidden="true"></i>
                        </button></a>
                        <a href="" title="Eliminar Horario">
                            <button class="btn btn-outline-primary btn-sm"><i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button></a>
                    </td>
                </tr>
                <tr>
                    <th>ORCL <span class="co-name">Oracle Corporation</span></th>
                    <td>31.15</td>
                    <td>12:44PM</td>
                    <td>597.74</td>
                    <td>1.41 (4.72%)</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td><a href="" title="Editar Horario">
                        <button class="btn btn-outline-primary btn-sm"><i class="fa fa-edit fa-fw" aria-hidden="true"></i>
                        </button></a>
                        <a href="" title="Eliminar Horario">
                            <button class="btn btn-outline-primary btn-sm"><i class="fas fa-trash-alt" aria-hidden="true"></i>
                        </button></a>
                    </td>
                  
                </tr>
                <tr>
                    <th>MSFT <span class="co-name">Microsoft Corporation</span></th>
                    <td>25.50</td>
                    <td>12:27PM</td>
                    <td>597.74</td>
                    <td>0.66 (2.67%)</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td><a href="" title="Editar Horario">
                        <button class="btn btn-outline-primary btn-sm"><i class="fa fa-edit fa-fw" aria-hidden="true"></i>
                        </button></a>
                        <a href="" title="Eliminar Horario">
                            <button class="btn btn-outline-primary btn-sm"><i class="fas fa-trash-alt" aria-hidden="true"></i>
                            </button></a>
                    </td>
                </tr>
                
                <tr>
                    <th>YHOO <span class="co-name">Yahoo! Inc.</span></th>
                    <td>15.81</td>
                    <td>12:25PM</td>
                    <td>0.11 (0.67%)</td>
                    <td>597.74</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td>597.74</td>
                    <td>12:12PM</td>
                    <td>14.81 (2.54%)</td>
                    <td><a href="" title="Editar Horario">
                        <button class="btn btn-outline-primary btn-sm"><i class="fa fa-edit fa-fw" aria-hidden="true"></i>
                        </button></a>
                    </td>
                </tr>
                
                
                
                </tbody>
            </table>

        </div> <!-- end card-box -->
    </div> <!-- end col -->
</div>
<!-- end row -->   
@endsection

@section('plugins-js')
<!-- Dashboard Init JS -->
<script src="{{ asset('template-admin/dist/assets/js/pages/dashboard.init.js') }}"></script>
<script>
    $(document).ready(function () {
        $('#table-horarios').DataTable({
          "language": {
              "decimal":        ".",
              "emptyTable":     "No hay datos para mostrar",
              "info":           "Del _START_ al _END_ (_TOTAL_ total)",
              "infoEmpty":      "Del 0 al 0 (0 total)",
              "infoFiltered":   "(Filtrado de todas las _MAX_ entradas)",
              "infoPostFix":    "",
              "thousands":      "'",
              "lengthMenu":     "Mostrar _MENU_ entradas",
              "loadingRecords": "Cargando...",
              "processing":     "Procesando...",
              "search":         "Buscar:",
              "zeroRecords":    "No hay resultados",
              "paginate": {
                "first":      "Primero",
                "last":       "Último",
                "next":       "Siguiente",
                "previous":   "Anterior"
              },
              "aria": {
                "sortAscending":  ": Ordenar de manera Ascendente",
                "sortDescending": ": Ordenar de manera Descendente ",
              }
            },
              "pagingType": "full_numbers",
              "lengthMenu":		[[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
		        	"iDisplayLength":	5,
        });  
      });
</script>
@endsection
