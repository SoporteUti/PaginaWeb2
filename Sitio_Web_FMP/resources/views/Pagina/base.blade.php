<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8" />
        <title>Facultad Multidisciplinaria Paracentral</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta content="Facultad Multidisciplinaria Paracentral" name="description" />
        <meta content="Coderthemes" name="UTI" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />

        @yield('appcss')
        <link rel="stylesheet" href="{{ asset('css/base.css') }}" />
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
                    </div>
                </div>
                <div id="navigation" >
                    <!-- Navigation Menu-->
                    <ul id="navigationul" class="navigation-menu py-1 color-fondo" >

                        <li class="has-submenu p-1 center-text">
                            <a href="{{ asset('/') }}" class=" rounded text-left" >
                                <i class=" mdi mdi-home mdi-24px"></i>
                                <font size="4">Inicio</font></a>
                        </li>

                        <li class="has-submenu p-1">
                            <a href="#" class="rounded btn text-left">
                                 <i class="mdi mdi-account-multiple mdi-24px"></i>
                                 <font size="4">Nosotros</font> <div class="arrow-down"></div></a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ asset('MisionVision') }}">Misión y Visión</a>
                                </li>
                                <li>
                                    <a href="{{ route('directorio') }}">Directorio</a>
                                </li>
                                <li class="has-submenu">
                                    <a href="{{ asset('EstructuraOrganizativa') }}">Estructura Organizativa&nbsp;</a>
                                </li>

                            </ul>
                        </li>

                        <li class="has-submenu p-1">
                            <a href="#">
                            <i class="mdi mdi-book-open-page-variant mdi-24px"></i>
                            <font size="4">Académico</font><div class="arrow-down"></div></a>
                            <ul class="submenu">
                                <li class="has-submenu">
                                    <a  href="{{ route('admonAcademica') }}">Administración Académica</a>
                                </li>
                                <li class="has-submenu">
                                    <a href="#">Departamentos <div class="arrow-down"></div></a>
                                    <ul class="submenu">
                                        <li>
                                            <a href="{{ route('Departamento.CienciasEdu') }}">Ciencias de la Educación</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('Departamento.CienciasAgr') }}">Ciencias Agronómicas</a>
                                        </li>

                                        <li>
                                            <a href="{{ route('Departamento.CienciasEcon') }}">Ciencias Económicas</a>
                                        </li>

                                        <li>
                                            <a href="{{ route('Departamento.Inform') }}">Informática</a>
                                        </li>

                                        <li>
                                            <a href="{{ route('planComp') }}">Plan Complementario</a>
                                        </li>
                                    </ul>
                                </li>
                                <li>
                                    <a href="{{ route('postgrado') }}">Unidad de Postgrado</a>
                                </li>
                                <li>
                                    <a href="https://distancia.ues.edu.sv/" target="_blank">Universidad en Línea</a>
                                </li>
                                <li class="has-submenu">
                                    <a href="{{ route('investigacion')}}">Unidad de Investigación</a>
                                </li>
                                <li class="has-submenu">
                                    <a href="{{ route('proyeccionSocial') }}">Unidad de Proyección Social</a>
                                </li>
                                <!--<li class="has-submenu">
                                    <a href="#">Coordinación General de<br>Procesos de Graduación</a>
                                </li>-->
                                <li class="has-submenu">
                                    <a href="http://biblio.fmp.ues.edu.sv/" target="_blank">Biblioteca</a>
                                </li>
                            </ul>
                        </li>

                        <li class="has-submenu p-1">
                            <a href="#" class="rounded btn text-left">
                                 <i class="mdi mdi-clipboard-text mdi-24px"></i>
                                 <font size="4">Administrativo</font><div class="arrow-down"></div></a>
                            <ul class="submenu">
                                <li>
                                    <a href="{{ route('administracionFinanciera') }}">Administración Financiera</a>
                                </li>

                                <li>
                                    <a href="{{ route('uti') }}">Unidad de Tecnología<br>de la Información</a>
                                </li>

                            </ul>
                        </li>

                        <li class="has-submenu p-1">
                            <a href="{{ url('transparencia') }}"  class="rounded btn text-left">
                                <i class="mdi mdi-file-account mdi-24px"></i>
                                <font size="4">Transparencia</font>
                            </a>
                        </li>

                        <li class="has-submenu p-1" id="sesion">

                            @auth
                                <a href="#"  class="rounded btn text-left">
                                    <i class="mdi mdi-account mdi-24px"></i>
                                    {!!mb_strwidth(Auth::user()->name) <= 15?Auth::user()->name:rtrim(mb_strimwidth(Auth::user()->name, 0, 15, '', 'UTF-8')).'...'!!}
                                    <div class="arrow-down"></div>
                                </a>
                                <ul class="submenu">
                                    <li><a href="{{ url('/admin') }}"><i class="fa fa-book-open"></i> Administrar </a></li>
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}">
                                            @csrf
                                            <a href="route('logout')" onclick="event.preventDefault();
                                            this.closest('form').submit(); "><i class="fa fa-door-closed"></i> {{ __('Cerrar sesión') }} </a>
                                        </form>
                                    </li>
                                </ul>

                            @else
                                <a href="{{ route('login') }}"  class="rounded btn text-left">
                                    <i class="mdi mdi-account mdi-24px"></i>
                                    <font size="4">Iniciar Sesión</font>
                                </a>
                            @endauth

                        </li>

                    </ul>
                   
                    <div class="clearfix"></div>

                </div>
                <!-- end #navigation -->
            </div>

            <!-- end navbar-custom -->

        </header>
        <!-- End Navigation Bar-->
        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        @yield('container')
        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->
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
        @yield('footerjs')
        <script src="{{ asset('js/base.js') }}"></script>
    </body>
</html>
