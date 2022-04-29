@extends('Pagina/baseOnlyHtml')

@section('appcss')

@auth
    <!-- Summernote css -->
    <link href="{{ asset('css/summernote-bs4.css') }}" rel="stylesheet" />    
@endauth
<!-- App css -->
<link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/icons.min.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ asset('css/app.min.css') }}" rel="stylesheet" type="text/css" />

@endsection

@section('footerjs')
    <!-- Vendor js -->
    <script src="{{ asset('js/vendor.min.js') }}"></script>

    <!-- App js -->
    <script src="{{ asset('js/app.min.js') }}"></script>
    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-Directorio|Pagina-Admin|super-admin'):@Auth::check())

    <script src="{{ asset('js/summernote-bs4.min.js') }}"></script>
    <script src="{{ asset('js/summernote.config.min.js') }}"></script>
    <script src="{{ asset('vendor/summernote/lang/summernote-es-ES.js') }}"></script>

    <script src="{{ asset('js/scripts/http.min.js') }}"></script><!--Este es el script que se utiliza para enviar post con un ajax generico-->
    
    <script src="{{ asset('js/scripts/directorio.js') }}"></script>
    <script>
        function modificarD(id){
            json = {!!json_encode($directorio)!!}.find(x => x.id==id);
            modificar(json);
        }
    </script>
    @endif
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
        
        <div class="row">
            <div class="col-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col order-first">
                            <h3>Directorio</h3>                   
                        </div>
                        
                        @if(@Auth::check()?@Auth::user()->hasRole('Pagina-Directorio|Pagina-Admin|super-admin'):@Auth::check())                         
                        <div class="col-lg-2 order-last container-fluid">
                            <a type="button" href="#" class="btn btn-block btn-info"
                            data-toggle="modal" data-target="#myModalDirectorio"><i class="dripicons-document"></i> Nuevo Contacto</a>
                            <!-- directorio modal content -->
                        <div id="myModalDirectorio" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h3 class="modal-title" id="myCenterModalLabel">
                                            <i class="mdi mdi-notebook-multiple mdi-24px"></i> Directorio</h3>
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                    </div>
                                    <div class="modal-body">        
                                        <div class="row">
                                            <div class="col-xl-12">
                                            <label>Nota: <code>* Campos Obligatorio</code></label>
                                            </div>
                                        </div>                                
                                        <div class="tab-content">
                                        <div class="alert alert-primary text-white" role="alert" style="display:none" id="notificacion"></div>                                        
                                        <form method="POST" 
                                        action="{{ route('Nosotros.directorio') }}" 
                                        class="parsley-examples"
                                        enctype="multipart/form-data" id="directorio">
                                            @csrf
                                            <div class="row">
                                                <input type="hidden" id="_id" name="_id">
                                                <div class="col-xl-12">
                                                    <div class="form-group">
                                                        <label>Nombre <code>*</code></label>
                                                        <input type="text" class="form-control" required
                                                                placeholder="Nombre (Obligatorio)"
                                                                name="nombre" id="nombre"/>
                                                    </div> 
                                                </div>
                                                
                                            </div>      
                                            <div class="row">
                                                <div class="col-xl-12">
                                                    <div class="form-group">
                                                        <label>Contactos <code>*</code></label>
                                                        <div>
                                                            <textarea required class="form-control summernote-config" name="contacto" id="contacto" placeholder="Contactos (Obligatorio)"></textarea>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>         
                                            <div class="form-group mb-0">
                                                <div>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light mr-1" 
                                                        onclick="submitForm('#directorio','#notificacion')">
                                                        <li class="fa fa-save"></li> Guardar
                                                    </button>
                                                    <button type="reset" class="btn btn-light waves-effect" data-dismiss="modal">
                                                        <i class="fa fa-ban" aria-hidden="true"></i> Cancelar
                                                    </button>
                                                </div>
                                            </div>
                                        </form>       
                                        </div>
                                    </div>                                    
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal --> 
                        </div>
                        @endif
                    </div>
                    @if (count($directorio)!=0)
                    <div class="table-responsive">
                        <table class="table mb-0 table-bordered  
                        @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-Directorio|Pagina-Admin|super-admin'))
                            table-striped @endif">
                            <thead>
                                <tr>
                                    <th>
                                        Nombre
                                    </th>
                                    <th class="text-lefth">
                                        Contacto
                                    </th>   
                                    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-Directorio|Pagina-Admin|super-admin'):@Auth::check())
                                    <th class="col-sm-1 text-left">
                                        Acciones
                                    </th> 
                                    @endif                          
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($directorio as $item)
                                <tr>
                                    <th class="text-nowrap" scope="row">{!!$item->nombre!!}</th>
                                    <td>{!!$item->contacto!!}</td>
                                    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-Directorio|Pagina-Admin|super-admin'):@Auth::check())                                  
                                    <th class="align-middle ">
                                        <div class="row">
                                            <div class="col text-center"> 
                                                <div class="btn-group" role="group">
                                                <button class="btn btn-light waves-effect width-md m-1" onclick="modificarD({{$item->id}})" data-toggle="modal" data-target="#myModalDirectorio"> <i class="mdi mdi-file-document-edit mdi-16p"></i> Modificar</button>
                                                <button type="buttom"  class="btn btn-light waves-effect width-md m-1" onclick="eliminar({{$item->id}})" data-toggle="modal" data-target="#modalEliminar"><i class="mdi mdi-delete"></i>  Eliminar</button>   
                                                </div>
                                            </div>
                                        </div>                                         
                                    </th>
                                    @endif
                                </tr>  
                                @endforeach                                                              
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->
                    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-Directorio|Pagina-Admin|super-admin'):@Auth::check())
                    <div id="modalEliminar" class="modal fade bs-example-modal-center" tabindex="-1" 
                        role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('directorio.borrar') }}" method="POST">
                                        @csrf
                                        <div class="row py-3">
                                            <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                                            <div class="col-lg-10 text-black">
                                                <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se elimina este registro de manera permanente, ¿Desea continuar?</h4>
                                            </div>
                                            <input type="hidden" name="_id" id="_idEliminar">
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
                    @else
                    <p class="border p-2 text-center">No hay datos registrados.</p>
                    @endif         
                             
                </div> <!-- end card-box -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->       
        
    </div> <!-- end container -->
    
</div> 
@endsection
