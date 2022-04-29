@extends('Pagina/baseOnlyHtml')

@section('header')
@if(@Auth::check()?@Auth::user()->hasRole('Pagina-Depto-PC|Pagina-Admin|super-admin'):@Auth::check())
    <!-- Summernote css -->
    <link href="{{ asset('css/summernote-bs4.css') }}" rel="stylesheet" />
    
    <!-- Este css se carga nada mas cuando esta logeado un usuario-->
    <link href="{{ asset('css/dropzone.min.css') }} " rel="stylesheet" type="text/css" />

@endif   
@endsection

@section('footer')

@if(@Auth::check()?@Auth::user()->hasRole('Pagina-Depto-PC|Pagina-Admin|super-admin'):@Auth::check())  
<script src="{{ asset('js/scripts/http.min.js') }}"></script>
<!-- Plugins js -->
<script src=" {{ asset('js/dropzone.min.js') }} "></script>
<!--Summernote js-->
<script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('js/summernote.config.min.js') }}"></script>
<script src="{{ asset('vendor/summernote/lang/summernote-es-ES.js') }}"></script>
<script src="{{ asset('js/scripts/http.min.js') }}"></script>
<script src=" {{ asset('js/scripts/complementario.js') }} "></script>
<script>
    function editarComplementario(id){$json = {!!json_encode($complementario)!!}.find(x => x.id==id);editar($json);}
</script>
@endif



