@extends('Pagina/baseOnlyHtml')

@section('header')
<!-- Summernote css -->
    <link href="{{ asset('css/summernote-bs4.css') }}" rel="stylesheet" />
    <!-- Plugin css -->
    <link href="{{ asset('css/fullcalendar.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('footer')
    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminFinanciera-Informacion|Pagina-AdminFinanciera-Colecturia|Pagina-Admin|super-admin'):@Auth::check())
    <script src="{{ asset('js/scripts/http.min.js') }}"></script><!--Este es el script que se utiliza para enviar post con un ajax generico-->
    @endif
    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminFinanciera-Informacion|Pagina-Admin|super-admin'):@Auth::check())
    <script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('js/summernote.config.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/lang/summernote-es-ES.js') }}"></script>
    @endif
    <!-- Calendar init -->
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/fullcalendar.min.js') }}"></script>  
    <script src="{{ asset('js/locale/es.js') }}"></script>  
    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminFinanciera-Colecturia|Pagina-Admin|super-admin'):@Auth::check())
    <script src="{{ asset('js/scripts/admonFinanciero.js') }}"></script>
    <script>calendarConfig('{{route('HorarioCole')}}');</script>
    @endif
    @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-AdminFinanciera-Colecturia|Pagina-Admin|super-admin'))
    <script>$('#calendar').fullCalendar({events:'{{route('HorarioCole')}}',height: 600,timeFormat: 'hh:mm t',});</script>        
    @endif
@endsection

