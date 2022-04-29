@extends('Pagina/base-transparencia')

@section('container')

<div class="card-box margin-start">
    <div class="row">
        <div class="col-12">

            @if(strcmp(strtolower($categoria), 'documentos-jd')==0 && isset($subcategoria))
                <h1 class="text-center text-danger font-weight-bold">{{ Str::ucfirst($subcategoria) }}</h1>
                <hr class="mt-0 mb-0 pt-0 pb-0">
            @endif

            <h1 class="text-center text-danger font-weight-bold">{{ $titulo }}</h1>
            <hr>
            <h5 class="text-center font-weight-lighter">A continuación se muestra el listado completo de todos los documentos encontrados para esta categoria.</h5>
            @if(Session::has('mensaje'))
                <div class="alert alert-{{ Session::get('tipo') }} alert-dismissible fade show mt-2" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                    <strong><i class="fa fa-exclamation-circle"></i> Información: </strong> {{ Session::get('mensaje'); }}
                </div>
            @endif
        </div>
        <div class="col-12">
            <span class="float-right">
                {{-- <strong class="font-weight-lighter">Visualizacion</strong> --}}
                <button class="btn btn-outline-danger btn-sm" onclick="fnChangeView('list');" title="Seleccione el tipo de visualización como Lista"><i class="fa fa-th-list"></i></button>
                <button class="btn btn-outline-danger btn-sm" onclick="fnChangeView('table');" title="Seleccione el tipo de visualización como Tabla"><i class="fa fa-table"></i></button>
            </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12 col-sm-6 col-md-4">
        <div class="row">
            <div class="col-12">
                <div class="card-box ribbon-box">
                    <div class="ribbon ribbon-danger float-left">Categorias</div>
                    <div class="ribbon-content mb-3">
                        <div class="col order-first">
                            @isset($categorias)
                                @foreach($categorias as $key => $value)
                                    <div>
                                        <a href="{{ url('transparencia').'/'.$value['ruta'] }}" class="btn btn-link"><i class="fa fa-arrow-alt-circle-right"></i> {{ $key }}</a>
                                    </div>
                                    @foreach ($value['subcategorias'] as $index => $item)
                                        <div>
                                            <a href="{{ is_null(($item['ruta_personalizada'])) ? route('transparencia.subcategoria', [$value['ruta'], $index]) : url($item['ruta_personalizada']) }}" class="btn btn-link mt-0 mb-1 pt-0 pb-0 ml-3"><i class="fa fa-angle-double-right"></i> {{ Str::ucfirst($index) }}</a>
                                        </div>
                                    @endforeach
                                @endforeach
                            @endisset
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-6 col-md-8" id="viewList">
        @include('Transparencia-web._components.documents')
    </div>
    <div class="col-12 col-sm-6 col-md-8" style="display: none;" id="viewTable">
        <div class="card-box">
            <table class="table table-sm table-hover" style="width: 100%;">
                <thead>
                    <tr>
                        <th>Fecha</th>
                        <th>Título</th>
                        <th>Descripción</th>
                        <th class="text-center"> <i class="fa fa-file-download"></i>  </th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

@include('components.sitios_interes')

@endsection

@section('footerjs')
<script type="text/javascript">
    $(function () {
        $('table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('transparencia.datatable', $categoria) }}",
            columns: [
                {
                    data: 'created_at',
                    width: '50'
                },
                {data: 'titulo'},
                {data: 'descripcion'},
                {
                    data: 'action',
                    width: '70',
                    orderable: true,
                    searchable: true
                },
            ],
            lengthMenu:		[[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
			iDisplayLength:	5,
            order: [ [0, 'desc'] ],
            language:{
                url: '//cdn.datatables.net/plug-ins/1.10.25/i18n/Spanish.json'
            },
            dom: "<'row'<'col-md-6 col-12'l><'col-md-6 col-12'f>r> t <'row'<'col-12 text-center mb-2'i> <'col-12 dt-center'p> >",
            // dom: '<"row"<"col-sm-4"l><"col-sm-4 text-center"p><"col-sm-4"f>>tip'
        });
    });

    function fnChangeView(type){
        $('#viewList').show('slow');
        $('#viewTable').hide('slow');
        if(type==='table'){
            $('#viewList').hide('slow');
            $('#viewTable').show('slow');
        }
    }

</script>
@endsection