<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v11.0" nonce="3YGowOpk"></script>    
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

        <div class="card-box"> 
            <div class="row">
                <div class="col-xl-8 px-3">
                    <div class="tab-content pt-0" id="v-pills-tabContent">
                        <div class="tab-pane fade active show" id="index" role="tabpanel">
                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-Depto-PC|Pagina-Admin|super-admin'):@Auth::check())
                            <form action="{{ route('contenido', ['localizacion'=>'complementarioIndex']) }}" method="POST"  
                                class="parsley-examples"  id="indexContenido">
                                @csrf
                                <div class="alert alert-primary text-white" 
                                        role="alert" style="display:none" id="notificacion">                                               
                                </div>
                                <div class="row py-1">
                                    <div class="col-xl-12">   
                                        <div class="form-group">                       
                                            <textarea value="" class="form-control summernote-config"  name="contenido"  >
                                                @if ($contenido!=null)
                                                    {{$contenido->contenido}}
                                                @endif
                                            </textarea>
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <div class="form-group">
                                            <button type="button" class="btn btn-primary waves-effect waves-light btn-block" 
                                                onclick="submitForm('#indexContenido','#notificacion')">
                                                <i class="fa fa-save fa-5 ml-3"></i> Guardar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>      
                            @endif
                            @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-Depto-PC|Pagina-Admin|super-admin'))
                            <div class="py-1">
                                @if ($contenido!=null)
                                    {!!$contenido->contenido!!}
                                @endif
                            </div>
                            @endif
                        </div>

                        <!--aqui va-->
                        @foreach ($complementario as $m)
                        <div class="tab-pane fade" id="{!!preg_replace('([^A-Za-z0-9])', 'l', $m->nombre)!!}" role="tabpanel">
                            <div class="btn-group" role="group">
                                <a class="nav-link btn btn-danger waves-effect width-md" href="#index"
                                    onclick="$('.nav-link').removeClass('active')" data-toggle="pill">
                                    <i class="mdi mdi-arrow-left-thick"></i> 
                                    Volver a Plan
                                </a>
                                
                                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-Depto-PC|Pagina-Admin|super-admin'):@Auth::check())                              
                                    <button class="btn btn-light waves-effect width-md" data-toggle="modal" data-target="#myModalPlan"
                                        onclick="editarComplementario({!!$m->id!!})">
                                        <i class="mdi mdi-file-document-edit mdi-16p"></i>
                                        Modificar
                                    </button>
                                    <form action="{{ route('estadoPlan') }}" method="POST" id="activarDesactivar"
                                     style="display: none;" class="parsley-examples" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name='_id' value="{!!base64_encode($m->id)!!}">
                                    </form>
                                    <button class="btn btn-light waves-effect width-md" onclick="submitActivarDesactivar(this,'#activarDesactivar')">
                                        {!!$m->estado?'<i class="mdi mdi-eye-off"></i> Desactivar':'<i class="mdi mdi-eye"></i> Activar'!!}
                                    </button>
                                    <button class="btn btn-light waves-effect width-md"  data-toggle="modal" data-target="#modalEliminar" onclick="eliminarPlan('{!!base64_encode($m->id)!!}')">
                                        <i class="mdi mdi-delete mdi-16px"></i> Eliminar
                                    </button>
                                @endif
                            </div>
                            <br>
                            <h3 class="py-3">{!!$m->nombre!!}</h3>     
                            <div class="table-responsive py-2 ">
                                <table class="table mb-0 table-bordered ">
                                    <tbody>
                                    <tr>
                                        <td><h5>Titulo a Obtener</h5><p>{!!$m->titulo!!}</p></td>
                                        <td><h5>Modalidad</h5><p>{!!$m->modalidad!!}</p></td>
                                        <td><h5>Duración</h5><p>{!!$m->duracion!!}</p></td>
                                    </tr>
                                    <tr>
                                        <td><h5>Dirigido a:</h5><p>{!!$m->dirigido!!}</p></td>
                                        <td>
                                        <h5>No. de Asignaturas</h5><p>{!!$m->numero_asignatura!!} Asignaturas</p>
                                        <h5>Unidades Valorativas</h5><p>{!!$m->unidades_valorativas!!} Unidades</p></td>
                                        <td><h5>Precio</h5><p>{!!$m->precio!!}</p></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>                       
                            {!!$m->contenido!!}
                            <div class="row">                                
                                <div class="col order-first">
                                </div>                               
                                
                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-Depto-PC|Pagina-Admin|super-admin'):@Auth::check())
                                <div class="col-lg-3 order-last">
                                    <button class="btn btn-block btn-info tex-left" 
                                        data-toggle="modal" data-target="#modalSubir{!!$m->id!!}">
                                        <div class="mdi mdi-upload mdi-16px text-center" > Subir PDF</div>
                                    </button>
                                </div>  
                                <div id="modalSubir{!!$m->id!!}" class="modal fade bs-example-modal-center" 
                                    tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" 
                                    aria-hidden="true" style="display: none;" >
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myCenterModalLabel">Zona para subir PDF</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                
                                                <form action="{{ route('Mpdf', ['localizacion'=>$m->nombre.$m->id]) }}" method="post"
                                                    class="dropzone dropzonepdf" >
                                                    @csrf                                 
                                                    <div class="dz-message needsclick">
                                                        <i class="h3 text-muted dripicons-cloud-upload"></i>
                                                        <h3>Suelta los archivos aquí o haz clic para subir.</h3>
                                                    </div>
                                                    <div class="dropzone-previews"></div>
                                                </form>
                                            </div>
                                        </div><!-- /.modal-content -->
                                    </div><!-- /.modal-dialog -->
                                </div><!-- /.modal-->
                                @endif
                            </div> 
                            <div class="row">
                                <?php
                                    $pdfs = \App\Models\Pagina\PDF::where('localizacion',$m->nombre.$m->id)->get();
                                ?>
                                
                                @if (count($pdfs)>0)
                                <div class="table-responsive my-1" id="listaPDF">
                                    <table class="table mb-0 border @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-Depto-PC|Pagina-Admin|super-admin'))
                                        table-striped @endif">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <h4>Malla Curricular y Formatos</h4>
                                                </th>
                                                <th class="col-sm-4">                                              
                                                </th>                             
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($pdfs as $item)
                                            <tr>
                                                <th class="text-nowrap align-middle" scope="row">
                                                    <p class="font-18">{!!$item->file!!}</p>
                                                </th>                                             
                                                                                
                                                <th class="align-middle ">
                                                    
                                                    <div class="btn-group" role="group">
                                                        <a class="btn btn-danger waves-effect width-lg mx-1"  href="{{ route('index') }}{!!'/files/pdfs/'.$m->nombre.$m->id.'/'.$item->file !!}" target="_blank"> 
                                                            <i class="mdi mdi-file-pdf mdi-24px mr-1"></i>Descargar
                                                        </a>
                                                        @if(@Auth::check()?@Auth::user()->hasRole('Pagina-Depto-PC|Pagina-Admin|super-admin'):@Auth::check())
                                                        <button type="buttom"  class="btn btn-light waves-effect width-md mx-1" data-toggle="modal" data-target="#modalEliminarPDF"
                                                            onclick="$('#eliminar').val({{$item->id}});$('#localizacion').val({{$item->nombre.$item->id}});"><i class="mdi mdi-delete mdi-24px"></i>  Eliminar
                                                        </button>  
                                                        @endif
                                                    </div>
                                                                                            
                                                </th>
                                                
                                            </tr>  
                                            @endforeach                                                              
                                        </tbody>
                                    </table>
                                </div> <!-- end table-responsive-->    
                                @endif
                            </div>
                        </div>
                        @endforeach
                        @if(@Auth::check()?@Auth::user()->hasRole('Pagina-Depto-PC|Pagina-Admin|super-admin'):@Auth::check())
                        <div id="modalEliminarPDF" class="modal fade bs-example-modal-center" tabindex="-1" 
                            role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('eliminarpdfmaestri') }}" method="POST">
                                            @csrf
                                            <div class="row py-3">
                                                <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                                                <div class="col-lg-10 text-black">
                                                    <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se elimina este registro de manera permanente, ¿Desea continuar?</h4>
                                                </div>
                                                <input type="hidden" name="_id" id="eliminar">                                                        
                                                <input type="hidden" name="localizacion" id="localizacion">
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <button type="submit" 
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
                        
                        <div id="modalEliminar" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <form action="{{ route('EliminarPlan') }}" method="POST">
                                        @csrf
                                        <div class="modal-body">
                                            <div class="row py-3">
                                                <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                                                <div class="col-lg-10 text-black">
                                                    <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se elimina este registro de manera permanente, ¿Desea continuar?</h4>
                                                </div>
                                                <input type="hidden" name="complementario" id="complementario">
                                            </div>
                                            <div class="row">
                                                <div class="col-xl-6">
                                                    <button type="submit" 
                                                        class="btn p-1 btn-light waves-effect waves-light btn-block font-18">
                                                        <i class="mdi mdi-check mdi-24px"></i>
                                                        Si
                                                    </button>
                                                </div>
                                                <div class="col-xl-6">
                                                    <button type="reset" class="btn btn-light p-1 waves-effect btn-block font-18" data-dismiss="modal" >
                                                        <i class="mdi mdi-block-helper mdi-16Spx  ml-auto" aria-hidden="true"></i>
                                                        No
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
                        @endif
                    </div>     
                           
                        
                </div> <!-- end col -->
            
                <div class="col-xl-4">
                    <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab2" role="tablist" aria-orientation="vertical">
                    <h4>Síguenos en Facebook</h4>
                    <div class="fb-page" data-href="https://www.facebook.com/PComplementrio.FMP" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/PComplementrio.FMP" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/PComplementrio.FMP">Licenciatura en Educación, Plan complementario;  UES - FMP</a></blockquote></div>
                    @if (count($complementario)>0)
                    <h4>Licenciaturas</h4>
                    @endif
                    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-Depto-PC|Pagina-Admin|super-admin'):@Auth::check())
                    <a class="btn btn-info btn-block text-white text-left  my-2" data-toggle="modal" data-target="#myModalPlan"><i class="dripicons-document"></i> Nuevo Registro</a>
                    <div id="myModalPlan" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="myCenterModalLabel">
                                        <i class="fa fa-graduation-cap fa-5" aria-hidden="true"></i> Registro de Plan complentario</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">                                        
                                    <div class="tab-content">
                                    <form method="POST" 
                                        action="{{ route('Plan.registro') }}" 
                                        class="parsley-examples"
                                        enctype="multipart/form-data"
                                        id="formComplementario">
                                    
                                        <input type="hidden" id="_id" name="_id"/>
                                        @csrf
                                        
                                        <div class="alert alert-primary text-white" 
                                            role="alert" style="display:none" id="notificacionComplementario">                                               
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <label>Nota: <code>* Campos Obligatorio</code></label>
                                                </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label for="nombre" >Nombre <code>*</code></label>
                                                    <input type="text" class="form-control"
                                                            placeholder="Nombre (Obligatorio)"
                                                            name="nombre" id="nombre"/>
                                                </div> 
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label for="titulo">Título que otorga <code>*</code></label>
                                                    <input type="text" class="form-control"
                                                                placeholder="Título que otorga (Obligatorio)"
                                                            name="titulo" id="titulo"/>
                                                </div>
                                            </div>
                                        </div>      

                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label for="modalidad">Modalidad <code>*</code></label>
                                                    <input type="text" class="form-control"
                                                            placeholder="Modalidad (Obligatorio)"
                                                            name="modalidad" id="modalidad"/>
                                                </div> 
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label for="duracion">Duración <code>*</code></label>
                                                    <input type="text" class="form-control"
                                                            placeholder="Duración (Obligatorio)"
                                                            name="duracion" id="duracion"/>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label for="asignaturas">Número de asignaturas <code>*</code></label>
                                                    <input type="number" class="form-control" min="1"
                                                            placeholder="0"
                                                            name="asignaturas" id="asignaturas"/>
                                                </div> 
                                            </div>
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label for="unidades">Unidades valorativas <code>*</code></label>
                                                    <input type="number" class="form-control" min="1"
                                                            placeholder="0"
                                                            name="unidades" id="unidades"/>
                                                </div>
                                            </div>
                                            
                                        </div>  

                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label for="precio">Precio ($) <code>*</code></label>
                                                    <input type="text" class="form-control" placeholder="Precio (Obligatorio)"
                                                            name="precio" id="precio"/>
                                                </div>
                                            </div> 
                                            <div class="col-xl-6">
                                                <div class="form-group">
                                                    <label for="precio">Dirigido a: <code>*</code></label>
                                                    <input type="text" class="form-control" placeholder="Dirigido a (Obligatorio)"
                                                            name="dirigido" id="dirigido"/>
                                                </div>
                                            </div>                                                
                                        </div>

                                        <div class="row py-1">
                                            <div class="col-xl-12">     
                                                <div class="form-group">                                               
                                                    <label for="contenido">Contenido <code>*</code></label>
                                                    <textarea value="" class="form-control summernote-config" name="contenido" id="contenido"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="form-group mb-0">
                                            <div>
                                                <button type="button" 
                                                        class="btn btn-primary waves-effect waves-light mr-1"
                                                        onclick="submitForm('#formComplementario','#notificacionComplementario')">
                                                    <li class="fa fa-save"></li>
                                                    Guardar
                                                </button>
                                                <button type="button" class="btn btn-light waves-effect" data-dismiss="modal" >
                                                    <i class="fa fa-ban" aria-hidden="true"></i>
                                                    Cancelar
                                                </button>
                                            </div>
                                        </div>
                                    </form>       
                                    </div>
                                </div>                                    
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal --> 
                @endif       
                    @foreach ($complementario as $comple)
                        <a class="nav-link  mb-2 btn-outline-danger  border"  data-toggle="pill" href="#{!! preg_replace('([^A-Za-z0-9])', 'l', $comple->nombre)!!}" role="tab" 
                            aria-selected="false">{!!$comple->nombre!!}</a>
                      @endforeach 
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row--> 
        </div> <!-- end card-box -->
    </div> <!-- end container -->
</div> 
@endsection