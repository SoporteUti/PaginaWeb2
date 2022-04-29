@extends('Pagina/base-transparencia')

@section('container')
<div class="card-box margin-start">
    <h1 class="text-center text-danger font-weight-bold mt-0 pt-0">{{ $titulo }}</h1>
    <hr class="mt-0 mb-0 pt-0 pb-0">
    <h3 class="text-center text-danger font-weight-bold"> <span class="font-weight-light"><i class="fa fa-folder-open"></i> Documento: </span>  {{ $documento->titulo }}</h3>

    @if(Session::has('mensaje'))
        <div class="alert alert-{{ Session::get('tipo') }} alert-dismissible fade show mt-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong><i class="fa fa-exclamation-circle"></i> Información: </strong> {{ Session::get('mensaje'); }}
        </div>
    @endif

</div>
<div class="row">
    <div class="col-12 col-sm-12 col-md-4">
        <div class="card-box ribbon-box">
            <div class="ribbon ribbon-danger float-left">Relacionados</div>
            <div class="ribbon-content mb-4">
                <div class="col order-first">
                    @if(isset($documentos))
                        @foreach($documentos as $key => $item)
                            <div>
                                <a href="{{ url('transparencia').'/'.$categoria.'/'.$item->id }}" data-id="{{ Hash::make($item->id) }}" class="documentos btn btn-link"><i class="fa fa-file-pdf"></i> {{ $item->titulo }}</a>
                                <a href="{{ route('transparencia.download', $item->documento) }}" class="float-right"><i class="fa fa-cloud-download-alt" aria-hidden="true" style="color: #f34943" title="Descargar Documento"> <span class="text-white" style="display: none;"> Descargar </span> </i></a>
                            </div>
                        @endforeach
                    @elseif(!isset($documentos) || $resultados<=0)
                        <div class="col-12">
                            <div class="card-box text-center">
                                <p class="p-2 border">No hay documentos para mostrar.</p>
                            </div>
                        </div>
                    @endif

                </div>
                <div class="float-right mt-2">
                    <a href="{{ route('transparencia.categoria', $categoria) }}" class="font-weight-light"><i class="fa fa-eye"></i> Ver todos ...</a>
                </div>
            </div>
        </div>
    </div>
    <div class="col-12 col-sm-12 col-md-8">
        <div class="card-box ribbon-box">
            <div class="ribbon ribbon-info float-left">
                <a href="{{ route('transparencia.categoria', $categoria) }}" class="text-white"> <i class="fa fa-chevron-circle-left"></i> Ir a la categoría </a>
            </div>
            <a href="{{ route('transparencia.download', $documento->id) }}" class="btn btn-rounded btn-outline-danger btn-sm float-right"><i class="fa fa-cloud-download-alt" aria-hidden="true" title="Descargar Documento">  </i> Descargar</a>
            <div class="ribbon-content mb-4">
                <div class="col order-first">
                    @if(!empty($documento->descripcion))
                        <h5 class="font-weight-semibold">Descripción</h5>
                        <p> {!! $documento->descripcion !!} </p>
                        <hr>
                    @endif

                    <h5 class="font-weight-semibold"> <i class="fa fa-calendar-day" style="color: #f34943"></i> Fecha de publicación: <span>{{ strftime("%A, %d de %B de %Y", strtotime($documento->created_at)) }}</span> </h5>
                    <hr>
                    @if (file_exists( public_path('storage').'/'.$documento->documento))
                        <embed src="{{ asset('storage').'/'.$documento->documento }}" type="application/pdf" width="100%" height="600px" />
                    @else
                        <div class="row">
                            <div class="col-12">
                                <div class="card-box text-center">
                                    <p class="p-2 border"> <i class="fa fa-info-circle"></i> No es posible cargar el archivo.</p>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.sitios_interes')
@endsection
