<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>Transparencia FMP</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
        <meta content="Coderthemes" name="UTI" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="stylesheet" href="{{ asset('css/base.css') }}" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

        <!-- App css -->
        <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('css/base.css') }}" rel="stylesheet" type="text/css" />
        <link href="{{ asset('template-admin/dist/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('template-admin/dist/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('template-admin/dist/assets/libs/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />

         <!-- DataTables -->
        <link href="{{ asset('template-admin/dist/assets/libs/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>
        <link href="{{ asset('template-admin/dist/assets/libs/datatables/responsive.bootstrap4.min.css') }}" rel="stylesheet" type="text/css"/>

        @yield('appcss')


    </head>

    <body class="unsticky-header">
        <div class="loading show" id="loading">
            <div class="spinner-border text-danger m-2 font-50" role="status">
                <span class="sr-only">Cargando...</span>
            </div>
        </div>
        <!-- Navigation Bar-->
        <header id="topnav">
            <div class="navb  color-top">
                <ul class="list-unstyled bottomnav-menu float-right color-top">

                    <li class="dropdown notification-list color-top">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link ">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>

                </ul>
            </div>
            <!-- end Topbar -->

            <div class="container-fluid">
                <div class="row align-items-center color-top ocultar-div ">
                    <div class="col-2">
                        <div class="col-2 my-1">
                            <a href="{{ asset('/') }}">
                                <img src="{{ asset('/images/ues_logo3.svg') }}" alt="logo" height="">
                            </a>
                        </div>
                    </div>
                    <div class="col-10 text-white text-left">
                        <h3 class="text-white">Universidad de El Salvador</h3>
                        <h1 class="text-white">Facultad Multidisciplinaria Paracentral</h1>
                        <h3 class="text-white">Unidad de Acceso a la Información Pública</h2>
                    </div>
                </div>

                <div id="navigation" >
                    <!-- Navigation Menu-->
                    <ul class="navigation-menu py-1 color-fondo " >
                        <li class="has-submenu p-1 center-text">
                            <a href="{{ url('/') }}" class=" rounded text-left" >
                                <i class="mdi mdi-arrow-left-box  mdi-24px"></i>Pagina Web
                            </a>
                        </li>
                        <li class="has-submenu p-1 center-text">
                            <a href="{{ url('transparencia') }}" class=" rounded text-left" >
                                <i class="mdi mdi-home  mdi-24px"></i>Inicio
                            </a>
                        </li>
                        <li class="has-submenu p-1">
                            <a href="#" class="rounded btn text-left"><i class="mdi mdi-view-list mdi-24px"></i>Marcos<div class="arrow-down"></div></a>
                            <ul class="submenu">
                                <li><a href="{{ url('transparencia/marco-normativo') }}">Normativo</a></li>
                                <li class="has-submenu">
                                    <a href="{{ url('transparencia/marco-gestion') }}">De Gestión <div class="arrow-down"></div></a>
                                    <ul class="submenu">
                                        <li>
                                            <a href="{{ route('transparencia.directorios') }}">Directorio</a>
                                        </li>
                                    </ul>
                                </li>
                                <li><a href="{{ url('transparencia/marco-presupuestario') }}">Presupuestario</a></li>
                            </ul>
                        </li>
                        <li class="has-submenu p-1">
                            <a href="{{ url('transparencia/repositorios') }}" class="rounded btn text-left">
                                <i class="mdi mdi-folder-open mdi-24px"></i>Repositorios
                            </a>
                        </li>

                        <li class="has-submenu p-1">
                            <a href="{{ url('transparencia/documentos-JD') }}" class="rounded btn text-left"><i class="mdi mdi-file-pdf mdi-24px"></i>Documentos Junta Directiva<div class="arrow-down"></div></a>
                            <ul class="submenu">
                                <li><a href="{{ route('transparencia.subcategoria', ['documentos-JD', 'acuerdos']) }}">Acuerdos</a></li>
                                <li><a href="{{ route('transparencia.subcategoria', ['documentos-JD', 'agendas']) }}">Agendas</a></li>
                                <li><a href="{{ route('transparencia.subcategoria', ['documentos-JD', 'actas']) }}">Actas</a></li>
                            </ul>
                        </li>

                        <li class="has-submenu float-right p-1">
                            @auth
                                <a href="#"  class="rounded btn text-left">
                                    <i class="mdi mdi-account mdi-24px"></i>
                                    {{ Auth::user()->name }}
                                    <div class="arrow-down"></div>
                                </a>
                                <ul class="submenu">
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="route('logout')" onclick="event.preventDefault();
                                            this.closest('form').submit();">{{ __('Cerrar sesión') }}</a>
                                        </form>
                                    </li>
                                </ul>
                            @else
                                <a href="{{ route('login') }}"  class="rounded btn text-left">
                                    <i class="mdi mdi-account mdi-24px"></i>
                                    Iniciar Sesión
                                </a>
                            @endauth
                        </li>
                    </ul>
                    <ul class="list-unstyled topnav-menu float-right mb-0">

                        <li class="dropdown notification-list">
                            <a class="navbar-toggle nav-link">
                                <div class="lines">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </div>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
            </div>
        </header>
        <div class="wrapper">
            <div class="container-fluid">
                <div class="page-title-box color-boton py-2 rounded titulo-responsive">
                    <a class="page-title text-white h2" href="{{ route('index') }}">
                        <p class="mt-0 pt-0 mb-0 pb-0 text-center">Universidad de El Salvador</p>
                        <p class="mt-0 pt-0 mb-0 pb-0 text-center">Facultad Multidisciplinaria Paracentral</p>
                        <p class="mt-0 pt-0 mb-0 pb-0 text-center">Unidad de Acceso a la Información Pública</p>
                    </a>
                </div>
                <div class="my-4"></div>
                @yield('container')
            </div>
        </div>

        <!-- Footer Start -->
        <footer class="footer py-1 text-white" id="footerbase">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 text-center">
                        {{ date('Y') }} &copy; Facultad Multidisciplinaria Paracentral - <a href="https://www.ues.edu.sv/" class="text-white-50">Universidad de El Salvador</a>.   Todos los derechos reservados.
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->

        <!-- Vendor js -->
        <script src="{{ asset('js/vendor.min.js') }}"></script>
        <!-- App js -->
        <script src="{{ asset('js/app.min.js') }}"></script>



        {{-- <script src="{{ asset('template-admin/dist/assets/libs/moment/moment.min.js') }}"></script> --}}
        {{-- <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}"></script> --}}
        <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
        <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-datepicker/bootstrap-datepicker-es.js') }}"></script>
        {{-- <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-daterangepicker/daterangepicker.js') }}"></script> --}}

        <!-- Datatable js -->
        <script src="{{ asset('template-admin/dist/assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
        <script src="{{ asset('template-admin/dist/assets/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
        <script src="{{ asset('template-admin/dist/assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
        <script src="{{ asset('template-admin/dist/assets/libs/datatables/responsive.bootstrap4.min.js') }}"></script>

        @yield('footerjs')
        <script src="{{ asset('js/base.js') }}"></script>
    </body>
</html>
