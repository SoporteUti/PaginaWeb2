<div class="row">

    <div class="col-12 col-sm-12 mb-3">
        <div class="form-group">
            <label for="nombre">Nombre <span class="text-danger">*</span> </label>
            <input type="text" class="form-control {{ $errors->has('nombre') ? 'is-invalid' : ''}}" id="nombre" name="nombre" aria-describedby="nombre" placeholder="Ingrese el Nombre" value="{{  (old('nombre')) ? old('nombre') :  (isset($directorio) ? $directorio->nombre : '') }}">
            {!! $errors->first('nombre', '<p class="invalid-feedback">:message</p>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-12">
        <div class="form-group mb-3">
            <label for="contacto">Contacto <span class="text-danger">*</span>  </label>
            <textarea class="form-control" id="contacto" name="contacto" placeholder="Ingrese una descripción">{{  (old('contacto')) ? old('contacto') :  (isset($directorio) ? $directorio->contacto : '') }}</textarea>
        </div>
    </div>
</div>


<br><br>
<hr>

<div class="text-right">
    <a href="{{ route('admin.transparencia.directorios.index') }}" title="Listado de documentos"><button type="button" class="btn btn-dark btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Retroceder</button></a>
    <button type="submit" class="btn btn-info btn-sm" title="Guardar Informacion">{!! $formMode === 'edit' ? '<i class="fa fa-edit"></i>' : '<i class="fa fa-save"></i>' !!} {{ $formMode === 'edit' ? 'Modificar' : 'Guardar' }}</button>
</div>

@section('plugins')
{{-- PLUGINS PARA SUBIR ARCHIVOS --}}
<script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
<script src="{{ asset('vendor/bootstrap-4.3.1/js/bootstrap.min.js') }}"></script>




<link rel="stylesheet" href="{{ asset('vendor/bootstrap-fileinput/css/fileinput.css') }}">
<script src="{{ asset('vendor/bootstrap-fileinput/js/fileinput.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/sortable.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/plugins/piexif.js') }}"></script>
<script src="{{ asset('vendor/bootstrap-fileinput/js/locales/es.js') }}"></script>
<link rel="stylesheet" href="{{ asset('vendor/bootstrap-fileinput/themes/explorer-fas/theme.css') }}">
<script src="{{ asset('vendor/bootstrap-fileinput/themes/explorer-fas/theme.js') }}"></script>
@endsection

<script>
    $(document).ready(function () {
        $("#contacto").summernote({
            lang: 'es-ES',
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']]
            ]
        })
    });
</script>
