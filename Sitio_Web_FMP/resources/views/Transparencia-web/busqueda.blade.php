@extends('Pagina/base-transparencia')

@section('container')
<div class="card-box margin-start">
    @include('Transparencia-web._components.search')

    @if(Session::has('mensaje'))
        <div class="alert alert-{{ Session::get('tipo') }} alert-dismissible fade show mt-2" role="alert">
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
            <strong><i class="fa fa-exclamation-circle"></i> Información: </strong> {{ Session::get('mensaje'); }}
        </div>
    @endif
</div>
<div class="row">
    <div class="col-12">
        @include('Transparencia-web._components.documents')
        @include('components.sitios_interes')
    </div>
</div>
@endsection
