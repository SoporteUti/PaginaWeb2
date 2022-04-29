<div class="row">
    @if($resultados>=1)
        <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                <strong><i class="fa fa-exclamation-circle"></i> Información: </strong> <strong> {{ $resultados }} </strong> resultados encontrados
            </div>
        </div>
    @endif
    @if(isset($documentos) && $resultados>0)
        @foreach($documentos as $key => $item)
            <div class="col-12">
                <div class="card-box ribbon-box">
                    <div class="ribbon ribbon-danger float-left">{{ strftime("%A, %d de %B de %Y", strtotime($item->created_at)) }}</div>
                    <div class="float-right">
                        <a href="{{ route('transparencia.download', $item->id) }}" class="btn btn-rounded btn-outline-danger btn-sm float-right"><i class="fa fa-cloud-download-alt" aria-hidden="true" title="Descargar Documento">  </i> Descargar</a>
                    </div>
                    <div class="ribbon-content mb-3">
                        <h3><a href="{{ route('transparencia.documento', [$item->categoria, $item->id]) }}">{{ $item->titulo }}</a></h3>
                        <p>{!! $item->descripcion !!}</p>
                        <div class="float-right mb-3">
                            <a href="{{ route('transparencia.documento', [$item->categoria, $item->id]) }}"> <i class="fa fa-eye"></i> Ver mas</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @elseif(!isset($documentos) || $resultados<=0)
            <div class="col-12">
                <div class="card-box text-center">
                    <p class="p-2 border">No hay documentos para mostrar.</p>
                </div>
            </div>
    @endif

    <div class="col-12">
        {{ $documentos->appends(request()->input())->links('vendor.pagination.bootstrap-4') }}
    </div>

</div>
