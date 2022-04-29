@extends('Pagina/base')

@section('appcss')
<!-- App favicon -->
<link rel="shortcut icon" href="images/favicon.ico">
@if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
<!-- Este css se carga nada mas cuando esta logeado un usuario-->
<link href="{{ asset('css/dropzone.min.css') }} " rel="stylesheet" type="text/css" />

<!-- Summernote css -->
<link href="{{ asset('css/summernote-bs4.css') }}" rel="stylesheet" />
@endif

<!-- App css -->
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />


<!--Libreria data table para paginacion de noticias-->
<link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    iframe{
        width: 100%;
        height: 350px;
    }
</style>
@endsection

@section('container')
<div class="wrapper">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="page-title-box color-boton py-2 rounded">
            <a class="page-title text-white h2" href="{{ route('index') }}">Facultad Multidisciplinaria Paracentral</a>
        </div>         
        <div class="my-4"></div>
        <!-- end page title --> 
        <div class="row">
            <div class="col-xl-8">
                <div class="row">                    
                    <div class="col-xl-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col order-first">
                                    <h3 class="my-2">Administración Académica</h3>
                                </div>
                                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())                            
                                <div class="col-lg-3 order-last">
                                    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
                                        <button type="button" class="btn btn-info btn-block my-1 float-right"  
                                            data-toggle="modal" data-target="#modalCarrusel"> 
                                            <div class="dripicons-photo">&nbsp;Subir Imagen</div>
                                        </button>
                                    @endif                                                                
                                </div>
                                @endif
                            </div>
                            
                            @if (count($carrusel) == '0')
                                    <p class="p-2 mx-2 border text-center btn-block"> No hay imagenes para mostrar</p>
                            @else
                            <div id="carouselExampleCaptions" class="carousel slide rounded col-xl-12" data-ride="carousel">
                                <ol class="carousel-indicators">  
                                    @for ($i = 0; $i < count($carrusel); $i++)
                                        @if ($i == 0 )
                                            <li data-target="#carouselExampleCaptions" data-slide-to="{{$i}}" class="active"></li>
                                        @else                                        
                                            <li data-target="#carouselExampleCaptions" data-slide-to="{{$i}}" ></li>
                                        @endif
                                    @endfor                               
                                </ol>
                                <div class="carousel-inner">
                                    @for ($i = 0; $i < count($carrusel); $i++)                      
                                        <div class="carousel-item {!!$i == 0 ? 'active': null!!}">
                                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())                                                
                                            <button type="submit" class="btn text-white btn-danger btn-block">
                                                <div class=" mdi mdi-delete mdi-16px text-center" 
                                                data-toggle="modal" data-target="#modalCR" 
                                                onclick="$('#imagenCR').val({!!$carrusel[$i]->id!!})">Eliminar</div>
                                            </button>
                                            @endif  
                                            <img src="images/carrusel/{{$carrusel[$i]->imagen}}" class="img-fluid" width="100%" height="60%" alt="{!!$carrusel[$i]->imagen!!}">                                
                                        </div>  
                                    @endfor        
                                </div>                       
                                <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Anterior</span>
                                    </a>
                                <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Siguiente</span>
                                </a>
                            </div>                                                        
                            @endif
                        </div>
                    </div> <!-- end col -->
                </div>
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card-box text-center">
                            <div class="row button-list">
                                <div class="col-xl-6 col-sm-6">
                                    <div type="button" class="card border border-danger" href="#" data-toggle="modal" data-target="#modalProAca">
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote mb-0">
                                                <i class="mdi mdi-file-cabinet fa-4x text-danger"></i> <br>
                                                <h3>Procesos Académicos</h3>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>                       
                                <div class="col-xl-6 col-sm-6" >
                                    <div type="button" class="card border border-danger" data-toggle="modal" data-target="#modalMallas">
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote mb-0 ">
                                                <i class=" mdi mdi-file-table  fa-4x text-danger"></i> <br>
                                                <h3>Mallas Curriculares</h3>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>                             
                                <div class="col-xl-6 col-sm-6">
                                    <div type="button" class="card border border-danger" data-toggle="modal" data-target="#modalGradua">
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote mb-0">
                                                <i class="mdi mdi-school fa-4x text-danger"></i> <br>
                                                <h3>Graduación</h3>                                                
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>                       
                                <div class="col-xl-6 col-sm-6" >
                                    <div type="button" class="card border border-danger" data-toggle="modal" data-target="#modalCalendario">
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote mb-0">
                                                <i class="mdi mdi-calendar-month fa-4x text-danger"></i> <br>
                                                <h3>Calendario Académico</h3>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-6" >
                                    <div type="button" class="card border border-danger" data-toggle="modal" data-target="#modalFromula">
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote mb-0">
                                                <i class="mdi mdi-file-download fa-4x text-danger"></i> <br>
                                                <h3>Descargas</h3>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-sm-6">
                                    <div type="button" class="card border border-danger" data-toggle="modal" data-target="#modalAudioVisual">
                                        <div class="card-body">
                                            <blockquote class="card-bodyquote mb-0">
                                                <i class=" mdi mdi-video-vintage fa-4x  text-danger"></i> <br>
                                                <h3>AudioVisuales</h3>
                                            </blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-xl-4">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card-box">
                            <div class="row">
                                <div class="col-xl-12"><h3>Siguenos en Facebook</h3></div>
                                <div class="col-xl-12 text-center" style="overflow: auto;">
                                    <div class="fb-page" data-href="https://www.facebook.com/academicaparacentralues/" data-tabs="" data-width="" data-height="" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/academicaparacentralues/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/academicaparacentralues/">Académica Paracentral - UES</a></blockquote></div> 
                                </div>                                                                                                                
                            </div>                                                         
                        </div>
                    </div><!-- end col-->      
        
                    <div class="col-xl-12" >                        
                        <div class="card-box"> 
                            <h3>Canales Digitales</h3>    
                            <a href="https://www.facebook.com/celeues" target="_blank" class="btn btn-danger btn-block mt-3 text-left"><i class="mdi mdi-earth font-18"></i> CELEUES</a>
                            <a href="https://campus.ues.edu.sv/" target="_blank" class="btn btn-danger btn-block mt-3 text-left"><i class="mdi mdi-earth font-18"></i> Campus Virtual Central</a>
                            <a href="https://eel.ues.edu.sv/" target="_blank" class="btn btn-danger btn-block mt-3 text-left"><i class="mdi mdi-earth font-18"></i> Expediente en Linea</a>
                            <a href="https://sites.google.com/ues.edu.sv/multimedia-fmp" target="_blank" class="btn btn-danger btn-block mt-3 text-left">
                                <i class=" mdi mdi-earth  font-18"></i>  Recursos Audiovisuales LMS</a>
                            <a href="#" target="_blank" class="btn btn-danger btn-block mt-3 text-left" style="display: none"><i class=" mdi mdi-book-open-variant font-18"></i> Campus Virtual FMP</a>                  
                            <a href="https://correo.ues.edu.sv/" target="_blank" class="btn btn-danger  btn-block mt-3 text-left"><i class=" mdi mdi-email font-18"></i> Correo Institucional</a>                           
                            <a href="https://www.facebook.com/EnLineaFMP" target="_blank" class="btn btn-danger  btn-block mt-3 text-left"><i class="mdi mdi-facebook border rounded font-16"></i> Educación en Línea Sede San Vicente</a> 
                            <a href="http://biblio.fmp.ues.edu.sv/biblioteca/" target="_blank" class="btn btn-danger btn-block mt-3 text-left"><i class=" mdi mdi-book-open-variant font-18"></i> Biblioteca</a>
                        </div> <!-- end card-box-->                        
                    </div> <!-- end col-->  
        
                    <div class="col-xl-12">
                        <div class="card-box">
                            <h3>Oferta Académica</h3>
                            <a href="{{ route('Departamento.CienciasEdu') }}" target="_blank" class="btn btn-danger btn-block mt-3 text-left"><i class=" mdi mdi-school font-18"></i> Ciencias de la Educación</a>                                        
                            <a href="{{ route('Departamento.CienciasAgr') }}" target="_blank" class="btn btn-danger btn-block mt-3 text-left"><i class=" mdi mdi-school font-18"></i> Ciencias Agronómicas</a>                        
                            <a href="{{ route('Departamento.CienciasEcon') }}" target="_blank" class="btn btn-danger btn-block mt-3 text-left"><i class=" mdi mdi-school font-18"></i> Ciencias Económicas</a>                        
                            <a href="{{ route('Departamento.Inform') }}" target="_blank" class="btn btn-danger btn-block mt-3 text-left"><i class=" mdi mdi-school font-18"></i> Informática</a>                        
                            <a href="{{ route('planComp') }}" target="_blank" class="btn btn-danger btn-block mt-3 text-left"><i class=" mdi mdi-school font-18"></i> Plan Complementario</a>
                            <a href="{{ route('postgrado') }}" target="_blank" class="btn btn-danger btn-block mt-3 text-left"><i class=" mdi mdi-school font-18"></i> Postgrado</a>
                        </div>
                    </div>                                       
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xl-12">
                <div class="card-box"> 
                    <h3>Sitios de Interes</h3>                        
                    <div class="row">
                        <div class="col order-first">
                            <p class="header-title">Facultades</p>                                   
                            <div class="p-1"><a href="https://humanidades.ues.edu.sv/" target="_blank">Facultad de Ciencias y Humanidades</a></div>
                            <div class="p-1"><a href="http://www.fmoues.edu.sv/"target="_blank">Facultad Multidisciplinaria de Oriente</a></div>
                            <div class="p-1"><a href="http://www.fia.ues.edu.sv/"target="_blank">Facultad de Ingeniería y Arquitectura</a></div>
                            <div class="p-1"><a href="https://www.agronomia.ues.edu.sv/"target="_blank">Facultad de Agronomía</a></div>
                            <div class="p-1"><a href="http://www.odontologia.ues.edu.sv/"target="_blank">Facultad de Odontología</a></div>
                            <div class="p-1"><a href="http://www.medicina.ues.edu.sv/"target="_blank">Facultad de Medicina</a></div>
                            <div class="p-1"><a href="http://jurisprudencia.ues.edu.sv/sitio/"target="_blank">Facultad de Jurisprudencia y Ciencias Sociales</a></div>
                            <div class="p-1"><a href="https://www.quimicayfarmacia.ues.edu.sv/"target="_blank">Facultad de Química y Farmacia</a></div>
                            <div class="p-1"><a href="https://www.cimat.ues.edu.sv/"target="_blank">Facultad de Ciencias Naturales y Matemática</a></div>
                            <div class="p-1"><a href="http://www.occ.ues.edu.sv/"target="_blank">Facultad Multidisciplinaria de Occidente</a></div>
                            <div class="p-1"><a href="http://www.fce.ues.edu.sv/"target="_blank">Facultad de Ciencias Económicas</a></div>
                        </div>
                        <div class="col">
                            <p class="header-title">Secretarias</p>     
                            <div class="p-1"><a href="http://secretariageneral.ues.edu.sv/" target="_blank">Secretaría General</a></div>
                            <div class="p-1"><a href="http://proyeccionsocial.ues.edu.sv/" target="_blank">Secretaría de Proyección Social</a></div>
                            <div class="p-1"><a href="http://www.eluniversitario.ues.edu.sv/" target="_blank">Secretaría de Comunicaciones</a></div>
                            <div class="p-1"><a href="https://es-es.facebook.com/ArteyCulturaUES/" target="_blank">Secretaría de Arte y Cultura</a></div>
                            <div class="p-1"><a href="http://www.bienestar.ues.edu.sv/" target="_blank">Secretaría de Bienestar Universitario</a></div>
                            <div class="p-1"><a href="http://www.ues.edu.sv/secretaria-de-relaciones-nacionales-e-internacionales/" target="_blank">Secretaría de Relaciones</a></div>
                            <div class="p-1"><a href="https://secplan.ues.edu.sv/" target="_blank">Secretaría de Planificación</a></div>
                            <div class="p-1"><a href="https://sic.ues.edu.sv/" target="_blank">Secretaría de Investigaciones Científicas</a></div>
                            <div class="p-1"><a href="http://saa.ues.edu.sv/" target="_blank">Secretaría de Asuntos Académicos</a></div>
                        </div>
                        <div class="col order-last">
                            <p class="header-title">Institución</p>
                            <div class="p-1"><a href="https://www.ues.edu.sv/becas/" target="_blank">Consejo de Becas</a></div>                            
                            <div class="p-1"><a href="#">Consejo Superior Universitario</a></div>
                            <div class="p-1"><a href="#">Asamblea General Universitaria</a></div>
                            <div class="p-1"><a href="https://www.uese.ues.edu.sv/" target="_blank">Unidad de Estudio Socioeconómico </a></div>
                            <div class="p-1"><a href="https://www.facebook.com/defensoriaues/" target="_blank">Defensoría de los Derechos Universitarios</a></div>                            
                        </div>
                    </div>                            
                </div> <!-- end card-box -->
            </div><!-- end col -->          
        </div>      

    </div> <!-- end container -->
