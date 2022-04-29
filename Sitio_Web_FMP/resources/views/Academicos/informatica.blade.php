@extends('Pagina/baseOnlyHtml')
@section('header')
@auth 
@if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-I'))
    <!-- Este css se carga nada mas cuando esta logeado un usuario-->
    <link href="{{ asset('css/dropzone.min.css') }} " rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/summernote-bs4.css') }}" rel="stylesheet" />
@endif
@endauth    
@endsection

@section('footer')
    @auth
    @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-I'))
    <script src=" {{ asset('js/dropzone.min.js') }} "></script>   
    <script src=" {{ asset('js/scripts/dropzonePdf.js') }} "></script>
    <script src=" {{ asset('js/scripts/pdf.js') }} "></script>
    <script src="{{ asset('js/scripts/http.min.js') }}"></script>
    <script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('js/summernote.config.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/lang/summernote-es-ES.js') }}"></script>
    @endif
    @endauth
@endsection
@section('container')
<div class="wrapper">
    <div class="container-fluid">
        <!-- start page title -->
        <div class="page-title-box color-boton py-2 rounded">
            <h2 class="page-title text-white">Facultad Multidisciplinaria Paracentral</h2>
        </div>         
        <div class="my-3"></div>
        <!-- end page title -->
        <div class="card-box"> 
            <div class="row">
                <div class="col-xl-8">
                    <h4 class="header-title">Ingeniería de Sistemas Informáticos</h4>   
                    <!--                         
                            <p class="mb-1 font-weight-bold ">Código:</p>
                            <p class="text-muted font-15 text-justify">I70515</p>
                            <p class="mb-1 font-weight-bold">Descripción:</p>
                            <p class="text-muted font-15 text-justify">
                                La Carrera de INGENIERIA DE SISTEMAS INFORMATICOS, tiene como objetivo preparar Profesionales con conocimientos científicos y una habilidad creadora tal, que le permita identificar problemas y formular soluciones integrales a sistema informáticos en empresas públicas y privadas.
                            </p> 
                            <p class="mb-1 font-weight-bold">Objetivos:</p>
                            <ul>
                                <li>
                                    <p class="text-muted font-15">
                                        Formar profesionales en el campo de la informática.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Instruir al estudiante en el aprovechamiento de la Tecnología informática como herramienta de apoyo a la Gestión empresarial.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Capacitar al estudiante en la aplicación de técnicas de programación actualizadas y en el uso de lenguajes de programación científicos y comerciales.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Formar al estudiante en el análisis, diseño, implantación, operación y optimización de los sistemas de información.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Preparar al estudiante que pueda organizar y/o administrar empresas consultoras de servicios en el área informática.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Desarrollar al estudiante como Consultor en formulación, evaluación y gestión de proyectos informáticos.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Instruir al estudiante en los conocimientos destinados a mejorar aspectos de la gestión administrativa aplicada a la función informática de empresas e institucionales.
                                    </p>
                                </li>
                            </ul>
                            
    
                            <p class="mb-1 font-weight-bold"> Descripción de áreas curriculares de formación:</p>
                            <ul>
                                <li>
                                    <p class="text-muted font-15">
                                        Formación básica de Ingeniería:<br>
                                        22% - Se imparten asignaturas para que el estudiante domine conocimientos generales de Matemática, Ciencias Físicas, Estadística, Economía.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Formación en Ciencias Humanísticas:<br>
                                        6% - Le permite tener un enfoque orientado a la solución de los problemas de la sociedad, considerando los efectos que estas soluciones pueden tener sobre el tema.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Formación en Ciencias de Ingeniería: <br>
                                        19% - Comprende las asignaturas de apoyo a la carrera, tales como Análisis Numérico, Métodos de Optimización e Ingeniería Económica.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Formación Profesional en informática: <br>
                                        40% - Comprende los conocimientos técnicos generales de la Carrera:Teoría de Sistemas, Bases de Datos, Estructura de Datos, técnicas de programación, técnicas de Intercambio de Información (comunicaciones), etc.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Formación Especializada en informática:<br>
                                        13% - Proporcionando el área de especialización y las operaciones correspondientes.
                                    </p>
                                </li>            
                            </ul>
                            <p class="text-muted font-15">
                                La relación practica-teórica se da a través del transcurso de toda la carrera
                            </p>

                            <p class="mb-1 font-weight-bold">Tiempo de duración:</p>  
                            <p class="text-muted font-15">
                                5 años.
                            </p> 

                            <p class="mb-1 font-weight-bold">Grado y título que otorga:</p>  
                            <p class="text-muted font-15">
                                Ingeniero (a) de sistemas informáticos
                            </p>
                        -->
                        <?php
                        $variableNoTocar = 'localizacion';
                        $localizacion ='informatica';
                        $contenido = App\Models\Pagina\ContenidoHtml::where($variableNoTocar,$localizacion)->first();
                        
                        ?>
                        @auth
                        @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-I'))
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
                        
                        @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-Depto-I|Pagina-Admin|super-admin'))
                        <div class="col-xl-12 py-2">
                        @if ($contenido!=null)
                        {!!$contenido->contenido!!}
                        @endif
                        </div>      
                        @endif
                            <p class="mb-1 font-weight-bold">Pensum:</p>
                            <a href="{{$pdfs->where('file','ingSistemas.pdf')->first()==null 
                                ? '#':asset('files/pdfs/'.$pdfs[0]->localizacion.'/ingSistemas.pdf')}}"
                                 type="submit" class="btn btn-outline-danger" id="ingSistemas" target="_blank">
                                    <div class="mdi mdi-file-pdf mdi-24px align-top">Descargar</div>
                            </a>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-I'))
                            <a href="#" class="btn  btn-outline-info my-2" 
                            data-toggle="modal" data-target=".bs-example-modal-center" onclick="pdf('ingSistemas')">
                                <i class="mdi mdi-cloud-upload mdi-24px ml-2 align-center"></i> Subir Archivo
                            </a>
                            @endif
                            @endauth 
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-I'))
                            <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;" id="dropZonePdf">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="myCenterModalLabel">Zona para subir PDF</h4>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            
                                            <form action="{{ route('PDF', ['localizacion'=>'info']) }}" method="post"
                                                class="dropzone" id="my-awesome-dropzone">
                                                @csrf                                 
                                                <input type="hidden" name='pdf' id="pdf">
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
                            @endauth
                    </div>
                
            </div> <!-- end row--> 
        </div> <!-- end card-box -->

    </div> <!-- end container-->
</div>
<!-- end row -->
@endsection