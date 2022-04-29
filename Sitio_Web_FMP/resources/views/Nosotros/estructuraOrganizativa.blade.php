@extends('Pagina/baseOnlyHtml')

@section('header')
@if(@Auth::check()?@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'):@Auth::check())
<link href="{{ asset('css/dropzone.min.css') }} " rel="stylesheet" type="text/css" />
@endif
@endsection

@section('footer')
@if(@Auth::check()?@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'):@Auth::check())
<!-- Plugins js -->
<script src="{{ asset('js/dropzone.min.js') }}"></script>

<script src="{{ asset('js/scripts/http.min.js') }}"></script>
    
<script src="{{ asset('js/scripts/estructuraOrganizativa.js') }}"></script>
<script>
    function modificarJunta(id){modificarj({!!json_encode($junta)!!}.find(x => x.id==id));}
    function modificarJefatura(id){modificarjf({!!json_encode($jefaturas)!!}.find(x => x.id==id));}
    // para recargar pagina luego de subir imagen o cerrar el modal( recarga siempre que se cierra)
    $('.bs-example-modal-center').on('hidden.bs.modal', function() { location.reload(); });
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
        <div class="my-4"></div>
        <!-- end page title -->           

        <div class="row" id="organigrama">
            <div class="col-xl-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col order-first">
                            <h3 class="my-2">Organigrama</h3>
                        </div>
                        @if(@Auth::check()?@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'):@Auth::check())                           
                        <div class="col-lg-2 order-last">
                            <button type="button" class="btn btn-info btn-block my-1 float-right"  
                                data-toggle="modal" data-target=".bs-example-modal-center"> 
                                <div class="dripicons-photo">&nbsp;Subir Imagen</div>
                            </button>
                            <div class="modal fade bs-example-modal-center" tabindex="-1" role="dialog" 
                                aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="myCenterModalLabel">Zona para subir</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form  method="post" action="{{ asset('/nosotros/organigrama/image') }}/{!! base64_encode('organigrama')!!}"
                                                class="dropzone" id="my-awesome-dropzone">
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
                        </div>
                        @endif
                    </div>
                    @if (count($organigrama)>0)
                        <img  width="100%" height="550px" src="{{ asset('/files/image') }}/{!!$organigrama[0]->file!!}" alt="{!!$organigrama[0]->file!!}">
                    @else
                        <p class="border p-2 text-center">No hay imagen del organigrama.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row" id="junta">
            <div class="col-xl-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col order-first">
                            <h3 class="my-2">Miembros de la Junta Directiva de la Facultad Multidisciplinaria Paracentral</h3>
                        </div>                        
                    </div>
                        @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'))
                            <p>{!!count($periodoJunta)==1 ? $periodoJunta[0] -> sector_dep_unid :'Periodo:'!!}</p>
                        @endif
                        
                        @if(@Auth::check()?@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'):@Auth::check())
                            <div class="row">
                                <div class="col-xl-12">
                                        <form action="{{ route('Periodo.junta') }}" method="POST">
                                            @csrf
                                            <div class="row my-2">  
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-lg-3">
                                                        <input type="text" class="form-control" required 
                                                        placeholder="Periodo (Obligatorio)"
                                                        name="periodo" 
                                                        value="{!!count($periodoJunta)==1 ? $periodoJunta[0] -> sector_dep_unid:null!!}"/>
                                                    </div>
                                                    <div class="col-lg-2">
                                                        <button type="submit" class="btn btn-block btn-info"><i class=" mdi mdi-content-save-move"></i> Guardar</button>
                                                    </div> 
                                                </div>
                                            </div>  
                                        </form>                            
                                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'):@Auth::check())
                                            <div class="col-lg-3 order-last">
                                                <a href="#" class="btn btn-block btn-info" data-toggle="modal" data-target="#myModalJunta"><i class="dripicons-document"></i> Nuevo Miembro de Junta</a>
                                                <div id="myModalJunta" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-account-multiple mdi-24px"></i> Miembro de la Junta Directiva</h3>
                                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body">                                        
                                                                <div class="tab-content">
                                                                <div class="alert alert-primary text-white" role="alert" style="display:none" id="notificacionjunta"></div>
                                                                <form action="{{ route('EstructuraOrganizativa.Junta') }}" method="POST"
                                                                     enctype="multipart/form-data" id="formulario">
                                                                    @csrf
                                                                    <input type="hidden" id="idj" name="_id">
                                                                    <div class="row">
                                                                        <div class="col-xl-12">
                                                                            <div class="form-group">
                                                                                <label>Nombre</label>
                                                                                <input type="text" class="form-control" required
                                                                                        placeholder="Nombre (Obligatorio)"
                                                                                        name="nombre" id="nombrej"/>
                                                                            </div> 
                                                                        </div>
                                                                    </div>  
                                                                    <div class="row">
                                                                        <div class="col-xl-12">
                                                                            <div class="form-group">
                                                                                <label>Sector que representa</label>
                                                                                
                                                                                <input type="text" class="form-control" required
                                                                                        placeholder="Sector que representa (Obligatorio)"
                                                                                        name="sector" id="sectorj"/>
                                                                            </div>
                                                                        </div>
                                                                    </div> 
                                                                    <div class="form-group mb-0">
                                                                       
                                                                        <button type="button" class="btn btn-primary waves-effect waves-light mr-1" 
                                                                            onclick="submitForm('#formulario','#notificacionjunta')">
                                                                            <i class="fa fa-save"></i> Guardar
                                                                        </button>
                                                                        <button type="button" data-dismiss="modal" class="btn btn-light waves-effect">
                                                                            <i class="fa fa-ban" aria-hidden="true"></i> Cancelar
                                                                        </button>
                                                                        
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
                                                                       
                                </div>
                            </div>   
                        @endif  
                        @if (count($junta)!=0)
                            <div class="table-responsive">
                                <table class="table table-bordered @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin')) table-striped @endif mb-0">
                                    <thead>
                                        <tr>
                                            <th class="tex-left">  
                                                Nombre                                          
                                            </th>
                                            <th class="text-left">
                                                Sector que representa
                                            </th>    
                                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'):@Auth::check())
                                                <th class="col-sm-1 text-left">
                                                    Acciones
                                                </th>  
                                            @endif          
                                        </tr>
                                    </thead>
                                    <tbody> 
                                        @foreach ($junta as $item)
                                        <tr>
                                            <td class="align-middle">{!!$item->nombre;!!}</td>
                                            <th class="text-nowrap align-middle" scope="row">{!!$item->sector_dep_unid;!!}</th>
                                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'):@Auth::check())                            
                                            <th class="align-middle">
                                                <div class="row text-center">
                                                    <div class="btn-group" role="group">                                
                                                        <button class="btn btn-light waves-effect width-md m-1" data-toggle="modal" data-target="#myModalJunta" onclick="modificarJunta({!!$item->id!!})">
                                                            <i class="mdi mdi-file-document-edit mdi-16p"></i>  Modificar
                                                        </button>                                                    
                                                        <button type="submit" class="btn btn-light waves-effect width-md m-1" data-toggle="modal" data-target="#modalEliminar" onclick="eliminar({!!$item->id!!})">
                                                            <i class="mdi mdi-delete"></i> Eliminar
                                                        </button>                                                      
                                                    </div>
                                                </div>                                         
                                            </th>
                                            @endif
                                        </tr>
                                        @endforeach
                                        
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive-->
                            @if(@Auth::check()?@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'):@Auth::check())
                            <div id="modalEliminar" class="modal fade bs-example-modal-center" tabindex="-1" 
                                role="dialog" aria-labelledby="myCenterModalLabel" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-delete mdi-24px"></i> Eliminar</h3>
                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{ route('JefaturaJuntaBorrar') }}" method="POST">
                                                @csrf
                                                <div class="row py-3">
                                                    <div class="col-lg-2 fa fa-exclamation-triangle text-warning fa-4x"></div>
                                                    <div class="col-lg-10 text-black">
                                                        <h4 class="font-17 text-justify font-weight-bold">Advertencia: Se elimina este registro de manera permanente, ¿Desea continuar?</h4>
                                                    </div>
                                                    <input type="hidden" name="_id" id="eliminar">
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
                        
                </div>
            </div>
        </div>
        
        <div class="row" id="jefatura">
            <div class="col-xl-12">
                <div class="card-box">
                    <div class="row">
                        <div class="col order-first">
                            <h3 class="my-2" >Jefaturas Académicas y Administrativas de la Facultad Multidisciplinaria Paracentral</h3>
                        </div>
                        
                    </div>                    
                    @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'))
                            <p>{!!count($periodoJefatura)==1 ? $periodoJefatura[0] -> sector_dep_unid :'Periodo:'!!}</p>
                    @endif
                    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'):@Auth::check())
                        <div class="row">
                            <div class="col order-first">
                                <div class="row">
                                    <div class="col-xl-12">
                                        <form action="{{ route('Periodo.jefatura') }}" method="POST">
                                            @csrf
                                            <div class="row my-2">                                            
                                                <div class="col-lg-3">
                                                    <input type="text" class="form-control" required
                                                    placeholder="Periodo (Obligatorio)"
                                                    name="periodo" value="{!!count($periodoJefatura)==1 ? $periodoJefatura[0] -> sector_dep_unid:null!!}"/>
                                                </div>
                                                <div class="col-lg-2">
                                                    <button type="submit" class="btn btn-block btn-info"><i class=" mdi mdi-content-save-move"> </i> Guardar</button>
                                                </div>                                            
                                            </div> 
                                        </form>                                    
                                    </div>
                                </div> 
                            </div>
                            <div class="col-lg-2 order-last">
                                <a class="btn btn-block btn-info" href="#" data-toggle="modal" data-target="#myModalJefatura"><i class="dripicons-document"></i> Nueva Jefatura</a>
                                <div id="myModalJefatura" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h3 class="modal-title" id="myCenterModalLabel"><i class="mdi mdi-account-multiple mdi-24px"></i> Jefatura</h3>
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                            </div>
                                            <div class="modal-body">                                        
                                                <div class="tab-content">
                                                <div class="alert alert-primary text-white" role="alert" style="display:none" id="notificacionjf"></div>
                                                <form method="POST" 
                                                action="{{ route('EstructuraOrganizativa.Jefatura') }}" 
                                                class="parsley-examples"
                                                enctype="multipart/form-data" id="jefaturaForm">
                                                    @csrf
                                                    <div class="row">
                                                        <input type="hidden" id="idjf" name="_id">
                                                        <div class="col-xl-12">
                                                            <div class="form-group">
                                                                <label>Nombre</label>
                                                                <input type="text" class="form-control" required
                                                                        placeholder="Nombre (Obligatorio)"
                                                                        name="nombre" id="nombrejf"/>
                                                            </div> 
                                                        </div>
                                                        
                                                    </div>      
                                                    <div class="row">
                                                        <div class="col-xl-12">
                                                            <div class="form-group">
                                                                <label>Departamento/Unidad</label>
                                                                <div>
                                                                    <input type="text" class="form-control" required
                                                                        placeholder="Sector que representa (Obligatorio)"
                                                                        name="jefatura" id="jefaturajf"/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>         
                                                    <div class="form-group mb-0">
                                                        <div>
                                                            <button type="button" class="btn btn-primary waves-effect waves-light mr-1"
                                                                onclick="submitForm('#jefaturaForm','#notificacionjf')">
                                                                <li class="fa fa-save"></li> Guardar
                                                            </button>
                                                            <button type="reset" class="btn btn-light waves-effect">
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
                        </div>  
                    @endif
                    @if (count($jefaturas)!=0)
                    <div class="table-responsive">
                        <table class="table table-bordered @if(@Auth::guest()?@Auth::guest():!@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin')) table-striped @endif mb-0">
                            <thead>
                                <tr>
                                    <th class="tex-left">  
                                        Nombre                                          
                                    </th>
                                    <th class="text-left">
                                        Departamento / Unidad
                                    </th>   
                                    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'):@Auth::check())
                                    <th class="col-sm-1 text-left">
                                        Acciones
                                    </th> 
                                    @endif                                                                  
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($jefaturas as $item)                                       
                                <tr>
                                    <td class="align-middle">
                                        {!!$item->nombre!!}
                                    </td>
                                    <th class="align-middle" scope="row">{!!$item->sector_dep_unid!!}</th> 
                                    @if(@Auth::check()?@Auth::user()->hasRole('Pagina-EstructuraOrganizativa|Pagina-Admin|super-admin'):@Auth::check())                                
                                    <th >                                        
                                        <div class="btn-group" role="group"> 
                                            <button href="#" class="btn btn-light waves-effect width-md m-1" data-toggle="modal" data-target="#myModalJefatura" onclick="modificarJefatura({!!$item->id!!})"><i class="mdi mdi-file-document-edit mdi-16p"></i>  Modificar</button>                                               
                                                                                     
                                            <button type="submit" class="btn btn-light waves-effect width-md m-1" data-toggle="modal" data-target="#modalEliminar" onclick="eliminar({!!$item->id!!})"><i class="mdi mdi-delete"></i>  Eliminar</button>   
                                                                                      
                                        </div>                                         
                                    </th>
                                    @endif
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div> <!-- end table-responsive-->
                    
                    @else
                    <p class="border p-2 text-center">No hay datos registrados.</p>                        
                    @endif
                    
                </div>
            </div>
        </div>
    </div> <!-- end container -->
</div> 
@endsection