</div>   
@if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
    <div id="modalEliminarPDF" class="modal fade bs-example-modal-center" tabindex="-1" 
        role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border rounded">
                    <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body border rounded">
                    <form action="{{ route('eliminarpdfmaestri') }}" method="POST">
                        @csrf
                        <div class="row py-3">
                            <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                            <div class="col-lg-10 text-black">
                                <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se elimina este registro de manera permanente, ¿Desea continuar?</h4>
                            </div>
                            <input type="hidden" name="_id" id="eliminar">                                                        
                            <input type="hidden" name="localizacion" id="localizacion">
                            <input type="hidden" name="vista" value="admonAcademica">
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
    <div id="modalEliminarVideo" class="modal fade bs-example-modal-center" tabindex="-1" 
        role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border rounded">
                    <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body border rounded">
                    <form action="{{ route('admonEliminarV') }}" method="POST">
                        @csrf
                        <div class="row py-3">
                            <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                            <div class="col-lg-10 text-black">
                                <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se elimina este registro de manera permanente, ¿Desea continuar?</h4>
                            </div>
                            <input type="hidden" name="_id" id="eliminarV">             
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
    <div id ="modalCR" class="modal fade bs-example-modal-center" tabindex="-1" 
        role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form action="{{route('imagenCAborrar', ['url'=> 'admonAcademica'])}}" method="POST">
                        @csrf
                        <div class="row py-3">
                            <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                            <div class="col-lg-10 text-black">
                                <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se elimina este registro de manera permanente, ¿Desea continuar?</h4>
                            </div>
                            <input type="hidden" name="_id" id="imagenCR">
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
    <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"  id="modalCarrusel"
        aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title" id="myCenterModalLabel">Zona para subir imagen</h3>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <form  method="post" action="{{ route('ImagenCarrusel', ['tipo'=>10]) }}"
                        class="dropzone dropzoneimagen" >
                        @csrf                                 
                        <div class="dz-message needsclick">
                            <i class="h1 text-muted dripicons-cloud-upload"></i>
                            <h3>Suelta el archivo aquí o haz clic para subir.</h3>
                        </div>
                        <div class="dropzone-previews"></div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
