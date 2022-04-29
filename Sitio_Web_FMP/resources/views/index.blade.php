@extends('Pagina/base')

@section('appcss')
    <!-- App favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">
    @auth
        <!-- Este css se carga nada mas cuando esta logeado un usuario-->
        <link href="{{ asset('css/dropzone.min.css') }} " rel="stylesheet" type="text/css" />

        <!-- Summernote css -->
        <link href="{{ asset('css/summernote-bs4.css') }}" rel="stylesheet" />
    @endauth
    <!--Libreria data table para paginacion de noticias-->
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css" />

    <!-- App css -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />

    <div id="fb-root"></div>
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/es_LA/sdk.js#xfbml=1&version=v11.0"
        nonce="qj9mH20N"></script>

@endsection

@section('container')
    @auth
        @if (@Auth::user()->hasRole('Pagina-Inicio-Imagenes|Pagina-Admin|super-admin'))
            <div id="modalCR2" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
                aria-labelledby="myCenterModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar
                            </h3>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('imagenCAborrar', ['url' => 'index']) }}" method="POST">
                                @csrf
                                <div class="row py-3">
                                    <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                                    <div class="col-lg-10 text-black">
                                        <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se elimina este registro
                                            de manera permanente, ¿Desea continuar?</h4>
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
                                        <button type="reset"
                                            class="btn btn-light p-1 waves-light waves-effect btn-block font-24"
                                            data-dismiss="modal">
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
    @endauth


    <div class="wrapper">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="page-title-box color-boton py-2 rounded">
                <a class="page-title text-white h2" href="{{ route('index') }}">Facultad Multidisciplinaria
                    Paracentral</a>
            </div>
            <div class="my-4"></div>
            <!-- end page title -->

            <div class="row">
                <div class="col-xl-8">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card-box">
                                <div class="row py-1">
                                    <div class="col order-first ">
                                        <h3>Facultad Multidisciplinaria Paracentral</h3>
                                    </div>
                                    @auth
                                        @if (@Auth::user()->hasRole('Pagina-Inicio-Imagenes|Pagina-Admin|super-admin'))
                                            <div class="col-lg-3 order-last ">
                                                <a href="" class="btn btn-block btn-info tex-left" data-toggle="modal"
                                                    data-target="#agregarImagenCarrusel">
                                                    <div class="mdi mdi-upload mdi-16px text-center"> Agregar Imagen</div>
                                                </a>
                                            </div>

                                            <div class="modal fade bs-example-modal-center" id='agregarImagenCarrusel'
                                                tabindex="-1" role="dialog" aria-labelledby="myCenterModalLabel"
                                                aria-hidden="true" style="display: none;">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4 class="modal-title" id="myCenterModalLabel">Zona para subir
                                                                imágenes</h4>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">×</button>
                                                        </div>
                                                        <div class="modal-body">

                                                            <form action="{{ route('ImagenFacultad.subir', ['tipo' => 1]) }}"
                                                                method="post" class="dropzone" id="my-awesome-dropzone">
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
                                    @endauth
                                </div>
                                <div class="row">
                                    @if (count($imgCarrusel) == '0')
                                        <p class="p-2 mx-2 border text-center btn-block"> No hay imagenes para mostrar.</p>
                                    @else
                                        <div id="carouselExampleCaptions" class="carousel slide rounded col-xl-12"
                                            data-ride="carousel">
                                            <ol class="carousel-indicators">
                                                @for ($i = 0; $i < count($imgCarrusel); $i++)
                                                    @if ($i == 0)
                                                        <li data-target="#carouselExampleCaptions"
                                                            data-slide-to="{{ $i }}" class="active"></li>
                                                    @else
                                                        <li data-target="#carouselExampleCaptions"
                                                            data-slide-to="{{ $i }}"></li>
                                                    @endif
                                                @endfor
                                            </ol>
                                            <div class="carousel-inner">
                                                @for ($i = 0; $i < count($imgCarrusel); $i++)

                                                    <div class="carousel-item {{ $i == 0 ? 'active' : '' }}">
                                                        @auth
                                                            @if (@Auth::user()->hasRole('Pagina-Inicio-Imagenes|Pagina-Admin|super-admin'))
                                                                <button type="submit"
                                                                    class="btn text-white btn-danger btn-block"
                                                                    data-toggle="modal" data-target="#modalCR2"
                                                                    onclick="$('#imagenCR').val({!! $imgCarrusel[$i]->id !!})">
                                                                    <div class=" mdi mdi-delete mdi-16px text-center"
                                                                        data-toggle="modal" data-target="#modalCR2"
                                                                        onclick="$('#imagenCR').val({!! $imgCarrusel[$i]->id !!})">
                                                                        Eliminar</div>
                                                                </button>
                                                            @endif
                                                        @endauth
                                                        <img src="images/carrusel/{{ $imgCarrusel[$i]->imagen }}"
                                                            class="img-fluid" width="100%"
                                                            alt="{!! $imgCarrusel[$i]->imagen !!}">
                                                    </div>
                                                @endfor
                                            </div>
                                            <a class="carousel-control-prev" href="#carouselExampleCaptions" role="button"
                                                data-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Anterior</span>
                                            </a>
                                            <a class="carousel-control-next" href="#carouselExampleCaptions" role="button"
                                                data-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="sr-only">Siguiente</span>
                                            </a>
                                        </div>
                                    @endif
                                    <!-- end col -->
                                </div> <!-- end row-->
                            </div> <!-- end card-box-->
                        </div> <!-- end col -->
                        <div class="col-xl-12" id="noticias">
                            <div class="card-box">
                                <div class="row my-2">
                                    <div class="col-xl order-first">
                                        <h3>Noticias</h3>
                                    </div>
                                    @auth
                                        @if (@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin'))
                                            <div class="col-lg-3 order-last btn-block">
                                                <!-- Button trigger modal noticia-->
                                                <button type="button" class="btn btn-block btn-info waves-effect waves-light"
                                                    data-toggle="modal" data-target="#myModalNoticia" onclick="reset()">
                                                    <i class="mdi mdi-bulletin-board mdi-16px"></i> Nueva Noticia
                                                </button>
                                            </div>
                                            <!-- noticia modal content -->
                                            <div id="myModalNoticia" class="modal fade" tabindex="-1" role="dialog"
                                                aria-labelledby="myModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">

                                                            <h3 class="modal-title"> <i
                                                                    class="mdi mdi-bulletin-board mdi-24px"
                                                                    aria-hidden="true"></i> Noticia</h3>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-hidden="true">×</button>

                                                        </div>
                                                        <ul class="nav nav-tabs nav-bordered">
                                                            <li class="nav-item">
                                                                <a href="#noticiaL" data-toggle="tab" aria-expanded="true"
                                                                    class="nav-link active">
                                                                    Local
                                                                </a>
                                                            </li>
                                                            <li class="nav-item">
                                                                <a href="#noticiaE" data-toggle="tab" aria-expanded="false"
                                                                    class="nav-link">
                                                                    Externa
                                                                </a>
                                                            </li>
                                                        </ul>
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col-xl-12">
                                                                    <label>Nota: <code>* Campos Obligatorio</code></label>
                                                                </div>
                                                            </div>
                                                            <div class="tab-content">

                                                                <div class="tab-pane show active" id="noticiaL">
                                                                    <div class="alert alert-primary text-white" role="alert"
                                                                        style="display:none" id="notificacionNoticiaL">
                                                                    </div>
                                                                    <form method="POST"
                                                                        action="{{ route('NoticiaFacultad.nueva') }}"
                                                                        class="parsley-examples" id="noticiaLocal"
                                                                        enctype="multipart/form-data">
                                                                        <input type="hidden" id="_id_local" name="_id" />
                                                                        @csrf

                                                                        <div class="row">

                                                                            <div class="col-xl-12">
                                                                                <div class="form-group">
                                                                                    <label>Titulo <code>*</code></label>
                                                                                    <input type="text" class="form-control"
                                                                                        required
                                                                                        placeholder="Titulo Noticia (Obligatorio)"
                                                                                        name="titulo" id="titulo" />
                                                                                </div>
                                                                            </div>

                                                                        </div>

                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="form-group">
                                                                                    <label>Imagen <code>*</code></label>
                                                                                    <div class="custom-file">
                                                                                        <input type="file" value=""
                                                                                            class="custom-file-input form-control"
                                                                                            accept="image/*" name="imagen"
                                                                                            id="img" />
                                                                                        <label class="custom-file-label"
                                                                                            name='imagenlabel'
                                                                                            for="img">Seleccionar imagen</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="form-group">
                                                                                    <label for="contenido">Contenido
                                                                                        <code>*</code></label>
                                                                                    <textarea value=" "
                                                                                        class="form-control summernote-config"
                                                                                        name="contenido" id="contenido"
                                                                                        rows="6"></textarea>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group mb-0">
                                                                            <div>
                                                                                <button type="button"
                                                                                    class="btn btn-primary waves-effect waves-light mr-1"
                                                                                    onclick="submitForm('#noticiaLocal','#notificacionNoticiaL')">
                                                                                    <li class="fa fa-save"></li> Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-light waves-effect"
                                                                                    data-dismiss="modal">
                                                                                    <i class="fa fa-ban"
                                                                                        aria-hidden="true"></i> Cancelar
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                                <div class="tab-pane" id="noticiaE">
                                                                    <div class="alert alert-primary text-white" role="alert"
                                                                        style="display:none" id="notificacionNoticiaE">
                                                                    </div>
                                                                    <form method="POST"
                                                                        action="{{ route('NoticiaFacultad.nuevaurl') }}"
                                                                        class="parsley-examples" enctype="multipart/form-data"
                                                                        id="noticiaEx">
                                                                        <input type="hidden" id="_id_externa" name="_id" />
                                                                        @csrf

                                                                        <div class="alert alert-primary text-white"
                                                                            role="alert" style="display:none"
                                                                            id="notificacionMaestrias">
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="form-group">
                                                                                    <label>Titulo <code>*</code></label>
                                                                                    <input type="text" class="form-control"
                                                                                        required
                                                                                        placeholder="Titulo Noticia (Obligatorio)"
                                                                                        name="titulo" id="tituloUrl" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="form-group">
                                                                                    <label>Descripción <code>*</code></label>
                                                                                    <input type="text" class="form-control"
                                                                                        required
                                                                                        placeholder="Sub-Titulo Noticia (Obligatorio)"
                                                                                        name="subtitulo" id="subtituloUrl" />
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="form-group">
                                                                                    <label>Imagen <code>*</code></label>
                                                                                    <div class="custom-file">
                                                                                        <input type="file"
                                                                                            class="custom-file-input"
                                                                                            name="imagen" accept="image/*"
                                                                                            id="customFileLang" lang="es">
                                                                                        <label class="custom-file-label"
                                                                                            for="customFile">Seleccionar
                                                                                            imagen</label>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <div class="row">
                                                                            <div class="col-xl-12">
                                                                                <div class="form-group">
                                                                                    <label>Url de la fuente
                                                                                        <code>*</code></label>
                                                                                    <div>
                                                                                        <input parsley-type="url" type="url"
                                                                                            class="form-control"
                                                                                            placeholder="URL Fuente (Opcional)"
                                                                                            name="urlfuente" id="urlfuente" />
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group mb-0">
                                                                            <div>
                                                                                <button id="noticiaUrl" type="button"
                                                                                    class="btn btn-primary waves-effect waves-light mr-1"
                                                                                    onclick="submitForm('#noticiaEx','#notificacionNoticiaE')">
                                                                                    <li class="fa fa-save"></li> Guardar
                                                                                </button>
                                                                                <button type="button"
                                                                                    class="btn btn-light waves-effect"
                                                                                    data-dismiss="modal">
                                                                                    <i class="fa fa-ban"
                                                                                        aria-hidden="true"></i> Cancelar
                                                                                </button>
                                                                            </div>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div><!-- /.modal-content -->
                                                </div><!-- /.modal-dialog -->
                                            </div><!-- /.modal -->
                                        @endif
                                    @endauth
                                </div>
                                @if (count($noticias))

                                    <table id="dtNoticias" class="table table-borderless" style="width: 100%;">
                                        <thead style="display: none;">
                                            <tr>
                                                <th>&nbsp;</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($noticias as $n)
                                                <tr>
                                                    <td>
                                                        <div class="row">
                                                            <!--IMAGEN-->
                                                            <div class="col-md-3 col-sm-12 order-md-first d-none d-md-lg d-md-block d-md-block">
                                                                <img class=" mt-1 rounded img-responsive bx-shadow-lg "
                                                                    src="images/noticias/{{ $n->imagen }}"
                                                                    alt="Generic placeholder image" height="115"
                                                                    width="145">
                                                            </div>
                                                            <!--IMAGEN-->
                                                            <!--CONTENIDO BLA BLA-->
                                                            <div class="col-md-6 col-sm-12 order-sm-first">
                                                                <h6 class="text-left">Publicado
                                                                    {!! /*date('d M Y - h:i:s A', strtotime($n->created_at))*/ $n->created_at->diffForHumans() !!}</h6>
                                                                <h4 class="mt-0">
                                                                    <p class="text-break">{{ $n->titulo }}</p>
                                                                </h4>
                                                                @if (!$n->tipo)
                                                                    {!! $n->subtitulo !!}
                                                                @endif
                                                                <p class="text-truncate">
                                                                    {{ mb_strwidth(strip_tags($n->contenido), 'UTF-8') <= 125 ? strip_tags($n->contenido) : rtrim(mb_strimwidth(strip_tags($n->contenido), 0, 125, '', 'UTF-8')) . '...' }}
                                                                </p>
                                                            </div>
                                                            <!--CONTENIDO BLA BLA-->
                                                            <!--BOTONCITOS-->
                                                            <div class="col-md-2  col-sm-12 text-right">
                                                                <div class="btn-group-vertical" role="group">
                                                                    @if ($n->tipo)

                                                                        <a href="{{ asset('/noticias') }}/{!! base64_encode($n->id) !!}/{!! base64_encode($n->titulo) !!}"
                                                                            class="btn btn-light waves-effect width-md  @if (@Auth::guest() ? @Auth::guest() : !@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin'))  mt-4 @endif"
                                                                            target="_blank">
                                                                            @auth
                                                                                @if (@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin'))
                                                                                    <i class="mdi mdi-send"></i>
                                                                                @endif
                                                                            @endauth Leer más
                                                                            @if (@Auth::guest() ? @Auth::guest() : !@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin'))
                                                                                <i class="mdi mdi-send"></i>
                                                                            @endif
                                                                        </a>
                                                                        @auth
                                                                            @if (@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin'))
                                                                                <button type="button"
                                                                                    class="btn btn-light waves-effect width-md"
                                                                                    onclick="modificarNL({!! $n->id !!})"
                                                                                    data-toggle="modal"
                                                                                    data-target="#myModalNoticia">
                                                                                    <i
                                                                                        class="mdi mdi-file-document-edit mdi-16p"></i>
                                                                                    Modificar
                                                                                </button>
                                                                            @endif
                                                                        @endauth
                                                                    @else
                                                                        <a href="{!! $n->urlfuente !!}"
                                                                            class="btn btn-light waves-effect width-md @if (@Auth::guest() ? @Auth::guest() : !@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin')) mt-4 @endif"
                                                                            target="_blank">
                                                                            @auth
                                                                                @if (@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin'))
                                                                                    <i class="mdi mdi-earth"></i>
                                                                                @endif
                                                                            @endauth
                                                                            Leer más
                                                                            @if (@Auth::guest() ? @Auth::guest() : !@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin'))
                                                                                <i class="mdi mdi-earth"></i>
                                                                            @endif
                                                                        </a>
                                                                        @auth
                                                                            @if (@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin'))
                                                                                <span data-toggle="modal"
                                                                                    data-target="#myModalNoticia">
                                                                                    <button type="button"
                                                                                        class="btn btn-light waves-effect width-md"
                                                                                        onclick="modificarEX({!! $n->id !!})">
                                                                                        <i
                                                                                            class="mdi mdi-file-document-edit mdi-16p"></i>
                                                                                        Modificar</button>
                                                                                </span>
                                                                            @endif
                                                                        @endauth
                                                                    @endif

                                                                    @auth
                                                                        @if (@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin'))
                                                                            <button type="button"
                                                                                onclick="$('#noticia').val('{!! base64_encode($n->id) !!}')"
                                                                                class="btn btn-light waves-effect width-md btn-block"
                                                                                data-toggle="modal"
                                                                                data-target="#modalEliminarNoticia">
                                                                                <i class="mdi mdi-delete"></i>
                                                                                Eliminar</button>
                                                                        @endif
                                                                    @endauth
                                                                </div>
                                                            </div>
                                                            <!--BOTONCITOS-->
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                @else
                                    <p class="p-2 border text-center">No hay noticias para mostrar.</p>
                                @endif
                            </div> <!-- end card-box -->
                        </div><!-- end col -->
                    </div>
                </div>
                <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="card-box">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <h3>Síguenos en Facebook</h3>
                                    </div>
                                    <div class="col-xl-12" style="overflow: auto;">
                                        <div class="fb-page"
                                            data-href="https://www.facebook.com/Facultad-Multidisciplinaria-Paracentral-Decanato-104296228519520"
                                            data-width="" data-height="" data-small-header="false"
                                            data-adapt-container-width="true" data-hide-cover="false"
                                            data-show-facepile="true">
                                            <blockquote
                                                cite="https://www.facebook.com/Facultad-Multidisciplinaria-Paracentral-Decanato-104296228519520/"
                                                class="fb-xfbml-parse-ignore"><a
                                                    href="https://www.facebook.com/Facultad-Multidisciplinaria-Paracentral-Decanato-104296228519520/">Facultad
                                                    Multidisciplinaria Paracentral - Decanato</a></blockquote>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div><!-- end col-->
                        <div class="col-xl-12">
                            <div class="card-box">
                                <h3>Canales Digitales</h3>
                                <a href="https://www.facebook.com/celeues" target="_blank"
                                    class="btn btn-danger btn-block mt-3 text-left"><i class="mdi mdi-earth font-18"></i>
                                    CELEUES</a>
                                <a href="https://campus.ues.edu.sv/" target="_blank"
                                    class="btn btn-danger btn-block mt-3 text-left"><i class="mdi mdi-earth font-18"></i>
                                    Campus Virtual Central</a>
                                <a href="https://sites.google.com/ues.edu.sv/multimedia-fmp" target="_blank" class="btn btn-danger btn-block mt-3 text-left">
                                    <i class=" mdi mdi-earth  font-18"></i>  Recursos Audiovisuales LMS</a>
                                <a href="#" target="_blank" class="btn btn-danger btn-block mt-3 text-left" style="display: none"><i class=" mdi mdi-book-open-variant font-18"></i> Campus Virtual FMP</a>
                                <a href="https://eel.ues.edu.sv/" target="_blank"
                                    class="btn btn-danger btn-block mt-3 text-left"><i class="mdi mdi-earth font-18"></i>
                                    Expediente en Línea</a>
                                <a href="https://correo.ues.edu.sv/" target="_blank"
                                    class="btn btn-danger  btn-block mt-3 text-left"><i
                                        class=" mdi mdi-email font-18"></i> Correo Institucional</a>
                                <a href="https://www.facebook.com/EnLineaFMP" target="_blank"
                                    class="btn btn-danger  btn-block mt-3 text-left"><i
                                        class="mdi mdi-facebook border rounded font-16"></i> Educación en Línea Sede San
                                    Vicente</a>
                                <a href="http://biblio.fmp.ues.edu.sv/biblioteca/" target="_blank"
                                    class="btn btn-danger btn-block mt-3 text-left"><i
                                        class=" mdi mdi-book-open-variant font-18"></i> Biblioteca</a>
                                
                            </div> <!-- end card-box-->
                        </div> <!-- end col-->
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
                                <div class="p-1"><a href="https://humanidades.ues.edu.sv/"
                                        target="_blank">Facultad de Ciencias y Humanidades</a></div>
                                <div class="p-1"><a href="http://www.fmoues.edu.sv/" target="_blank">Facultad
                                        Multidisciplinaria de Oriente</a></div>
                                <div class="p-1"><a href="http://www.fia.ues.edu.sv/" target="_blank">Facultad
                                        de Ingeniería y Arquitectura</a></div>
                                <div class="p-1"><a href="https://www.agronomia.ues.edu.sv/"
                                        target="_blank">Facultad de Agronomía</a></div>
                                <div class="p-1"><a href="http://www.odontologia.ues.edu.sv/"
                                        target="_blank">Facultad de Odontología</a></div>
                                <div class="p-1"><a href="http://www.medicina.ues.edu.sv/"
                                        target="_blank">Facultad de Medicina</a></div>
                                <div class="p-1"><a href="http://jurisprudencia.ues.edu.sv/sitio/"
                                        target="_blank">Facultad de Jurisprudencia y Ciencias Sociales</a></div>
                                <div class="p-1"><a href="https://www.quimicayfarmacia.ues.edu.sv/"
                                        target="_blank">Facultad de Química y Farmacia</a></div>
                                <div class="p-1"><a href="https://www.cimat.ues.edu.sv/"
                                        target="_blank">Facultad de Ciencias Naturales y Matemática</a></div>
                                <div class="p-1"><a href="http://www.occ.ues.edu.sv/" target="_blank">Facultad
                                        Multidisciplinaria de Occidente</a></div>
                                <div class="p-1"><a href="http://www.fce.ues.edu.sv/" target="_blank">Facultad
                                        de Ciencias Económicas</a></div>
                            </div>
                            <div class="col">
                                <p class="header-title">Secretarias</p>
                                <div class="p-1"><a href="http://secretariageneral.ues.edu.sv/"
                                        target="_blank">Secretaría General</a></div>
                                <div class="p-1"><a href="http://proyeccionsocial.ues.edu.sv/"
                                        target="_blank">Secretaría de Proyección Social</a></div>
                                <div class="p-1"><a href="http://www.eluniversitario.ues.edu.sv/"
                                        target="_blank">Secretaría de Comunicaciones</a></div>
                                <div class="p-1"><a href="https://es-es.facebook.com/ArteyCulturaUES/"
                                        target="_blank">Secretaría de Arte y Cultura</a></div>
                                <div class="p-1"><a href="http://www.bienestar.ues.edu.sv/"
                                        target="_blank">Secretaría de Bienestar Universitario</a></div>
                                <div class="p-1"><a
                                        href="http://www.ues.edu.sv/secretaria-de-relaciones-nacionales-e-internacionales/"
                                        target="_blank">Secretaría de Relaciones</a></div>
                                <div class="p-1"><a href="https://secplan.ues.edu.sv/"
                                        target="_blank">Secretaría de Planificación</a></div>
                                <div class="p-1"><a href="https://sic.ues.edu.sv/" target="_blank">Secretaría de
                                        Investigaciones Científicas</a></div>
                                <div class="p-1"><a href="http://saa.ues.edu.sv/" target="_blank">Secretaría de
                                        Asuntos Académicos</a></div>
                            </div>
                            <div class="col order-last">
                                <p class="header-title">Institución</p>
                                <div class="p-1"><a href="https://www.ues.edu.sv/becas/" target="_blank">Consejo
                                        de Becas</a></div>
                                <div class="p-1"><a href="#">Consejo Superior Universitario</a></div>
                                <div class="p-1"><a href="#">Asamblea General Universitaria</a></div>
                                <div class="p-1"><a href="https://www.uese.ues.edu.sv/" target="_blank">Unidad
                                        de Estudio Socioeconómico </a></div>
                                <div class="p-1"><a href="https://www.facebook.com/defensoriaues/"
                                        target="_blank">Defensoría de los Derechos Universitarios</a></div>
                            </div>
                        </div>
                    </div> <!-- end card-box -->
                </div><!-- end col -->


            </div>
            <!-- end row -->
        </div> <!-- end container -->
    </div>

    @auth
        @if (@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin'))
            <div id="modalEliminarNoticia" class="modal fade bs-example-modal-center" tabindex="-1" role="dialog"
                aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i>
                                Eliminar</h3>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('NoticiaBorrar') }}" method="POST">
                                @csrf
                                <div class="row py-3">
                                    <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                                    <div class="col-lg-10 text-black">
                                        <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se elimina este registro
                                            de manera permanente, ¿Desea continuar?</h4>
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
                                        <button type="reset"
                                            class="btn btn-light p-1 waves-light waves-effect btn-block font-24"
                                            data-dismiss="modal">
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
    @endauth
    <!-- end wrapper -->
@endsection

@section('footerjs')

    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>

    <!-- Datatable js -->
    <script src="{{ asset('template-admin/dist/assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/datatables/responsive.bootstrap4.min.js') }}"></script>


    <script src="{{ asset('js/index/index.datatable.js') }}"></script>
    @auth
        @if (@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin'))

            <script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
            <script src="{{ asset('js/summernote.config.min.js') }}"></script>
            <script src="{{ asset('vendor/summernote/lang/summernote-es-ES.js') }}"></script>
            <script src="{{ asset('js/scripts/http.min.js') }}"></script>
            <script src="{{ asset('js/scripts/index.js') }}"></script>

        @endif
    @endauth

    <!-- Plugins js -->
    <script src=" {{ asset('js/dropzone.min.js') }} "></script>


    @auth
        @if (@Auth::user()->hasRole('Pagina-Inicio-Noticias|Pagina-Admin|super-admin'))
            <script>
                function reset() {
                    $('.nav-tabs a[href="#noticiaL"]').tab('show')
                };

                /*Carga del model con los datos de la noticia actual */
                function modificarNL(id) {
                    $('.nav-tabs a[href="#noticiaL"]').tab('show');
                    $json = {!! json_encode($noticias) !!}.find(x => x.id == id);
                    editarNL($json);
                };

                /*Carga el model con las noticias de url con noticias externas*/
                function modificarEX(id) {
                    $('.nav-tabs a[href="#noticiaE"]').tab('show');
                    $json = {!! json_encode($noticias) !!}.find(x => x.id == id);
                    editarEX($json);
                };
            </script>
        @endif
    @endauth

@endsection
