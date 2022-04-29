@extends('Pagina/baseOnlyHtml')
@section('header')
    @auth
    @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
        <!-- Este css se carga nada mas cuando esta logeado un usuario-->
        <link href="{{ asset('css/dropzone.min.css') }} " rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/summernote-bs4.css') }}" rel="stylesheet" />
    @endif
    @endauth
@endsection

@section('footer')
    @auth
        @if (@Auth::user()->hasRole('super-admin') || @Auth::user()->hasRole('Pagina-Admin') || @Auth::user()->hasRole('Pagina-Depto-CDE'))
            <script src="{{ asset('js/scripts/http.min.js') }}"></script>

            <script src=" {{ asset('js/dropzone.min.js') }} "></script>
            <script src=" {{ asset('js/scripts/dropzonePdf.js') }} "></script>
            <script src=" {{ asset('js/scripts/pdf.js') }} "></script>

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
                    <div class="col-xl-8 px-3">
                        <div class="tab-content pt-0" id="v-pills-tabContent">
                            <div class="tab-pane fade active show" id="v-pills-social2" role="tabpanel"
                                aria-labelledby="v-pills-social-tab2">
                                <h2 class="header-title py-2">Licenciatura en Trabajo Social</h2>
                                <!--                            
                                <p class="mb-1 font-weight-bold ">Código:</p>
                                <p class="text-muted font-15 text-justify">L10439</p>
                                <p class="mb-1 font-weight-bold">Descripción:</p>
                                <p class="text-muted font-15 text-justify">
                                    La Licenciatura en Trabajo Social en la UES nace a iniciativa del personal docente de la Escuela de Trabajo Social y se concretiza por medio de un Convenio entre el Gobierno de la República de El Salvador a través del Ministerio de Educación y la Universidad de El Salvador, firmado el 20 de mayo de 1999.
                                </p>  
                                <p class="mb-1 font-weight-bold">Objetivo:</p>
                                <p class="text-muted font-15 text-justify">
                                    Formar profesionales en Trabajo Social, con fundamentación humanista, teórica-técnica-metodológica con un marco axiológico sólido que contribuya al desarrollo de las potencialidades e iniciativas de las personas, grupos y sectores poblacionales que posibiliten la construcción de opciones y alternativas tendientes a la promoción y transformación de la realidad.
                                </p>                                             
        
                                <p class="mb-1 font-weight-bold">Tiempo de duración de la carrera:</p>
                                <p class="text-muted font-15">
                                    5 años (10 ciclos).
                                </p>
        
                                <p class="mb-1 font-weight-bold">Grado y título que otorga:</p>
                                <p class="text-muted font-15">
                                    Licenciado (a) en trabajo social.
                                </p>
                            -->
                                <?php
                                $variableNoTocar = 'localizacion';
                                $localizacion = 'licTrabajoSocial';
                                $contenido = App\Models\Pagina\ContenidoHtml::where($variableNoTocar, $localizacion)->first();
                                
                                ?>

                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))


                                <div class="col-xl-12">
                                    <form action="{{ route('contenido', ['localizacion' => $localizacion]) }}"
                                        method="POST" class="parsley-examples" id="contenido{{ $localizacion }}">
                                        @csrf
                                        <div class="alert alert-primary text-white py-1" role="alert"
                                            style="display:none" id="notificacion{{ $localizacion }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <textarea value="" class="form-control summernote-config"
                                                        name="contenido" rows="10">
                                                @if ($contenido != null)
                                                    {{ $contenido->contenido }}
                                                @endif
                                            </textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <button type="button"
                                                        class="btn btn-primary waves-effect waves-light btn-block"
                                                        onclick="submitForm('#contenido{{ $localizacion }}','#notificacion{{ $localizacion }}')">
                                                        <i class="fa fa-save fa-5 ml-3"></i> Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>

                            @endif
                        @endauth
                      
                         @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-Depto-CDE|Pagina-Admin|super-admin'))
                                <div class="col-xl-12 py-2">
                                    @if ($contenido != null)
                                        {!! $contenido->contenido !!}
                                    @endif
                                </div>
                        @endif  
                        
                            <p class="mb-1 font-weight-bold">Pensum:</p>
                            <a href="{{ $pdfs->where('file', 'LicSocial.pdf')->first() == null ? '#' : asset('files/pdfs/' . $pdfs[0]->localizacion . '/LicSocial.pdf') }}"
                                type="submit" class="btn btn-outline-danger" id="LicSocial" target="_blank">
                                <div class="mdi mdi-file-pdf mdi-24px align-top">Descargar</div>
                            </a>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <a href="#" class="btn  btn-outline-info my-2" data-toggle="modal"
                                    data-target=".bs-example-modal-center" onclick="pdf('LicSocial')">
                                    <i class="mdi mdi-cloud-upload mdi-24px ml-2 align-center"></i> Subir Archivo
                                </a>
                            @endif
                            @endauth
                        </div>
                        <div class="tab-pane fade" id="v-pills-profile2" role="tabpanel"
                            aria-labelledby="v-pills-profile-tab2">
                            <h2 class="header-title py-2">Profesorado en Educación Básica para Primero y Segundo Ciclos
                            </h2>
                            <!--
                            <p class="mb-1 font-weight-bold ">Código:</p>
                            <p class="text-muted font-15 text-justify">P70402</p>
                            <p class="mb-1 font-weight-bold">Descripción:</p>
                            <p class="text-muted font-15 text-justify">
                                El Profesorado en Educación Básica para Primero y Segundo Ciclos está diseñado para formar maestros/as con capacidad científica, técnica, pedagógica y ética, para el ejercicio profesional de la docencia en el nivel de educación básica para primero y segundo ciclos, los cuales trabajarían con niños y niñas entre 7 y 12 años.
                            </p> 
                            <p class="text-muted font-15 text-justify">
                                Esta especialidad se ofrece en seis ciclos, con una duración mínima de tres años, con un total de 23 asignaturas, en cuyo desarrollo gradual se contemplan tres componentes que se articulan simultáneamente desde el inicio hasta el final del plan de estudios.
                            </p>
                            <p class="text-muted font-15 text-justify">
                                El primero de ellos tiene como propósito la formación general, común a todos los profesorados y se tratará en 9 cursos; un segundo componente está referido a la formación especializada, que centra su interés en el dominio de los contenidos curriculares y los conocimientos específicos de estrategias didácticas, necesario para su desempeño docente; este componente se desarrolla en 9 cursos; y un tercer componente que corresponde a la práctica docente, en la que se observará y reflexionará las situaciones reales de enseñanza-aprendizaje del nivel de educación básica para primero y segundo ciclo.
                            </p>
                                            
                            <p class="mb-1 font-weight-bold">Tiempo de duración de la carrera:

                            </p>
                            <p class="text-muted font-15">
                                3 años.
                            </p>
    
                            <p class="mb-1 font-weight-bold">Grado y título que otorga:</p>
                            <p class="text-muted font-15">
                                Profesor (a) en educación básica para primero y segundo ciclo.
                            </p>
                        -->

                            <?php
                            $variableNoTocar = 'localizacion';
                            $localizacion = 'profesoradoBasica';
                            $contenido = App\Models\Pagina\ContenidoHtml::where($variableNoTocar, $localizacion)->first();
                            
                            ?>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <div class="col-xl-12">
                                    <form action="{{ route('contenido', ['localizacion' => $localizacion]) }}"
                                        method="POST" class="parsley-examples" id="contenido{{ $localizacion }}">
                                        @csrf
                                        <div class="alert alert-primary text-white py-1" role="alert" style="display:none"
                                            id="notificacion{{ $localizacion }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <textarea value="" class="form-control summernote-config"
                                                        name="contenido" rows="10">
                            @if ($contenido != null)
                                {{ $contenido->contenido }}
                            @endif
                        </textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <button type="button"
                                                        class="btn btn-primary waves-effect waves-light btn-block"
                                                        onclick="submitForm('#contenido{{ $localizacion }}','#notificacion{{ $localizacion }}')">
                                                        <i class="fa fa-save fa-5 ml-3"></i> Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @endauth

                             @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-Depto-CDE|Pagina-Admin|super-admin'))
                                <div class="col-xl-12 py-2">
                                    @if ($contenido != null)
                                        {!! $contenido->contenido !!}
                                    @endif
                                </div>
                            @endif





                            <p class="mb-1 font-weight-bold">Pensum:</p>
                            <a href="{{ $pdfs->where('file', 'profeBasica.pdf')->first() == null ? '#' : asset('files/pdfs/' . $pdfs[0]->localizacion . '/profeBasica.pdf') }}"
                                type="submit" class="btn btn-outline-danger" id="profeBasica" target="_blank">
                                <div class="mdi mdi-file-pdf mdi-24px align-top">Descargar</div>
                            </a>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <a href="#" class="btn  btn-outline-info my-2" data-toggle="modal"
                                    data-target=".bs-example-modal-center" onclick="pdf('profeBasica')">
                                    <i class="mdi mdi-cloud-upload mdi-24px ml-2 align-center"></i> Subir Archivo
                                </a>
                            @endif
                            @endauth
                        </div>
                        <div class="tab-pane fade" id="v-pills-messages2" role="tabpanel"
                            aria-labelledby="v-pills-messages-tab2">
                            <h2 class="header-title py-2">Profesorado en Matemática para Tercer Ciclo de Educación
                                Básica y Educación Media</h2>
                            <!--
                            <p class="mb-1 font-weight-bold ">Código:</p>
                            <p class="text-muted font-15 text-justify">
                                P70923
                            </p>
                            <p class="mb-1 font-weight-bold">Descripción:</p>
                            <p class="text-muted font-15 text-justify">
                                La carrera de Profesorado en Matemática para tercer ciclo de Educación básica y Educación Media, permite capacitar al profesional dentro  la  realidad educativa nacional, para que contribuya a fomentar el aprendizaje de la Matemática como ente renovador en la disciplina,  adquiriendo  una  adecuada  formación  docente  e investigativa, lo que permitirá una mejor comprensión del proceso enseñanza aprendizaje de la Matemática.
                            </p>  
                            <p class="mb-1 font-weight-bold">Objetivos:</p>
                            <p class="text-muted font-15 text-justify">
                                Los objetivos de la carrera se sintetizan en el rescate del proceso constructivo del aprendizaje de la Matemática para modificar la actual orientación del proceso.
                            </p> 

                            <p class="text-muted font-15 text-justify">
                                Para ello proponemos:
                            </p>

                            <ul>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Formar personal especializado en la ecuación Matemática para el nivel medio, que propicie un  aprendizaje  agradable de  la Matemática; Promover la elaboración de material didáctico en Matemática;
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Promover la elaboración de material didáctico en Matemática;
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Impulsar la didáctica de la Matemática;
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Mejorar la relación cuali-cuantitativa del personal docente de dedicado a la Matemática a fin de habilitar el proceso en el seguimiento de estudios posteriores de la especialización.
                                    </p>
                                </li>
                            </ul>

                            <p class="mb-1 font-weight-bold">Tiempo de duración de la carrera:

                            </p>
                            <p class="text-muted font-15">
                                3 años.
                            </p>
    
                            <p class="mb-1 font-weight-bold">Grado y título que otorga:</p>
                            <p class="text-muted font-15">
                                Profesor  (a)  en matemática para tercer ciclo de educación básica y educación media.
                            </p>
                        -->


                            <?php
                            $variableNoTocar = 'localizacion';
                            $localizacion = 'profesoradoMatematica';
                            $contenido = App\Models\Pagina\ContenidoHtml::where($variableNoTocar, $localizacion)->first();
                            
                            ?>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <div class="col-xl-12">
                                    <form action="{{ route('contenido', ['localizacion' => $localizacion]) }}"
                                        method="POST" class="parsley-examples" id="contenido{{ $localizacion }}">
                                        @csrf
                                        <div class="alert alert-primary text-white py-1" role="alert" style="display:none"
                                            id="notificacion{{ $localizacion }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <textarea value="" class="form-control summernote-config"
                                                        name="contenido" rows="10">
                            @if ($contenido != null)
                                {{ $contenido->contenido }}
                            @endif
                        </textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <button type="button"
                                                        class="btn btn-primary waves-effect waves-light btn-block"
                                                        onclick="submitForm('#contenido{{ $localizacion }}','#notificacion{{ $localizacion }}')">
                                                        <i class="fa fa-save fa-5 ml-3"></i> Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @endauth

                             @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-Depto-CDE|Pagina-Admin|super-admin'))
                                <div class="col-xl-12 py-2">
                                    @if ($contenido != null)
                                        {!! $contenido->contenido !!}
                                    @endif
                                </div>
                            @endif




                            <p class="mb-1 font-weight-bold">Pensum:</p>
                            <a href="{{ $pdfs->where('file', 'profeMate.pdf')->first() == null ? '#' : asset('files/pdfs/' . $pdfs[0]->localizacion . '/profeMate.pdf') }}"
                                type="submit" class="btn btn-outline-danger" id="profeMate" target="_blank">
                                <div class="mdi mdi-file-pdf mdi-24px align-top">Descargar</div>
                            </a>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <a href="#" class="btn  btn-outline-info my-2" data-toggle="modal"
                                    data-target=".bs-example-modal-center" onclick="pdf('profeMate')">
                                    <i class="mdi mdi-cloud-upload mdi-24px ml-2 align-center"></i> Subir Archivo
                                </a>
                            @endif
                            @endauth
                        </div>
                        <div class="tab-pane fade" id="v-pills-settings2" role="tabpanel"
                            aria-labelledby="v-pills-settings-tab2">
                            <h2 class="header-title py-2">Profesorado en Idioma Inglés Para Tercer Ciclo de Educación
                                Básica y Educación Media</h2>
                            <!--
                            <p class="mb-1 font-weight-bold ">Código:</p>
                            <p class="text-muted font-15 text-justify">P70430</p>
                            <p class="mb-1 font-weight-bold">Descripción:</p>
                            <p class="text-muted font-15 text-justify">
                                Este currículo está estructurado en seis ciclos con un total de 22 asignaturas. Contiene tres áreas: de Formación General Básica, de Formación Especializada y de Práctica Docente e Investigación Educativa.
                            </p>
                                            
                            <p class="mb-1 font-weight-bold">Tiempo de duración de la carrera:

                            </p>
                            <p class="text-muted font-15">
                                3 años.
                            </p>
    
                            <p class="mb-1 font-weight-bold">Grado y título que otorga:</p>
                            <p class="text-muted font-15">
                                Profesor (a) en inglés para tercer ciclo de educación básica y educación media.
                            </p>
                        -->

                            <?php
                            $variableNoTocar = 'localizacion';
                            $localizacion = 'profesoradoIngles';
                            $contenido = App\Models\Pagina\ContenidoHtml::where($variableNoTocar, $localizacion)->first();
                            
                            ?>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <div class="col-xl-12">
                                    <form action="{{ route('contenido', ['localizacion' => $localizacion]) }}"
                                        method="POST" class="parsley-examples" id="contenido{{ $localizacion }}">
                                        @csrf
                                        <div class="alert alert-primary text-white py-1" role="alert" style="display:none"
                                            id="notificacion{{ $localizacion }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <textarea value="" class="form-control summernote-config"
                                                        name="contenido" rows="10">
                            @if ($contenido != null)
                                {{ $contenido->contenido }}
                            @endif
                        </textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <button type="button"
                                                        class="btn btn-primary waves-effect waves-light btn-block"
                                                        onclick="submitForm('#contenido{{ $localizacion }}','#notificacion{{ $localizacion }}')">
                                                        <i class="fa fa-save fa-5 ml-3"></i> Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @endauth

                             @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-Depto-CDE|Pagina-Admin|super-admin'))
                                <div class="col-xl-12 py-2">
                                    @if ($contenido != null)
                                        {!! $contenido->contenido !!}
                                    @endif
                                </div>
                            @endif




                            <p class="mb-1 font-weight-bold">Pensum:</p>
                            <a href="{{ $pdfs->where('file', 'profeIngles.pdf')->first() == null ? '#' : asset('files/pdfs/' . $pdfs[0]->localizacion . '/profeIngles.pdf') }}"
                                type="submit" class="btn btn-outline-danger" id="profeIngles" target="_blank">
                                <div class="mdi mdi-file-pdf mdi-24px align-top">Descargar</div>
                            </a>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <a href="#" class="btn  btn-outline-info my-2" data-toggle="modal"
                                    data-target=".bs-example-modal-center" onclick="pdf('profeIngles')">
                                    <i class="mdi mdi-cloud-upload mdi-24px ml-2 align-center"></i> Subir Archivo
                                </a>
                            @endif
                            @endauth
                        </div>
                        <div class="tab-pane fade" id="v-pills-biologia2" role="tabpanel"
                            aria-labelledby="v-pills-biologia-tab2">
                            <h2 class="header-title py-2">
                                Profesorado en Biología para Tercer Ciclo en Educación Básica y Educación Media
                            </h2>
                            <!--     
                            <p class="mb-1 font-weight-bold">Objetivos:</p>
                            <ul>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Individualizar y examinar los contenidos teórico conceptuales propios de las disciplinas de Ciencias Naturales. 
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Analizar e interpretar las orientaciones metodológicas que se derivan de cada una de esas disciplinas. 
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Reflexionar sobre las actitudes que deben caracterizar a quienes se desenvuelven en las ciencias naturales, ya sea como docentes o investigadores. 
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Fomentar una comprensión global del quehacer de las ciencias naturales en la sociedad y en la vida cotidiana. 
                                    </p>
                                </li>
                            </ul>

                            <p class="mb-1 font-weight-bold">Perfil del profesor (a) en biología:</p>
                            <ul>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Habilidades intelectuales específicas. 
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Dominio de los objetivos y los contenidos de la educación del Tercer Ciclo y del Bachillerato. 
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Competencias didácticas. 
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Identidad profesional y ética. 
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15 text-justify">
                                        Capacidad de percepción y respuesta a las condiciones sociales del entorno de la institución. 
                                    </p>
                                </li>
                            </ul>
                                            
                            <p class="mb-1 font-weight-bold">Tiempo de duración de la carrera:</p>
                            <p class="text-muted font-15">
                                3 años.
                            </p>
    
                            <p class="mb-1 font-weight-bold">Grado y título que otorga:</p>
                            <p class="text-muted font-15">
                                Profesor o profesora de Biología para Tercer Ciclo de Educación Básica y Educación Media. 
                            </p>
                        -->
                            <?php
                            $variableNoTocar = 'localizacion';
                            $localizacion = 'profesoradoBiologia';
                            $contenido = App\Models\Pagina\ContenidoHtml::where($variableNoTocar, $localizacion)->first();
                            
                            ?>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <div class="col-xl-12">
                                    <form action="{{ route('contenido', ['localizacion' => $localizacion]) }}"
                                        method="POST" class="parsley-examples" id="contenido{{ $localizacion }}">
                                        @csrf
                                        <div class="alert alert-primary text-white py-1" role="alert" style="display:none"
                                            id="notificacion{{ $localizacion }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <textarea value="" class="form-control summernote-config"
                                                        name="contenido" rows="10">
                                                    @if ($contenido != null)
                                                        {{ $contenido->contenido }}
                                                    @endif
                                                </textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <button type="button"
                                                        class="btn btn-primary waves-effect waves-light btn-block"
                                                        onclick="submitForm('#contenido{{ $localizacion }}','#notificacion{{ $localizacion }}')">
                                                        <i class="fa fa-save fa-5 ml-3"></i> Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @endauth

                             @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-Depto-CDE|Pagina-Admin|super-admin'))
                                <div class="col-xl-12 py-2">
                                    @if ($contenido != null)
                                        {!! $contenido->contenido !!}
                                    @endif
                                </div>
                            @endif

                            <p class="mb-1 font-weight-bold">Pensum:</p>
                            <a href="{{ $pdfs->where('file', 'profeBiolo.pdf')->first() == null ? '#' : asset('files/pdfs/' . $pdfs[0]->localizacion . '/profeBiolo.pdf') }}"
                                type="submit" class="btn btn-outline-danger" id="profeBiolo" target="_blank">
                                <div class="mdi mdi-file-pdf mdi-24px align-top">Descargar</div>
                            </a>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <a href="#" class="btn  btn-outline-info my-2" data-toggle="modal"
                                    data-target=".bs-example-modal-center" onclick="pdf('profeBiolo')">
                                    <i class="mdi mdi-cloud-upload mdi-24px ml-2 align-center"></i> Subir Archivo
                                </a>
                            @endif
                            @endauth
                        </div>
                        <div class="tab-pane fade" id="v-pills-parvularia2" role="tabpanel"
                            aria-labelledby="v-pills-parvularia-tab2">
                            <h2 class="header-title py-2">Profesorado en Educación Inicial y Parvularia</h2>
                            <!--
                            <p class="mb-1 font-weight-bold ">Código:</p>
                            <p class="text-muted font-15 text-justify">P70403</p>
                            <p class="mb-1 font-weight-bold">Descripción:</p>
                            <p class="text-muted font-15 text-justify">
                                Se espera que el estudiantado al finalizar el Profesorado en Educación Inicial y Parvularia logre  las siguientes competencias:
                            </p>
                            <ul>
                                <li>
                                    <p class="text-muted font-15">
                                        Aplicar teorías y enfoques recientes que ayuden a fundamentar las áreas de la formación de inicial y parvularia.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Aplicar la teoría y metodología curricular de la formación inicial y parvularia que orienten acciones educativas de diseño, ejecución y evaluación.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Comprometerse y responsabilizarse con el desarrollo personal y profesional en forma permanente.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Desarrollar habilidades comunicativas como parte integral de la formación personal y profesional.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Aplicar estrategias metodológicas que fortalezcan la inclusión, los derechos de la niñez y la atención a la diversidad.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Orientar y facilitar procesos de cambio en la comunidad con acciones educativas de carácter interdisciplinario.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Aplicar estrategias metodológicas lúdicas y placenteras con enfoque globalizador en educación infantil.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Seleccionar y elaborar recursos educativos utilizando materiales reciclables y del medio ambiente atendiendo a cada etapa evolutiva y a la diversidad socio- cultural.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Desarrollar el pensamiento lógico, crítico y creativo de las niñas y los niños para la resolución de problemas de la vida diaria.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Diseñar, implementar y evaluar procesos de aprendizaje que integren a personas con discapacidad.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Seleccionar, utilizar y evaluar las tecnologías de la comunicación e información como recurso de enseñanza y aprendizaje.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Investigar y generar innovaciones en distintos ámbitos del sistema educativo.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Promover el desarrollo en educación en valores, equidad de género, medio ambiente, formación ciudadana, democracia y cultura de paz.
                                    </p>
                                </li>

                            </ul>
                            <p class="mb-1 font-weight-bold">Objetivos:</p>
                            <ul>
                                <li>
                                    <p class="text-muted font-15">
                                        Analizar la relevancia de la educación en la niñez y el rol de la persona educadora en esta etapa, con el fin de valorar su incidencia en el desarrollo de la personalidad infantil.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Desarrollar actitudes críticas, profesionales, éticas, investigativas y cualidades de personalidad equilibrada, necesarias para orientar el proceso educativo infantil.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Promover y facilitar, desde una perspectiva integradora, estrategias educativas para el trabajo con niñez de 0 a 7 años de edad en sus dimensiones cognitiva, emocional, psicomotora y social.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Identificar la diversidad de modalidades de atención educativa de niñez de 0 a 7 años de edad, para favorecer el desarrollo integral de la niñez.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Propiciar aprendizajes significativos con un enfoque globalizador en ambientes que favorezcan el desarrollo integral del niño y la niña, reconociendo y estimulando las singularidades educativas, la equidad de género y el respeto a los derechos humanos.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Identificar los factores de riesgo que amenazan el desarrollo integral infantil, con el fin de prevenir y reducir estos efectos en la infancia.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Indagar las diversas etapas del desarrollo evolutivo de la niñez de 0 a 7 años, períodos significativos, etapas de aprendizaje y estrategias didácticas, para favorecer la estimulación en cada período de edad de la niñez.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Orientar, mediante un trabajo colaborativo, a familias, centros educativos y comunidad, en los procesos educativos y de desarrollo de la niñez de 0 a 7 años, con el fin de establecer vínculos de cooperación para la mejora de la calidad educativa.
                                    </p>
                                </li>
                                <li>
                                    <p class="text-muted font-15">
                                        Innovar y mejorar la labor educativa en el nivel de inicial y parvularia de 0 a 7 años, a través de la reflexión-acción de la práctica docente.
                                    </p>
                                </li>
                            </ul>
                                            
                            <p class="mb-1 font-weight-bold">Tiempo de duración de la carrera:</p>
                            <p class="text-muted font-15">
                                3 Años (6 ciclos) , 30 materias, 123 Unidades Valorativas.
                            </p>
    
                            <p class="mb-1 font-weight-bold">Grado y título que otorga:</p>
                            <p class="text-muted font-15">
                                Profesor (a) en educación inicial y parvularia.
                            </p>
                        -->

                            <?php
                            $variableNoTocar = 'localizacion';
                            $localizacion = 'parvularia';
                            $contenido = App\Models\Pagina\ContenidoHtml::where($variableNoTocar, $localizacion)->first();
                            
                            ?>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <div class="col-xl-12">
                                    <form action="{{ route('contenido', ['localizacion' => $localizacion]) }}"
                                        method="POST" class="parsley-examples" id="contenido{{ $localizacion }}">
                                        @csrf
                                        <div class="alert alert-primary text-white py-1" role="alert" style="display:none"
                                            id="notificacion{{ $localizacion }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <textarea value="" class="form-control summernote-config"
                                                        name="contenido" rows="10">
                            @if ($contenido != null)
                                {{ $contenido->contenido }}
                            @endif
                        </textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <button type="button"
                                                        class="btn btn-primary waves-effect waves-light btn-block"
                                                        onclick="submitForm('#contenido{{ $localizacion }}','#notificacion{{ $localizacion }}')">
                                                        <i class="fa fa-save fa-5 ml-3"></i> Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @endauth

                             @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-Depto-CDE|Pagina-Admin|super-admin'))
                                <div class="col-xl-12 py-2">
                                    @if ($contenido != null)
                                        {!! $contenido->contenido !!}
                                    @endif
                                </div>
                            @endif

                            <p class="mb-1 font-weight-bold">Pensum:</p>
                            <a href="{{ $pdfs->where('file', 'profeParvularia.pdf')->first() == null ? '#' : asset('files/pdfs/' . $pdfs[0]->localizacion . '/profeParvularia.pdf') }}"
                                type="submit" class="btn btn-outline-danger" id="profeParvularia" target="_blank">
                                <div class="mdi mdi-file-pdf mdi-24px align-top">Descargar</div>
                            </a>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <a href="#" class="btn  btn-outline-info my-2" data-toggle="modal"
                                    data-target=".bs-example-modal-center" onclick="pdf('profeParvularia')">
                                    <i class="mdi mdi-cloud-upload mdi-24px ml-2 align-center"></i> Subir Archivo
                                </a>
                            @endif
                            @endauth

                        </div>
                        <div class="tab-pane fade" id="v-pills-licenciatura2" role="tabpanel"
                            aria-labelledby="v-pills-licenciatura-tab2">
                            <h2 class="header-title py-2">Licenciatura en Enseñanza de Idiomas Extranjeros,
                                Especialidad Inglés-Francés</h2>
                            <!--
                            <p class="mb-1 font-weight-bold">Descripción:</p>
                            <p class="text-muted font-15 text-justify">
                                El plan de estudios ofrece al estudiante una preparación primordialmente lingüística en dos idiomas: ingles y Francés; también ofrece un tronco de materias electivas con dos especialidades menores: en la enseñanza y en las relaciones publicas; la elección de cualquiera de estas especialidades menores dependerá de los objetivos del estudiante. Toda la formación lingüística esta orientada profesionalmente para la inserción laboral de los participantes a través del uso de estas lenguas en por lo menos los dos campos mencionados anteriormente.
                            </p>

                            <p class="mb-1 font-weight-bold">Tiempo de duración de la carrera:</p>
                            <p class="text-muted font-15">
                                5 años.
                            </p>
    
                            <p class="mb-1 font-weight-bold">Grado y título que otorga:</p>
                            <p class="text-muted font-15">
                                Licenciado (a) en enseñanza de idiomas extranjeros, especialidad inglés-francés.
                            </p>
                        -->
                            <?php
                            $variableNoTocar = 'localizacion';
                            $localizacion = 'licenciaturaInglesFrances';
                            $contenido = App\Models\Pagina\ContenidoHtml::where($variableNoTocar, $localizacion)->first();
                            
                            ?>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <div class="col-xl-12">
                                    <form action="{{ route('contenido', ['localizacion' => $localizacion]) }}"
                                        method="POST" class="parsley-examples" id="contenido{{ $localizacion }}">
                                        @csrf
                                        <div class="alert alert-primary text-white py-1" role="alert" style="display:none"
                                            id="notificacion{{ $localizacion }}">
                                        </div>
                                        <div class="row">
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <textarea value="" class="form-control summernote-config"
                                                        name="contenido" rows="10">
                            @if ($contenido != null)
                                {{ $contenido->contenido }}
                            @endif
                        </textarea>
                                                </div>
                                            </div>
                                            <div class="col-xl-12">
                                                <div class="form-group">
                                                    <button type="button"
                                                        class="btn btn-primary waves-effect waves-light btn-block"
                                                        onclick="submitForm('#contenido{{ $localizacion }}','#notificacion{{ $localizacion }}')">
                                                        <i class="fa fa-save fa-5 ml-3"></i> Guardar
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            @endif
                            @endauth

                             @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-Depto-CDE|Pagina-Admin|super-admin'))
                                <div class="col-xl-12 py-2">
                                    @if ($contenido != null)
                                        {!! $contenido->contenido !!}
                                    @endif
                                </div>
                            @endif

                            <p class="mb-1 font-weight-bold">Pensum:</p>
                            <a href="{{ $pdfs->where('file', 'licEspInglesFrances.pdf')->first() == null ? '#' : asset('files/pdfs/' . $pdfs[0]->localizacion . '/licEspInglesFrances.pdf') }}"
                                type="submit" class="btn btn-outline-danger" id="licEspInglesFrances" target="_blank">
                                <div class="mdi mdi-file-pdf mdi-24px align-top">Descargar</div>
                            </a>
                            @auth
                            @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                                <a href="#" class="btn  btn-outline-info my-2" data-toggle="modal"
                                    data-target=".bs-example-modal-center" onclick="pdf('licEspInglesFrances')">
                                    <i class="mdi mdi-cloud-upload mdi-24px ml-2 align-center"></i> Subir Archivo
                                </a>
                            @endif
                            @endauth
                        </div>
                    </div>
                    @auth
                    @if (@Auth::user()->hasRole('super-admin|Pagina-Admin|Pagina-Depto-CDE'))
                        <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
                            aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;" id="dropZonePdf">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myCenterModalLabel">Zona para subir PDF</h4>
                                        <button type="button" class="close" data-dismiss="modal"
                                            aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">

                                        <form action="{{ route('PDF', ['localizacion' => 'ccEdu']) }}" method="post"
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
                </div> <!-- end col -->
                <div class="col-xl-4">
                    <h4>Departamentos de Ciencias de la Educación</h4>
                    <div class="nav flex-column nav-pills nav-pills-tab" id="v-pills-tab2" role="tablist"
                        aria-orientation="vertical">
                        <a class="nav-link active show mb-2 btn-outline-danger  border" id="v-pills-social-tab2"
                            data-toggle="pill" href="#v-pills-social2" role="tab" aria-controls="v-pills-social2"
                            aria-selected="true">
                            Licenciatura en Trabajo Social</a>
                        <a class="nav-link mb-2 btn-outline-danger border" id="v-pills-profile-tab2" data-toggle="pill"
                            href="#v-pills-profile2" role="tab" aria-controls="v-pills-profile2" aria-selected="false">
                            Profesorado en Educación Básica para Primero y Segundo Ciclos</a>
                        <a class="nav-link mb-2 btn-outline-danger border" id="v-pills-messages-tab2"
                            data-toggle="pill" href="#v-pills-messages2" role="tab" aria-controls="v-pills-messages2"
                            aria-selected="false">
                            Profesorado en Matemática para Tercer Ciclo de Educación Básica y Educación Media</a>
                        <a class="nav-link mb-2 btn-outline-danger border" id="v-pills-settings-tab2"
                            data-toggle="pill" href="#v-pills-settings2" role="tab" aria-controls="v-pills-settings2"
                            aria-selected="false">
                            Profesorado en Idioma Inglés Para Tercer Ciclo de Educación Básica y Educación Media</a>
                        <a class="nav-link mb-2 btn-outline-danger border" id="v-pills-biologia-tab2"
                            data-toggle="pill" href="#v-pills-biologia2" role="tab" aria-controls="v-pills-biologia2"
                            aria-selected="false">
                            Profesorado en Biología para Tercer Ciclo en Educación Básica y Educación Media</a>
                        <a class="nav-link mb-2 btn-outline-danger border" id="v-pills-parvularia-tab2"
                            data-toggle="pill" href="#v-pills-parvularia2" role="tab"
                            aria-controls="v-pills-parvularia2" aria-selected="false">
                            Profesorado en Educación Inicial y Parvularia</a>
                        <a class="nav-link mb-2 btn-outline-danger border" id="v-pills-licenciatura-tab2"
                            data-toggle="pill" href="#v-pills-licenciatura2" role="tab"
                            aria-controls="v-pills-licenciatura2" aria-selected="false">
                            Licenciatura en Enseñanza de Idiomas Extranjeros, Especialidad Inglés-Francés</a>
                    </div>
                </div> <!-- end col -->
            </div> <!-- end row-->
        </div> <!-- end card-box -->

    </div> <!-- end container-->
</div>
<!-- end row -->
@endsection
