@extends('layouts.admin')

@section('content')
    <!-- start page title -->
    <div class="row">
        <div class="col-xl-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="javascript: void(0);">Inicio</a></li>
                        <li class="breadcrumb-item active">Importacion de datos</li>
                    </ol>
                </div>
                <h4 class="page-title">&nbsp;</h4>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-12">

            <div class="card-box">

                <div class="row py-2">
                    <div class="col order-first">
                        <h3>
                            Importaciones de datos mensuales
                        </h3>
                    </div>
                    <div class="col-lg-1 order-last">
                        <!-- Button trigger modal -->

                    </div>
                </div>

                <!--FORMULARIO DE IMPORTACION DE DATOS-->
                <div class="row">



                    {{-- PARA AGREGAR EL FORMULARIO DE IMPORTACIONES --}}
                    <div class="col-12">

                        <div class="card bg-light mt-3">

                            <div class="card-header">

                                Importar Datos

                            </div>

                            <div class="card-body">

                                @if (session('status') == 'DATOS CARGADOS CORRECTAMENTE')
                                    <div class="alert alert-info bg-info text-white border-0" role="alert">
                                        <div class="row">
                                            <div class="col-lg-1 px-2">
                                                <div class="spinner-border text-white m-2" role="status"></div>
                                            </div>
                                            <div class="col-lg-11 align-self-center">
                                                <h3 class="col-xl text-white">{{ session('status') }}</h3>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if (session('status') == 'ERROR AL CARGAR LOS DATOS')
                                    <div class="alert alert-danger bg-danger text-white border-0" role="alert">

                                        <div class="row">
                                            <div class="col-lg-1 px-2">
                                                <div class="spinner-border text-white m-2" role="status"></div>
                                            </div>
                                            <div class="col-lg-11 align-self-center">
                                                <h3 class="col-xl text-white">{{ session('status') }}</h3>
                                            </div>
                                        </div>
                                        
                                    </div>
                                @endif

                                @if (isset($errors) && $errors->any())
                                    <div class="alert alert-danger bg-danger text-white border-0">

                                        <div class="row">
                                            <div class="col-lg-1 px-2">
                                                <div class="spinner-border text-white m-2" role="status"></div>
                                            </div>
                                            <div class="col-lg-11 align-self-center">
                                                <!-- {{ print_r($errors->all()) }}-->
                                                @foreach ($errors->all() as $error)
                                                <h3 class="col-xl text-white"> {{ $error }} </h3>
                                                @endforeach
                                            </div>
                                        </div>



                                    </div>
                                @endif
                                {{-- @if (session()->has('failures'))
                                <div class="alert alert-danger">ERRORES AL IMPORTAR LOS DATOS</div>
                                <table class="table table-danger">
                                    <tr>
                                        <th>ROW</th>
                                        <th>ATRIBUTO</th>
                                        <th>ERROR</th>
                                        <th>VALUE</th>
                                    </tr>
                                    @foreach (session()->get('failures') as $validation)
                                        <tr>
                                            <td>{{ $validation->row() }}</td>
                                            <td>{{ $validation->attribute() }}</td>
                                            <td>
                                                <ul>
                                                    @foreach ($validation->errors() as $e)
                                                        <li>
                                                            {{ $e }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td>
                                                {{ $validation->values()[$validation->attribute()] }}
                                            </td>
            
            
                                        </tr>
                                    @endforeach
                                </table>
            
                            @endif --}}

                                <div class="alert alert-primary alert-dismissible bg-primary text-white border-0 fade show"
                                    role="alert" style="display:none" id="notificacion">
                                </div>


                                <form action="{{ route('Importaciones/Excel') }}" method="POST"
                                    enctype="multipart/form-data">

                                    @csrf

                                    <input type="file" id="file" name="file" class="form-control"
                                        onchange="return fileValidation();">

                                    <br>

                                    <button class="btn btn-success" {{-- onclick="comprueba_extension(this.form, this.form.file.value, '#notificacion')" --}}>
                                        <li class="fa fa-save"></li> Importar
                                    </button>

                                    {{-- <a class="btn btn-warning" href="route('export')">Exportar</a> --}}


                                </form>

                            </div>

                        </div>

                    </div>
                    {{-- FIN DE AGREGAR EL FORMULARIO DE IMPORTACIONES --}}



                </div>

                <!--FIN DE FORMULARIO DE IMPORTACIONES DE DATOS-->

            </div> <!-- end card-box -->
        </div> <!-- end col -->
    </div>
    <!-- end row -->
@endsection

@section('plugins')
    <link href="{{ asset('template-admin/dist/assets/libs/select2/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('template-admin/dist/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.css') }}"
        rel="stylesheet" />
    <style>

    </style>
@endsection

@section('plugins-js')
    <!-- Bootstrap Select -->
    <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/select2/select2.min.js') }}"></script>
    <script src="{{ asset('template-admin/dist/assets/libs/bootstrap-timepicker/bootstrap-timepicker.min.js') }}">
    </script>
    <script>
        function fileValidation() {
            var fileInput = document.getElementById('file');
            var filePath = fileInput.value;
            var allowedExtensions = /(.xlsx)$/i;
            if (!allowedExtensions.exec(filePath)) {
                $(notificacion).removeClass().addClass('alert alert-danger bg-danger text-white border-0').html('' +
                    '<div class="row">' +
                    '    <div class="col-lg-1 px-2">' +
                    '        <div class="spinner-border text-white m-2" role="status"></div>' +
                    '    </div>' +
                    '    <div class="col-lg-11 align-self-center" >' +
                    '      <h3 class="col-xl text-white">La Extensión del archivo debe de ser .xlsx</h3>' +
                    '    </div>' +
                    '</div>'
                ).show();
                
                fileInput.value = '';
                return false;
            }else{

                $(notificacion).removeClass().addClass('alert alert-success bg-success text-white border-0').html('' +
                    '<div class="row">' +
                    '    <div class="col-lg-1 px-2">' +
                    '        <div class="spinner-border text-white m-2" role="status"></div>' +
                    '    </div>' +
                    '    <div class="col-lg-11 align-self-center" >' +
                    '      <h3 class="col-xl text-white">Archivo Correcto con extensión .xlsx</h3>' +
                    '    </div>' +
                    '</div>'
                ).show();

            }
        }
    </script>
@endsection
