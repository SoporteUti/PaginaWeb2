@extends('Pagina/base-transparencia')

@section('container')
<div class="card-box margin-start">

    <h4>Directorio <strong>Unidad de Acceso a la Información Pública</strong></h4>
    <hr>
    <table class="table table-sm table-hover">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Contacto</th>
            </tr>
        </thead>
        <tbody>
            @isset($directorios)
                @foreach ($directorios as $index => $item )
                    <tr>
                        <td>{{ $item->nombre }}</td>
                        <td>{!! $item->contacto !!}</td>
                    </tr>
                @endforeach
            @endisset
        </tbody>
    </table>

</div>
<div class="row">
    <div class="col-12">
        @include('components.sitios_interes')
    </div>
</div>
@endsection
