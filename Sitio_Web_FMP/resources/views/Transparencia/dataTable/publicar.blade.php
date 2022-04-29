<form method="POST" action="{{ route('admin.transparencia.publicar', [$categoria, $id]) }}" class="frmPublicar" accept-charset="UTF-8" >
    @csrf

    @php
        $texto = (strcmp($publicar, 'publicado')==0) ? 'Publicado' : 'Inhabilitado';
        $color = (strcmp($publicar, 'publicado')==0) ? 'primary' : 'warning';
    @endphp
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="{{ $id }}" name="publicar" {{ (strcmp($publicar, 'publicado')==0) ? 'checked' : '' }} >
                <label class="custom-control-label" for="{{ $id }}">Publicar</label>
            </div>
        </div>
        <div class="col-sm-12 col-md-6">
            <div class="badge badge-{{ $color }}">{{ $texto }}</div>
        </div>
    </div>

</form>