@section('container')
<div class="wrapper">
    <div class="container-fluid">

        <!-- start page title -->
        <div class="page-title-box color-boton py-2 rounded">
            <h2 class="page-title text-white">Facultad Multidisciplinaria Paracentral</h2>
        </div> 
        <div class="my-4"></div>
        <!-- end page title -->           

        <div class="row">
            <div class="col-xl-12">   
                <div class="card-box">
                    <h3 class="text-center">Administración Financiera</h3>
                    <div class="row">
                        <!--
                        <div class="col-xl-12"> 

                            <h4 class="text-center">Personal</h4>

                            <p class="mb-1 font-weight-bold font-15 text-center">Administradora Financiera</p>
                            <p class="text-muted font-10 text-justify text-center ">
                                Licda. María Isaura Esperanza Guardado
                            </p>  
                            
                            <p class="mb-1 font-weight-bold font-15 text-center">Gestor de Compra</p>
                            <p class="text-muted font-10 text-justify text-center">
                                Msc. Delmy Elizabeth Jovel de Jovel
                            </p>  

                            <p class="mb-1 font-weight-bold font-15 text-center">Colectora</p>
                            <p class="text-muted font-10  text-justify text-center">
                                Licda. Ingrid Yamileth Cañas
                            </p>  

                            <p class="mb-1 font-weight-bold font-15 text-center">Colaboradora</p>
                            <p class="text-muted font-10  text-justify text-center">
                                Licda. Evelyn Noemi Abarca Sandoval
                            </p>

                            <p class="mb-1 font-weight-bold font-15 text-center">Horario de Atención</p>
                            <p class="text-muted font-10  text-justify text-center">
                                Lunes a viernes de 8:00 a.m. A 12:00 p.m. y 1:00 p.m. a 4:00 p.m.
                            </p>   

                            <p class="mb-1 font-weight-bold font-15 text-center">Teléfono</p>
                            <p class="text-muted font-10  text-justify text-center">
                                2393-4752
                            </p>                                
                            
                            
                        </div> end colFin del codigo html anterior de informacion de finanaciera -->  
                        
                        <?php
                        $variableNoTocar = 'localizacion';
                        $localizacion ='financiera';
                        $contenido = App\Models\Pagina\ContenidoHtml::where($variableNoTocar,$localizacion)->first();
                        
                        ?>
                        @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminFinanciera-Informacion|Pagina-Admin|super-admin'):@Auth::check())                          
                        
                        <div class="col-xl-12">
                            <form action="{{ route('contenido', ['localizacion'=>$localizacion]) }}" method="POST"  
                                class="parsley-examples"  id="contenido{{$localizacion}}">
                                @csrf
                                <div class="alert alert-primary text-white py-1" 
                                        role="alert" style="display:none" id="notificacion{{$localizacion}}">                                               
                                </div>
                                <div class="row">
                                    <div class="col-xl-12">   
                                        <div class="form-group">                       
                                            <textarea value="" class="form-control summernote-config" name="contenido"  rows="10">
                                                @if ($contenido!=null)
                                                    {{$contenido->contenido}}
                                                @endif
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary waves-effect waves-light btn-block" 
                                                onclick="submitForm('#contenido{{$localizacion}}','#notificacion{{$localizacion}}')">
                                                <i class="fa fa-save fa-5 ml-3"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>  
                        
                        @endif
                        
                        @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-AdminFinanciera-Informacion|Pagina-Admin|super-admin'))
                        <div class="col-xl-12 py-2">
                        @if ($contenido!=null)
                        {!!$contenido->contenido!!}
                        @else 
                        <p class="p-2 border text-center" >No hay información para mostrar</p>      
                        @endif
                        </div>
                        
                        @endif
                        
                    </div> 
                </div> 
            </div>
        </div>

      

        <div class="row">
            <div class="col-xl-12">
                <div class="card-box">
                    <h3>Horarios de Colecturia</h3>
                    <div id="calendar" ></div>
                </div>
            </div>
            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminFinanciera-Colecturia|Pagina-Admin|super-admin'):@Auth::check())               
            <div id="myModalRegistro" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myCenterModalLabel">
                                <i class="mdi mdi-calendar-multiselect mdi-24px"></i> Horario Colecturia</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">        
                            <div class="row">
                                <div class="col-xl-12">
                                <label>Nota: <code>* Campos Obligatorio</code></label>
                                </div>
                            </div>                                
                            <div class="tab-content">
                            <div class="alert alert-primary text-white" role="alert" style="display:none" id="notificacion"></div>                                        
                            <form method="POST" 
                            action="{{ route('HorarioColeR') }}" 
                            class="parsley-examples"
                            enctype="multipart/form-data" id="registro">
                                @csrf
                                <div class="row">
                                    <input type="hidden" id="_id" name="_id">                                    
                                </div>      
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Título <code>*</code></label>
                                            <div>
                                                <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título (Obligatorio)">
                                            </div>
                                        </div>
                                    </div>                                   
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Hora <code>*</code></label>
                                            <div>
                                                <input type="time" class="form-control" id="hora1" name="hora_inicio" placeholder="">                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>   
                                <div class="row">
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Fecha Inicio <code>*</code></label>
                                            <div>
                                                <input type="date" class="form-control" id="fecha1" name="fecha_inicio">                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-6">
                                        <div class="form-group">
                                            <label>Fecha Final <code>*</code></label>
                                            <div>
                                                <input type="date" class="form-control" id="fecha2" name="fecha_final">   
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>  
                                <div class="form-group mb-0 row">
                                    <div class="col order-first">
                                        <button type="button" class="btn btn-primary waves-effect waves-light mr-1" 
                                            id="guardar"><i class="fa fa-save font-14"></i> Guardar
                                        </button>
                                        <button type="reset" class="btn btn-light waves-effect waves-light" data-dismiss="modal">
                                            <i class="fa fa-ban font-14" aria-hidden="true"></i> Cancelar
                                        </button>
                                    </div>
                                    <div class="col order-last d-flex justify-content-end">
                                        <button type="button" class="btn btn-light waves-effect waves-light mr-1"
                                            id="eliminar">
                                            <i class="mdi mdi-delete font-14"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </form>       
                            </div>
                        </div>                                    
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal -->
            <div id="modalInfo" class="modal fade bs-example-modal-center" tabindex="-1" 
                role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myCenterModalLabel">Información</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <div class="row ">
                                <div class="col-lg-2 dripicons-information text-info fa-5x"></div>
                                <div class="col-lg-10 text-black d-flex align-items-center">
                                    <h4 class="font-17 text-justify font-weight-bold align-center" id="informacion">
                                        Informacion: 
                                    </h4>
                                </div>
                                <input type="hidden" name="_id" id="_idEliminar">
                            </div>
                            <div class="row">
                                <div class="col-xl-6">
                                   
                                </div>
                                <div class="col-xl-6">
                                    <button type="reset" class="btn btn-light p-1 waves-light waves-effect btn-block font-24" data-dismiss="modal" >
                                        <i class="mdi mdi-door mdi-16px" aria-hidden="true"></i>
                                        Salir
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal --> 
            <div id="modalEliminar" class="modal fade bs-example-modal-center" tabindex="-1" 
                role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('HorarioBorrar') }}" method="POST" id="eliminarForm">
                                @csrf
                                <div class="row py-3">
                                    <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                                    <div class="col-lg-10 text-black">
                                        <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se elimina este registro de manera permanente, ¿Desea continuar?</h4>
                                    </div>
                                    <input type="hidden" name="_id" id="eliminarId">
                                </div>
                                <div class="row">
                                    <div class="col-xl-6">
                                        <button type="button" id="btnEliminar" 
                                            class="btn p-1 btn-light waves-effect waves-light btn-block font-24">
                                            <i class="mdi mdi-check mdi-16px"></i>
                                            Si
                                        </button>
                                    </div>
                                    <div class="col-xl-6">
                                        <button type="reset" class="btn btn-light p-1 waves-light waves-effect btn-block font-24" data-dismiss="modal" >
                                            <i class="mdi mdi-block-helper mdi-16px" aria-hidden="true"></i>
                                            No
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
            </div><!-- /.modal --> 
            @endif
        </div>
    </div> <!-- end container -->
</div> 
@endsection