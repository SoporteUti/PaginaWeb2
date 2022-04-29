@extends('Pagina/baseOnlyHtml')

@section('header')
@if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check())
    <!-- Summernote css -->
    <link href="{{ asset('css/summernote-bs4.css') }}" rel="stylesheet" />
    
    <!-- Este css se carga nada mas cuando esta logeado un usuario-->
    <link href="{{ asset('css/dropzone.min.css') }} " rel="stylesheet" type="text/css" />
    
@endif    
@endsection

@section('footer')
    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check()) 
    <script src="{{ asset('js/scripts/http.min.js') }}"></script>   
        <!-- Plugins js -->
        <script src=" {{ asset('js/dropzone.min.js') }} "></script>   
        <script src=" {{ asset('js/scripts/dropzoneImagenes.js') }} "></script>
        <script src="{{ asset('js/scripts/http.min.js') }}"></script>
        <!--Summernote js-->
        <script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
        <script src="{{ asset('js/summernote.config.min.js') }}"></script>
        <script src="{{ asset('vendor/summernote/lang/summernote-es-ES.js') }}"></script>
        <script>
            // para recargar pagina luego de subir o no imagenes
            $('.bs-example-modal-center').on('hidden.bs.modal', function() { location.reload(); });
        </script>
    @endif    
    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v11.0" nonce="FxW143mb"></script>
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
                        <div class="tab-pane fade active show" id="index" role="tabpanel" >
                            
                            
                            <div class="row py-1">
                                <div class="col order-first">
                                    <h3 >Unidad de Investigación</h3>
                                </div>
                                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check())
                                <div class="col-lg-3 order-last">
                                    <a href="" class="btn btn-block btn-info tex-left" 
                                    data-toggle="modal" data-target=".bs-example-modal-center">
                                        <div class="mdi mdi-upload mdi-16px text-center"> Agregar Imagen</div>
                                    </a>
                                </div>                            
                                    
                                <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;" id="dropZoneCarrusel">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="myCenterModalLabel">Zona para subir imágenes</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">
                                                
                                                <form action="{{ route('ImagenCarrusel', ['tipo'=>3]) }}" method="post"
                                                    class="dropzone" id="my-awesome-dropzone">
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
                                </div><!-- /.modal -->
                                @endif  
                            </div>
                           
                            
                            <div class="row">                        
                                @if (count($investigacionCarrusel) == '0')
                                    <p class="p-2 mx-2 border text-center btn-block"> No hay imagenes para mostrar.</p>
                                @else
                                <div id="carouselExampleCaptions" class="carousel slide rounded col-xl-12" data-ride="carousel">
                                    <ol class="carousel-indicators">  
                                        @for ($i = 0; $i < count($investigacionCarrusel); $i++)
                                            @if ($i == 0 )
                                                <li data-target="#carouselExampleCaptions" data-slide-to="{{$i}}" class="active"></li>
                                            @else                                        
                                                <li data-target="#carouselExampleCaptions" data-slide-to="{{$i}}" ></li>
                                            @endif
                                        @endfor                               
                                    </ol>
                                    <div class="carousel-inner">
                                        @for ($i = 0; $i < count($investigacionCarrusel); $i++)            
                                                                                
                                            <div class="carousel-item {!!$i == 0 ? 'active': null!!}">
                                                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check())                                                
                                                <button type="submit" class="btn text-white btn-danger btn-block">
                                                    <div class=" mdi mdi-delete mdi-16px text-center" data-toggle="modal" data-target="#modalCR" onclick="$('#imagenCR').val({!!$investigacionCarrusel[$i]->id!!})">Eliminar</div>
                                                </button>
                                                @endif  
                                                <img src="images/carrusel/{{$investigacionCarrusel[$i]->imagen}}" class="img-fluid" width="100%" height="60%" alt="{!!$investigacionCarrusel[$i]->imagen!!}">                                
                                            </div>  
                                        @endfor 
                                        <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">
                                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Anterior</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">
                                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                            <span class="sr-only">Siguiente</span>
                                            </a>
                                    </div>  
                                </div>
                                @endif  
                                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check())
                                    <div class="row py-3">
                                        <div class="col-xl-12">
                                            <form action="{{ route('contenido', ['localizacion'=>'investigacionIndex']) }}" method="POST"  
                                                class="parsley-examples"  id="indexContenido">
                                                @csrf
                                                <div class="alert alert-primary text-white py-1" 
                                                        role="alert" style="display:none" id="notificacion">                                               
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
                                                                onclick="submitForm('#indexContenido','#notificacion')">
                                                                <i class="fa fa-save fa-5 ml-3"></i> Guardar
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>  
                                    </div>    
                                @endif 
                                      

                                      
                                <div class="col-xl-12 row">

                                    <div class="col order-first">
                                    </div>                               
                                    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check())
                                    <div class="col-lg-3 order-last">
                                        <button class="btn btn-block btn-info tex-left" 
                                            data-toggle="modal" data-target="#modalSubirInvestigacion">
                                            <div class="mdi mdi-upload mdi-16px text-center" > Subir PDF</div>
                                        </button>
                                    </div>  
                                    <div id="modalSubirInvestigacion" class="modal fade bs-example-modal-center" 
                                        tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" 
                                        aria-hidden="true" style="display: none;" >
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="myCenterModalLabel">Zona para subir PDF</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                </div>
                                                <div class="modal-body">
                                                    
                                                    <form action="{{ route('Mpdf', ['localizacion'=>'investigacion']) }}" method="post"
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
                                @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'))  
                                <div class="col-xl-12 py-2">
                                    @if ($contenido!=null)
                                        {!!$contenido->contenido!!}
                                    @endif
                                </div>      
                                @endif
                                <div class="col-xl-12 py-3">
                                    <?php
                                        $pdfs = \App\Models\Pagina\PDF::where('localizacion','investigacion')->get();
                                    ?>
                                    
                                    @if (count($pdfs)>0)
                                    <div class="table-responsive my-1" id="listaPDFInvestigacion">
                                        <table class="table mb-0 border @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin')) table-striped @endif">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <h4>Formatos</h4>
                                                    </th>
                                                    <th class="col-sm-4">                                              
                                                    </th>                             
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pdfs as $item)
                                                <tr>
                                                    <th class="align-middle" scope="row">
                                                        {!!$item->file!!}
                                                    </th>                                             
                                                                                    
                                                    <th class="align-middle ">
                                                        
                                                        <div class="btn-group" role="group">
                                                            <a class="btn btn-danger waves-effect width-lg mx-1"  href="{{ route('index') }}{!!'/files/pdfs/investigacion/'.$item->file !!}" target="_blank"> 
                                                                <i class="mdi mdi-file-pdf mdi-24px mr-1"></i>Descargar
                                                            </a>
                                                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check())
                                                            <button type="buttom"  class="btn btn-light waves-effect width-md mx-1" data-toggle="modal" data-target="#modalEliminarPDF"
                                                                onclick="$('#eliminar').val({{$item->id}});$('#localizacion').val('investigacion');$('#vista').val('investigacion')"><i class="mdi mdi-delete mdi-24px"></i>  Eliminar
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
                                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check())
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
                                                            <input type="hidden" name="vista" id="vista">
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
                                @endif                                
                                                             
                                <!-- end col -->
                            </div> <!-- end row-->

                        </div>
                        <div class="tab-pane fade " id="v-pills-social2" role="tabpanel" aria-labelledby="v-pills-social-tab2">
                            <a class="nav-link btn btn-danger waves-effect width-md" href="#index"
                                onclick="$('.nav-link').removeClass('active')" data-toggle="pill">
                                    <i class="mdi mdi-arrow-left-thick"></i> 
                                        Volver a Investigación
                            </a>
                            <h3 class="py-2">Centro de Estudio de Opinión Publica (CEOP)</h3>
                            <p class="mb-1 font-weight-bold py-2">Sobre el CEOP FMP:</p>
                            <p class="text-muted font-15 text-justify">
                                Considerando la importancia de contribuir a la comprensión de diferentes procesos sociales en la región paracentral y a nivel nacional, la Junta Directiva de la FMP ha aprobado según acuerdo Nº 24/2019-2021-V la creación del Centro de Estudios de Opinión Pública de la Facultad Multidisciplinaria Paracentral (CEOP FMP), que inició sus actividades en agosto de 2021.
                            </p>
                            <p class="mb-1 font-weight-bold py-2">Objetivo General:</p>
                            <p class="text-muted font-15 text-justify">
                                Investigar la opinión pública en las áreas educativa, económica, agrícola y política, con la finalidad de poner a disposición de la sociedad salvadoreña la información generada y contribuir a la toma de decisiones en estos ámbitos, en la región paracentral y a nivel nacional. 
                            </p>
                            <p class="mb-1 font-weight-bold py-2">Objetivos Específicos:</p>
                            <ul>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Diseñar e implementar procesos de investigación académica-científica en las áreas educativa, económica, agrícola y política, que fomenten la participación de la población salvadoreña.
                                    </p>                                    
                                </li>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Promover la integración de actividades de investigación, docencia y proyección social en la producción de datos sobre la problemática social, como parte de la formación integral de la comunidad educativa de la FMP.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Establecer mecanismos de comunicación y coordinación con instancias de la región paracentral y a nivel nacional, que contribuyan a la generación de información, el análisis y la búsqueda de soluciones a las problemáticas identificadas. 
                                    </p>
                                </li>
                            </ul>
                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check())
                                
                            
                            <div class="row my-2">
                                <div class="col order-first"></div>
                                <div class="col-lg-3 order-last">
                                    <button style="float: righ;" class="btn btn-block btn-info text-right"
                                    data-toggle="modal" data-target="#sondeo-modal">
                                        <i class=" mdi dripicons-document"> Nuevo sondeo</i>
                                    </button>
                                </div> 
                            </div>
                            @endif
                           
                            <table cellspacing="0" width="100%">
                            <thead></thead>
                            <tbody>
                            @foreach ($sondeos as $item)
                            <tr>
                            <td>
                            <div class="border m-1 rounded p-2">
                                <p class="mb-1 font-weight-bold py-2">Desarrollo del sondeo:</p>
                                <span data-toggle="modal" data-target="#myModalNoticia">
                                    <button style="float: right;" type="button"  class="btn btn-light waves-effect width-md" onclick="modificarEX({!!$item->id!!})" >
                                        <i class="mdi mdi-file-document-edit mdi-16p"></i> Modificar</button>
                                </span>
                             
                             
                                 
                             
                                <button style="float: right;" type="button" onclick="$('#noticia').val('{!!base64_encode($item->id)!!}')"
                                     class="btn btn-light waves-effect width-md  width-md" data-toggle="modal" 
                                     data-target="#modalEliminarNoticia">
                                    <i class="mdi mdi-delete"></i> Eliminar</button>
                                <h4 class="font-weight-bold">{{$item->titulo}}</h4>      
                                <p class="text-muted font-15 text-justify">
                                    {{$item->descripcion}}
                                </p>       
                                <img src="{{ asset('/images/sondeos').'/'.$item->imagen }}" 
                                alt="Imagen" class="text-center rounded bx-shadow-lg img-fluid" width="100%">
                                
                                
                                 
                            </div> 
                            
                        </td>
                        </tr>
                        @endforeach 
                        </tbody>
                        </table>
                             
                           
                            @if (count($sondeos)>0)
                                
                            @else
                                <p class="p-2 border text-center">No hay noticias para mostrar.</p>                                
                            @endif            
                        </div>
                        <div id="modalEliminarNoticia" class="modal fade bs-example-modal-center" tabindex="-1" 
                        role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('sondeo.borrar') }}" method="POST">
                                        @csrf
                                        <div class="row py-3">
                                            <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                                            <div class="col-lg-10 text-black">
                                                <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se elimina este registro de manera permanente, ¿Desea continuar?</h4>
                                            </div>
                                            <input type="hidden" name="_id" id="noticia">
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
                        <div class="tab-pane fade" id="v-pills-profile2" role="tabpanel" aria-labelledby="v-pills-profile-tab2">                           
                            <a class="nav-link btn btn-danger waves-effect width-md" href="#index"
                            onclick="$('.nav-link').removeClass('active')" data-toggle="pill">
                                <i class="mdi mdi-arrow-left-thick"></i> 
                                    Volver a Investigación
                            </a>
                            <h2 class="header-title py-2">Centro de Investigación Ambiental</h2> 
                            <?php
                                $variableNoTocar = 'localizacion';
                                $localizacion ='centroInvestigacionAmbiental';
                                $contenido = App\Models\Pagina\ContenidoHtml::where($variableNoTocar,$localizacion)->first();
                            ?>
                        @auth
                        @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CA'))
                        <!-- Esto va en el content-->
                        
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
                        @endauth 
                        @if(auth()->guest()) 
                            <div class="col-xl-12 py-2">
                                @if ($contenido!=null)
                                    {!!$contenido->contenido!!}
                                @endif
                            </div>      
                        @endif
                        <!--pegar aqui-->
                        <div class="col-xl-12 row">

                            <div class="col order-first">
                            </div>                               
                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check())
                            <div class="col-lg-3 order-last">
                                <button class="btn btn-block btn-info tex-left" 
                                    data-toggle="modal" data-target="#modalSubirInvestigacion2">
                                    <div class="mdi mdi-upload mdi-16px text-center" > Subir PDF</div>
                                </button>
                            </div>  
                            <div id="modalSubirInvestigacion2" class="modal fade bs-example-modal-center" 
                                tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" 
                                aria-hidden="true" style="display: none;" >
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myCenterModalLabel">Zona para subir PDF</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <form action="{{ route('Mpdf', ['localizacion'=>'investigacion']) }}" method="post"
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
                           
                        @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'))  
                                   
                                @endif
                                <div class="col-xl-12 py-3">
                                    <?php
                                        $pdfs = \App\Models\Pagina\PDF::where('localizacion','investigacion')->get();
                                    ?>
                                    
                                    @if (count($pdfs)>0)
                                    <div class="table-responsive my-1" id="listaPDFInvestigacion">
                                        <table class="table mb-0 border @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin')) table-striped @endif">
                                            <thead>
                                                <tr>
                                                    <th>
                                                        <h4>Formatos</h4>
                                                    </th>
                                                    <th class="col-sm-4">                                              
                                                    </th>                             
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($pdfs as $item)
                                                <tr>
                                                    <th class="align-middle" scope="row">
                                                        {!!$item->file!!}
                                                    </th>                                             
                                                                                    
                                                    <th class="align-middle ">
                                                        
                                                        <div class="btn-group" role="group">
                                                            <a class="btn btn-danger waves-effect width-lg mx-1"  href="{{ route('index') }}{!!'/files/pdfs/investigacion/'.$item->file !!}" target="_blank"> 
                                                                <i class="mdi mdi-file-pdf mdi-24px mr-1"></i>Descargar
                                                            </a>
                                                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check())
                                                            <button type="buttom"  class="btn btn-light waves-effect width-md mx-1" data-toggle="modal" data-target="#modalEliminarPDF"
                                                                onclick="$('#eliminar').val({{$item->id}});$('#localizacion').val('investigacion');$('#vista').val('investigacion')"><i class="mdi mdi-delete mdi-24px"></i>  Eliminar
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
                    
                </div>

                
                    
                </div> <!-- end col -->
                @if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check())
                <div id ="modalCR" class="modal fade bs-example-modal-center" tabindex="-1" 
                role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar</h3>
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                            </div>
                            <div class="modal-body">
                                <form action="{{route('imagenCAborrar', ['url'=> 'investigacion'])}}" method="POST">
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
                @endif

