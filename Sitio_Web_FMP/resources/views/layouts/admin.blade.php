<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <title>Administración FMP</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Coderthemes" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <meta http-equiv="X-UA-Compatible" content="IE=Edge,chrome=1">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('/images/ues_logo3.svg') }}">
    <!-- DataTables -->
    <link href="{{ asset('template-admin/dist/assets/libs/datatables/dataTables.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />
    <link href="{{ asset('template-admin/dist/assets/libs/datatables/responsive.bootstrap4.min.css') }}"
        rel="stylesheet" type="text/css" />

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('vendor/sweetalert2/dist/sweetalert2.css') }}">

    <!-- Summernote css -->
    <link href="{{ asset('template-admin/dist/assets/libs/summernote/summernote-bs4.css') }}" rel="stylesheet" />

    @yield('plugins')

    <!-- App css -->
    <link rel="stylesheet" href="{{ asset('css/base.css') }}" />
    <link href="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('template-admin/dist/assets/libs/select2/select2.min.css') }}" rel="stylesheet" />

    <link href="{{ asset('template-admin/dist/assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template-admin/dist/assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template-admin/dist/assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />


    {{-- DateRangPicker --}}
    <link rel="stylesheet" href="{{ asset('vendor/daterangepicker/daterangepicker.css') }}">
    {{-- <link rel="stylesheet" href="{{asset('vendor/bootstrap-datepicker/css/bootstrap-datepicker.css') }}"> --}}

    {{-- <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script> --}}

</head>