@endif 
<!--  Modal content for the above example -->
<div id="modalProAca" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myLargeModalLabel"><i class="mdi mdi-file-cabinet mdi-24px"></i> Procesos Académicos</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                        $pdfs = \App\Models\Pagina\PDF::where('localizacion','ProAcademica')->get();
                    ?>
                    
                    @if (count($pdfs)>0)
                    <div class="col-xl-12">
                        <div class="card-box">
                            @foreach ($pdfs as $item)
                            <div class="btn-group btn-block" role="group">
                                <a class="btn btn-danger waves-effect waves-light btn-block text-left fond-19" type="button" 
                                    href="{{ route('index') }}{!!'/files/pdfs/ProAcademica/'.$item->file !!}" style="margin-left: 0px; " target="_blank">
                                    <i class=" mdi mdi-arrow-down-bold font-18"></i>  {{$item->file}}
                                </a> 
                                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
                                <a class="btn btn-light waves-effect width-md  text-center" onclick="$('#eliminar').val({{$item->id}});$('#localizacion').val('ProAcademica');"
                                    data-toggle="modal" data-target="#modalEliminarPDF"><i class="mdi mdi-delete font-18"></i> Eliminar</a>
                                @endif
                            </div>
                            @endforeach 
                        </div>  
                    </div>
                    @endif
                </div>
                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
                <div class="row">   
                    <div class="col-xl-12">
                        <div class="card-box">
                            <h4 class="text-center">Zona para subir archivos</h4>                             
                            <form action="{{ route('Mpdf', ['localizacion'=>'ProAcademica']) }}" method="post"
                                class="dropzone dropzonepdf" >
                                @csrf                                 
                                <div class="dz-message needsclick">
                                    <i class="h3 text-muted dripicons-cloud-upload"></i>
                                    <h3>Suelta los archivos aquí o haz clic para subir.</h3>
                                </div>
                                <div class="dropzone-previews"></div>
                            </form>
                        </div>
                    </div>
                </div> 
                @endif
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--  Modal content for the above example -->
<div id="modalMallas" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myLargeModalLabel"><i class="mdi mdi-file-table mdi-24px"></i> Mallas Curriculares</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                        $pdfs = \App\Models\Pagina\PDF::where('localizacion','academicaMallas')->get();
                    ?>
                    
                    @if (count($pdfs)>0)
                    <div class="col-xl-12">
                        <div class="card-box">
                            <div class="table-responsive text-left" id="listaPDF">
                                <table class="table  mb-0 @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin')) table-striped @endif">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h4>Malla Curricular</h4>
                                            </th>                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pdfs as $item)
                                        <tr>
                                            <th class="align-middle" >
                                                <div class="row">
                                                    
                                                    <div class="col order-first">
                                                        <p class="font-14">{!!$item->file!!}</p>
                                                    </div>
                                                    <div class="col-lg-5 order-last text-right">
                                                        <div class="btn-group" role="group">
                                                            <a class="btn btn-danger waves-effect width-lg mx-1"  href="{{ route('index') }}{!!'/files/pdfs/academicaMallas/'.$item->file !!}" target="_blank"> 
                                                                <i class="  mdi mdi-arrow-down-bold font-18 mr-1"></i>Descargar
                                                            </a>
                                                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
                                                            <button type="buttom"  class="btn btn-light waves-effect width-md mx-1" data-toggle="modal" data-target="#modalEliminarPDF"
                                                                onclick="$('#eliminar').val({{$item->id}});$('#localizacion').val('academicaMallas');"
                                                                data-toggle="modal" data-target="#modalEliminarPDF"><i class="mdi mdi-delete font-18"></i>  Eliminar
                                                            </button>  
                                                            @endif 
                                                        </div>
                                                    </div>
                                                </div>                                                                                                                    
                                            </th>
                                        </tr>  
                                        @endforeach                                                              
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->
                        </div>  
                    </div>
                    @endif
                </div>
                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
                <div class="row">   
                    <div class="col-xl-12">
                        <div class="card-box">
                            <h4 class="text-center">Zona para subir arhivos</h4>                             
                            <form action="{{ route('Mpdf', ['localizacion'=>'academicaMallas']) }}" method="post"
                                class="dropzone dropzonepdf" >
                                @csrf                                 
                                <div class="dz-message needsclick">
                                    <i class="h3 text-muted dripicons-cloud-upload"></i>
                                    <h3>Suelta los archivos aquí o haz clic para subir.</h3>
                                </div>
                                <div class="dropzone-previews"></div>
                            </form>
                        </div>
                    </div>
                </div> 
                @endif
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->    
<!--  Modal content for the above example -->
<div id="modalAudioVisual" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myLargeModalLabel"><i class=" mdi mdi-video-vintage mdi-24px"></i> AudioVisuales</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body text-left"> 
                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
                <div class="card-box">
                    <div class="alert alert-primary text-white " 
                        role="alert" style="display:none" id="notificacionAudioVisual">                                               
                    </div>
                    <form method="POST" 
                        action="{{ route('admonAgregarV') }}" 
                        class="parsley-examples text-left"
                        id="audioVisualForm">
                        @csrf
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label for="avTitulo">Titulo</label>
                                    <input type="text" class="form-control" id="avTitulo" name="titulo" placeholder="Titulo del video">
                                </div>
                            </div>
                        
                        </div>
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="form-group">
                                    <label for="">Codigo del video</label>
                                    <input type="text" name="codigo" class="form-control" placeholder="<iframe src='https://www.sitio.com/embed/'  allowfullscreen></iframe>">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-xl-12">
                                <button type="button" class="btn btn-primary" 
                                style="margin-left: 0px;" onclick="submitForm('#audioVisualForm','#notificacionAudioVisual')"><li class="fa fa-save"></li>
                                    Guardar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                @endif
                <?php
                    $videos = \App\Models\Pagina\AudioVisual::all();
                ?>
                <div class="card-box">  
                @foreach ($videos as $item)
                    <div class="btn-group py-1 btn-block">
                        <button class="btn btn-danger  waves-effect waves-light btn-block text-left fond-19" type="button" 
                            data-toggle="collapse" data-target="#collapseExample{{$item->id}}" 
                            aria-expanded="false" aria-controls="collapseExample{{$item->id}}" s
                            tyle="margin-left: 0px;">
                            <i class=" mdi mdi-video-vintage mdi-24px"></i>  {{$item->titulo}}
                        </button> 
                        @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
                        <button type="buttom"  class="btn btn-light waves-effect width-md" data-toggle="modal" data-target="#modalEliminarVideo" 
                            onclick="$('#eliminarV').val({{$item->id}})">
                            <i class="mdi mdi-delete font-18"></i>  Eliminar
                        </button>
                        @endif
                    </div>
                    
                    <div class="collapse" id="collapseExample{{$item->id}}">
                        <div class="card-box ">
                            {!!$item->link!!}                                                            
                        </div>
                    </div>  
                
                @endforeach     
                </div>        
                                                                    
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--  Modal content for the above example  -->
<div id="modalFromula" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myLargeModalLabel"><i class="mdi mdi-file-download mdi-24px"></i> Descargas</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                        $pdfs = \App\Models\Pagina\PDF::where('localizacion','academicaFormula')->get();
                    ?>
                    
                    @if (count($pdfs)>0)
                    <div class="col-xl-12">
                        <div class="card-box">
                            <div class="table-responsive text-left" >
                                <table class="table  mb-0 @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin')) table-striped @endif">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h4>Formularios</h4>
                                            </th>                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pdfs as $item)
                                        <tr>
                                            <th class="align-middle" >
                                                <div class="row">
                                                    
                                                    <div class="col order-first">
                                                        <p class="font-14">{!!$item->file!!}</p>
                                                    </div>
                                                    <div class="col-lg-5 order-last text-right">
                                                        <div class="btn-group" role="group">
                                                            <a class="btn btn-danger waves-effect width-lg mx-1"  href="{{ route('index') }}{!!'/files/pdfs/academicaFormula/'.$item->file !!}" target="_blank"> 
                                                                <i class="  mdi mdi-arrow-down-bold font-18 mr-1"></i>Descargar
                                                            </a>
                                                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
                                                            <button type="buttom"  class="btn btn-light waves-effect width-md mx-1" data-toggle="modal" data-target="#modalEliminarPDF"
                                                                onclick="$('#eliminar').val({{$item->id}});$('#localizacion').val('academicaFormula');"
                                                                ><i class="mdi mdi-delete font-18"></i>  Eliminar
                                                            </button>  
                                                            @endif 
                                                        </div>
                                                    </div>
                                                </div>                                                                                                                    
                                            </th>
                                        </tr>  
                                        @endforeach                                                              
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->
                        </div>  
                    </div>
                    @endif
                </div>
                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
                <div class="row">   
                    <div class="col-xl-12">
                        <div class="card-box">
                            <h4 class="text-center">Zona para subir archivos</h4>                             
                            <form action="{{ route('Mpdf', ['localizacion'=>'academicaFormula']) }}" method="post"
                                class="dropzone dropzonepdf" >
                                @csrf                                 
                                <div class="dz-message needsclick">
                                    <i class="h3 text-muted dripicons-cloud-upload"></i>
                                    <h3>Suelta los archivos aquí o haz clic para subir.</h3>
                                </div>
                                <div class="dropzone-previews"></div>
                            </form>
                        </div>
                    </div>
                </div> 
                @endif
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--  Modal content for the above example -->
<div id="modalGradua" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myLargeModalLabel"><i class="mdi mdi-school mdi-24px"></i> Graduación</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <?php
                        $pdfs = \App\Models\Pagina\PDF::where('localizacion','academicaGradua')->get();
                    ?>
                    
                    @if (count($pdfs)>0)
                    <div class="col-xl-12">
                        <div class="card-box">
                            <div class="table-responsive text-left" id="listaPDF">
                                <table class="table  mb-0 @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin')) table-striped @endif">
                                    <thead>
                                        <tr>
                                            <th>
                                                <h4>Archivos</h4>
                                            </th>                           
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pdfs as $item)
                                        <tr>
                                            <th class="align-middle" >
                                                <div class="row">
                                                    
                                                    <div class="col order-first">
                                                        <p class="font-14">{!!$item->file!!}</p>
                                                    </div>
                                                    <div class="col-lg-5 order-last text-right">
                                                        <div class="btn-group" role="group">
                                                            <a class="btn btn-danger waves-effect width-lg mx-1"  href="{{ route('index') }}{!!'/files/pdfs/academicaGradua/'.$item->file !!}" target="_blank"> 
                                                                <i class="  mdi mdi-arrow-down-bold font-18 mr-1"></i>Descargar
                                                            </a>
                                                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
                                                            <button type="buttom"  class="btn btn-light waves-effect width-md mx-1" data-toggle="modal" data-target="#modalEliminarPDF"
                                                                onclick="$('#eliminar').val({{$item->id}});$('#localizacion').val('academicaGradua');"
                                                                data-toggle="modal" data-target="#modalEliminarPDF"><i class="mdi mdi-delete font-18"></i>  Eliminar
                                                            </button>  
                                                            @endif 
                                                        </div>
                                                    </div>
                                                </div>                                                                                                                    
                                            </th>
                                        </tr>  
                                        @endforeach                                                              
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->
                        </div>  
                    </div>
                    @endif
                </div>
                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
                <div class="row">   
                    <div class="col-xl-12">
                        <div class="card-box">
                            <h4 class="text-center">Zona para subir arhivos</h4>                             
                            <form action="{{ route('Mpdf', ['localizacion'=>'academicaGradua']) }}" method="post"
                                class="dropzone dropzonepdf" >
                                @csrf                                 
                                <div class="dz-message needsclick">
                                    <i class="h3 text-muted dripicons-cloud-upload"></i>
                                    <h3>Suelta los archivos aquí o haz clic para subir.</h3>
                                </div>
                                <div class="dropzone-previews"></div>
                            </form>
                        </div>
                    </div>
                </div> 
                @endif
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!--  Modal content for the above example -->
<div id="modalCalendario" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="myLargeModalLabel"><i class="mdi mdi-calendar-month mdi-24px"></i> Calendario  Académico</h3>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">    
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card-box">
                            @if ($calendarioAcaIMG!=null)
                            <img  width="100%" height="550px" src="{{ asset('/files/image') }}/{!!$calendarioAcaIMG->file!!}" alt="{!!$calendarioAcaIMG->file!!}">
                            @else
                                <p class="border p-2 text-center">No hay imagen.</p>
                            @endif
                        </div>
                    </div>
                </div>     
                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card-box">
                            <h4 class="text-center">Zona para subir imagen</h4>                     
                            <form  method="post" action="{{ route('academicaImagen', base64_encode('calendarioAca')) }}"
                                class="dropzone dropzoneimagen">
                                @csrf            
                                <div class="dz-message needsclick">
                                    <i class="h1 text-muted dripicons-cloud-upload"></i>
                                    <h3>Suelta el archivo aquí o haz clic para subir.</h3>
                                </div>
                                <div class="dropzone-previews"></div>
                            </form>
                        </div>
                    </div>  
                </div>     
                @endif                              
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<!-- end wrapper -->
@endsection

@section('footerjs')

<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v10.0" nonce="4Ddk6ohO"></script>
<!-- Vendor js -->
<script src="{{ asset('js/vendor.min.js') }}"></script>

<!-- App js -->
<script src="{{ asset('js/app.min.js') }}"></script>

<!--Librerias js para datatable-->
<script src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>

@if(@Auth::check()?@Auth::user()->hasRole('Pagina-AdminAcademica|Pagina-Admin|super-admin'):@Auth::check())  
<script src="{{ asset('js/scripts/http.min.js') }}"></script>
<script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('js/summernote.config.min.js') }}"></script>
<script src="{{ asset('vendor/summernote/lang/summernote-es-ES.js') }}"></script>  
<script src="{{ asset('js/scripts/http.min.js') }}"></script>

<!-- Plugins js -->
<script src="{{ asset('js/dropzone.min.js') }} "></script>
<script src="{{ asset('js/scripts/dropzoneimagenpdf.js') }}"></script>@endif
<script src="{{ asset('js/index/index.datatable.js') }}"></script>
@endsection