@if(@Auth::check()?@Auth::user()->hasRole('Pagina-UnidadInvestigacion|Pagina-Admin|super-admin'):@Auth::check())         
<!-- Coordinadores modal content -->
<div class="modal fade" id="sondeo-modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id=" exampleModalLongTitle"><i class="mdi mdi-notebook-multiple mdi-24px"></i> &nbsp; Sondeo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="sondeoForm" action="{{route('sondeo.guardar')}}" method="POST">
            <div class="modal-body">
                <input type="hidden" id="_id" name="_id"/>
                    @csrf
                    <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show" 
                        role="alert" style="display:none" id="notificacionSonde">                                               
                    </div>
                    <div class="row">
                        <div class="col-xl-12">
                            <label>Nota: <code>* Campos Obligatorio</code></label>
                            </div>
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Título <code>*</code></label>
                                <input type="text" class="form-control"
                                        placeholder="Coordinador (Obligatorio)"
                                        name="titulo" />
                            </div> 
                        </div>
                        
                    </div> 
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Imagen <code>*</code></label>
                                <div class="custom-file">
                                    <input type="file" value="" class="custom-file-input form-control" accept="image/*"  name="imagen" />
                                    <label class="custom-file-label" for="img">Seleccionar imagen</label>
                                </div>
                            </div>
                        </div>
                    </div>     
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="form-group">
                                <label>Descripción <code>*</code></label>
                                <div>
                                    <textarea required class="form-control" name="descripcion" placeholder="Departamento (Obligatorio)"></textarea>
                                </div>
                            </div>
                        </div>
                    </div> 
                    <div class="form-group mb-0">
                        <div>
                            <button type="button" 
                                    class="btn btn-primary waves-effect waves-light mr-1"
                                    onClick="submitForm('#sondeoForm','#notificacionSonde')">
                                <li class="fa fa-save"></li>
                                Guardar
                            </button>
                            <button type="button" class="btn btn-light waves-effect" data-dismiss="modal" >
                                <i class="fa fa-ban" aria-hidden="true"></i>
                                Cancelar
                            </button>
                        </div>
                    </div>
            </div>

            
        </form>
      </div>
    </div>
</div>
                                    
        
@endif
                <div class="col-xl-4">
                    <h4>Subunidades</h4>
                    <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab2" role="tablist" aria-orientation="vertical">
                        <a class="nav-link mb-2 btn-outline-danger  border" id="v-pills-social-tab2" data-toggle="pill" href="#v-pills-social2" role="tab" aria-controls="v-pills-social2"
                            aria-selected="true">Centro de Estudio de Opinión Publica (CEOP)</a>
                        <a class="nav-link mb-2 btn-outline-danger border" id="v-pills-profile-tab2" data-toggle="pill" href="#v-pills-profile2" role="tab" aria-controls="v-pills-profile2"
                            aria-selected="false">Centro de Investigación Ambiental</a>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row--> 
        </div> <!-- end card-box -->
    </div> <!-- end container -->
</div> 
@endsection