<body>
    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <ul class="list-unstyled topnav-menu float-right mb-0">
                <li class="notification-list">
                    <a class="nav-link dropdown-toggle waves-effect waves-light" href="{{ route('index') }}"
                        title="Pagina Web"><i class="mdi mdi-earth font-22"></i></a>
                </li>
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle waves-effect waves-light" data-toggle="dropdown" href="#"
                        role="button" aria-haspopup="false" aria-expanded="false">
                        <i class="font-18 dripicons-bell noti-icon"></i>
                        {{-- <span class="badge badge-info noti-icon-badge">{{ count(notificaciones()) }}</span> --}}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right dropdown-lg">
                        <div class="dropdown-item noti-title">
                            <h5 class="m-0">
                                <span class="float-right">
                                    <a href="{{ url('admin/notificaciones') }}" class="text-dark"><small>Ver
                                            todas</small></a>
                                </span>Notificaciones
                            </h5>
                        </div>

                        <div class="slimscroll noti-scroll">
                            {{-- @foreach (notificaciones() as $key => $value)
                                    <a href="javascript:void(0);" class="dropdown-item notify-item {{ $loop->index==0 ? 'active' : '' }} ">
                                        <div class="notify-icon bg-success"><i class="mdi mdi-account-clock-outline"></i> </div>
                                        <p class="notify-details"> {{ $value->mensaje }}<small class="text-muted"> {{ $value->created_at->diffForHumans() }}</small></p>
                                    </a>
                                @endforeach --}}
                        </div>
                        <!-- All-->
                        <a href="{{ url('admin/notificaciones') }}"
                            class="dropdown-item text-center text-primary notify-item notify-all">Ver todas<i
                                class="fi-arrow-right"></i></a>
                    </div>
                </li>

                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown"
                        href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('/images/ues_logo3.svg') }}" alt="user-image" class="rounded-circle">
                        <span class="pro-user-name ml-1">
                            {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                        <!-- item-->
                        <div class="dropdown-item noti-title">
                            <h6 class="m-0">
                                Bienvenido!
                            </h6>
                        </div>

                        <!-- item-->
                        <a href="javascript:void(0);" class="dropdown-item notify-item">
                            <i class="font-18 dripicons-user"></i>
                            <span>Perfil</span>
                        </a>

                        <!-- item-->
                        {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="font-18 dripicons-gear"></i>
                                <span>Settings</span>
                            </a> --}}

                        <!-- item-->
                        {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="font-18 dripicons-help"></i>
                                <span>Support</span>
                            </a> --}}

                        <!-- item-->
                        {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="font-18 dripicons-lock"></i>
                                <span>Lock Screen</span>
                            </a> --}}

                        <div class="dropdown-divider"></div>

                        <!-- item-->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <a href="route('logout')" class="dropdown-item notify-item"
                                onclick="event.preventDefault(); this.closest('form').submit();"><i
                                    class="font-18 dripicons-power"></i> {{ __('Cerrar sesión') }}</a>
                        </form>

                        {{-- <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="font-18 dripicons-power"></i>
                                <span>Logout</span>
                            </a> --}}

                    </div>
                </li>


            </ul>

            <ul class="list-unstyled menu-left mb-0">
                <li class="float-left">
                    <a href="{{ asset('admin') }}" class="logo">
                        <span class="logo-lg">
                            <img src="{{ asset('/images/ues_logo3.svg') }}" alt="" height="22">
                            <strong class="text-white">Universidad de El Salvador</strong>
                        </span>
                        <span class="logo-sm">
                            <img src="{{ asset('/images/ues_logo3.svg') }}" alt="" height="24">
                        </span>
                    </a>
                </li>
                <li class="float-left">
                    <a class="button-menu-mobile navbar-toggle">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                </li>

            </ul>
        </div>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="left-side-menu">
            <div class="slimscroll-menu">
                <!--- Sidemenu -->
                <div id="sidebar-menu">
                    <ul class="metismenu" id="side-menu">
                        <li class="menu-title"> General</li>
                        <li>
                            <a href="{{ url('admin/') }}">
                                <i class="font-20 mdi mdi-home-outline"></i>
                                <span> Inicio </span>
                            </a>
                        </li>
                        @hasrole('super-admin|Recurso-Humano')
                            <li>
                                <a href="{{ route('empleado') }}">
                                    <i class="font-18 dripicons-user "></i> <span> Empleados </span>
                                </a>
                            </li>
                        @endhasrole
                        <li class="menu-title">Licencias</li>
                        <li>
                            <a href="{{ route('indexLic') }}"><i class="icon-notebook font-18"></i><span> Mis
                                    Licencias</span></a>
                        </li>
                        <li>
                            <a href="{{ route('olvido') }}"><i class="dripicons-clock  font-18"></i><span>Const.
                                    Olvido de Marcaje</span></a>
                        </li>
                        @if (@Auth::user()->hasRole('super-admin') ||
    @Auth::user()->hasRole('Recurso-Humano') ||
    \Illuminate\Support\Facades\DB::table('permisos')->where('jefatura', auth()->user()->empleado)->exists())
                            <li>
                                <a href="javascript: void(0);"><i class="font-18  icon-layers"></i>
                                    <span> Gestión de Licencias </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @hasanyrole('super-admin')
                                        <li>
                                            <a href="{{ route('indexLicGS') }}">Horas de Licencias</a>
                                        </li>
                                    @endhasrole
                                    @if (\Illuminate\Support\Facades\DB::table('permisos')->where('jefatura', auth()->user()->empleado)->exists())
                                        <li>
                                            <a href="{{ route('indexJefatura') }}">Jefatura</a>
                                        </li>
                                    @endif
                                    @hasanyrole('super-admin|Recurso-Humano')
                                        <li>
                                            <a href="{{ route('indexRRHH') }}">Recurso Humano</a>
                                        </li>
                                    @endhasrole
                                    @hasanyrole('super-admin|Recurso-Humano')
                                        <li>
                                            <a href="{{ route('AcuerdoLic') }}">Licencia por acuerdo</a>
                                        </li>
                                    @endhasrole

                                </ul>
                            </li>
                        @endif
                        <!--MENÚ DE IMPORTACIONES DE DATOS-->
                        @if (@Auth::user()->hasRole('super-admin') ||
                        @Auth::user()->hasRole('Recurso-Humano'))
                            <li>
                                <a href="javascript: void(0);"><i class="font-18  icon-cloud-download"></i>
                                    <span>Importación de datos</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                        <li>
                                            <a href="{{ route('Importaciones/inicio') }}">Datos Reloj</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('Importaciones/modificacion') }}">Modificación Datos Reloj</a>
                                        </li>
                                </ul>
                            </li>
                        @endif
                        <!--FIN DE MENU DE EXPORTACIONES DE DATOS-->
                        @hasanyrole('super-admin|Transparencia-Decano|Transparencia-Secretario|Transparencia-Presupuestario')
                            <li class="menu-title">Transparencia</li>
                            <li>
                                <a href="javascript: void(0);"><i class="font-18 dripicons-view-list-large"></i><span>
                                        Marcos </span><span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @hasanyrole('super-admin|Transparencia-Decano|Transparencia-Secretario')
                                        <li>
                                            <a href="{{ url('admin/transparencia/marco-normativo') }}">Normativo</a>
                                        </li>
                                    @endhasanyrole
                                    @hasanyrole('super-admin|Transparencia-Decano|Transparencia-Secretario')
                                        <li>
                                            <a href="{{ url('admin/transparencia/marco-gestion') }}">De Gestión</a>
                                        </li>
                                    @endhasanyrole
                                    @hasanyrole('super-admin|Transparencia-Decano')
                                        <li>
                                            <a href="{{ url('admin/transparencia-directorios') }}">Directorios</a>
                                        </li>
                                    @endhasanyrole
                                    @hasanyrole('super-admin|Transparencia-Presupuestario')
                                        <li>
                                            <a
                                                href="{{ url('admin/transparencia/marco-presupuestario') }}">Presupuestario</a>
                                        </li>
                                    @endhasanyrole
                                </ul>
                            </li>
                        @endhasanyrole
                        @hasanyrole('super-admin|Transparencia-Secretario|Transparencia-Repositorio')
                            <li>
                                <a href="{{ url('admin/transparencia/repositorios') }}">
                                    <i class="font-18 dripicons-graph-bar "></i> <span> Repositorios </span>
                                </a>
                            </li>
                        @endhasanyrole
                        @hasanyrole('super-admin|Transparencia-Secretario')
                            <li>
                                <a href="{{ url('admin/transparencia/documentos-JD') }}">
                                    <i class="font-18 dripicons-document"></i> <span> Doc. de Junta Directiva </span>
                                </a>
                            </li>
                        @endhasanyrole
                        @hasrole('super-admin|Recurso-Humano|Jefe-Administrativo|Jefe-Academico|Docente|Administrativo')
                            <li class="menu-title">Jornada</li>
                            <li>
                                <a href="javascript: void(0);"><i class="font-18 dripicons-view-list-large"></i><span>
                                        Gestión de Jornada </span><span class="menu-arrow"></span></a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li>
                                        <a href="{{ url('admin/jornada') }}">Jornada</a>
                                    </li>
                                    @hasanyrole('super-admin|Recurso-Humano')
                                        <li>
                                            <a href="{{ url('admin/periodo') }}">Periodo</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('admin/ciclo') }}">Ciclo</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('admin/tcontrato') }}">Tipo Contrato</a>
                                        </li>
                                        <li>
                                            <a href="{{ url('admin/tjornada') }}">Tipo Jornada</a>
                                        </li>
                                    @endhasanyrole
                                </ul>
                            </li>
                        @endhasrole
                        @hasrole('super-admin')
                            <li class="menu-title">Seguridad</li>
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="font-20 mdi mdi-security mdi "></i>
                                    <span> Gestión de Seguridad </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    <li>
                                        <a href="{{ route('usuarios') }}">Usuarios</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('admin.bitacora') }}">Bitacora</a>
                                    </li>
                                </ul>
                            </li>
                        @endhasrole
                        @if (@Auth::user()->hasRole('super-admin') || @Auth::user()->hasRole('Jefe-Academico'))
                            <!--para los horarios-->
                            <li class="menu-title">Horarios</li>
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="font-18 dripicons-clipboard"></i>
                                    <span> Gestión de Departamentos</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @if (@Auth::user()->hasRole('super-admin'))

                                        <li>
                                            <a href="{{ route('carreras') }}">Carreras</a>
                                        </li>
                                        <li>
                                            <a href="{{ route('depto') }}">Departamentos</a>
                                        </li>


                                    @endif
                                </ul>
                            </li>
                            <li>
                                <a href="javascript: void(0);">
                                    <i class="font-18 dripicons-briefcase"></i>
                                    <span> Asignación de carga Administrativa </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul class="nav-second-level" aria-expanded="false">
                                    @hasrole('super-admin')
                                        <li>
                                            <a href="{{ route('crear-carga') }}">Ingresar carga</a>
                                        </li>
                                    @endhasrole
                                    <li>
                                        <a href="{{ route('asignar-carga') }}">Asignar Carga</a>
                                    </li>
                                </ul>
                            </li>

                        @endif
                        <li>
                            <a href="javascript: void(0);">
                                <i class="font-18 dripicons-folder-open"></i>
                                <span>Reportes</span>
                                <span class="menu-arrow"></span>
                            </a>
                            <ul class="nav-second-level" aria-expanded="false">
                                @hasanyrole('super-admin|Recurso-Humano')
                                    <li>
                                        <a href="{{ route('reportesLicencias/vista') }}">Licencias</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('reporteAcuerdo/vista') }}">Licencias Acuerdo</a>
                                    </li>

                                    <li>
                                        <a href="{{ route('reporteConst/vista') }}">Constancia Olvido</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('Asistencia/vista') }}">Asistencia Mensual</a>
                                    </li>
                                   
                                    

                                    
                                @endhasrole
                                @hasanyrole('super-admin|Jefe-Administrativo|Jefe-Academico')
                                    <li>
                                        <a href="{{ route('reporteMensualesJefes/vista') }}">Remisión Mensuales</a>
                                    </li>
                                @endhasrole
                                <li>
                                    <a href="{{ route('historial/vista') }}">Resumen de permisos</a>
                                </li>

                                <li>
                                    <a href="{{ route('blade/asistenciaEmpleado') }}">Asistencia Personal</a>
                                </li>
                                
                            </ul>
                        </li>
                        <!--fin de para los horarios-->



                    </ul>
                </div>
                <!-- End Sidebar -->

                <div class="clearfix"></div>
            </div>
            <!-- Sidebar -left -->

        </div>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    @yield('content')

                </div> <!-- container -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer py-1 text-white" id="footerbase">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            {{ date('Y') }} &copy; Facultad Multidisciplinaria Paracentral - <a
                                href="https://www.ues.edu.sv/" class="text-white-50">Universidad de El Salvador</a>.
                            Todos los derechos reservados.
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->
        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>

    <!-- Vendor js -->
    <script src="{{ asset('template-admin/dist/assets/js/vendor.min.js') }}"></script>

    <!-- KNOB JS -->
    <script src="{{ asset('template-admin/dist/assets/libs/jquery-knob/jquery.knob.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('template-admin/dist/assets/libs/chart-js/Chart.bundle.min.js') }}"></script>


    <script src="{{ asset('template-admin/dist/assets/libs/moment/moment.min.js') }}"></script>

    <!-- Datatable js -->
    <script src="{{ asset('template-admin/dist/assets/libs/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/datatables/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/datatables/responsive.bootstrap4.min.js') }}"></script>

    {{-- Moment JS --}}
    {{-- <script src="{{asset('vendor/moment/moment.min.js') }}"></script> --}}

    {{-- DateRangPicker --}}
    <script src="{{ asset('vendor/daterangepicker/daterangepicker.js') }}"></script>
    {{-- <script src="{{asset('vendor/bootstrap-datepicker/js/bootstrap-datepicker.js') }}"></script>
        <script src="{{asset('vendor/bootstrap-datepicker/locales/bootstrap-datepicker.es.min.js') }}"></script> --}}


    <!--Summernote js-->
    <script src="{{ asset('template-admin/dist/assets/libs/summernote/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/lang/summernote-es-ES.js') }}"></script>

    <!-- Init js -->
    {{-- <script src="{{ asset('template-admin/dist/assets/js/pages/form-summernote.init.js') }}"></script> --}}
    <!-- App js -->

    <!-- Sweetalert2 -->
    <script src="{{ asset('vendor/sweetalert2/dist/sweetalert2.js') }}"></script>
    <!-- Jquery-Validate -->
    <script src="{{ asset('vendor/jquery-validation/jquery.validate.js') }}"></script>

    {{-- <script src="{{ asset('template-admin/dist/assets/libs/select2/select2.min.js') }}"></script> --}}
    {{-- Plugin de peticiones http personalizado --}}


    {{-- Plugin de peticiones http personalizado --}}
    <script src="{{ asset('js/scripts/http.min.js') }}"></script>
    <script src="{{ asset('js/scripts/peticiones.js') }}"></script>

    @yield('plugins-js')

    <script src="{{ asset('/template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.js') }}" defer>
    </script>
    <script src="{{ asset('template-admin/dist/assets/js/app.min.js') }}"></script>

</body>

</html>
