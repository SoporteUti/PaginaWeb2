<input type="hidden" name="categoria" value="{{ $categoria }}">
<div class="row">
    @if(strcmp('documentos-jd', strtolower($categoria))==0)
        <div class="col-12 col-sm-3 mb-3" >
            <label for="titulo">Sub categoria <span class="text-danger">*</span> </label>
            <select class="custom-select" name="subcategoria" id="subcategoria">
                @foreach($subcategorias as $key => $value)
                    <option value="{{ $value }}" {{ (isset($transparencia) && $transparencia->subcategoria==$value) ? 'selected' : '' }}>{{ Str::ucfirst($value) }}</option>
                @endforeach
            </select>
        </div>
    @endif
    <div class="col-12 col-sm-{{ (strcmp('documentos-jd', strtolower($categoria))==0) ? '9' : '12' }} mb-3">
        <div class="form-group">
            <label for="titulo">Título <span class="text-danger">*</span> </label>
            <input type="text" class="form-control {{ $errors->has('titulo') ? 'is-invalid' : ''}}" id="titulo" name="titulo" aria-describedby="titulo" placeholder="Ingrese el titulo para el Documento" value="{{ isset($transparencia) ? $transparencia->titulo : old('titulo') }}">
            {!! $errors->first('titulo', '<p class="invalid-feedback">:message</p>') !!}
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-sm-12">
        <div class="form-group mb-3">
            <label for="descripcion">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" placeholder="Ingrese una descripción">{{ isset($transparencia) ? $transparencia->descripcion : old('descripcion') }}</textarea>
        </div>
    </div>
    <div class="col-12 col-sm-12" {!! old('modificar_doc') ? '' : (isset($transparencia)   ? 'style="display: none;"' : '') !!} id="divPDF">
        <div class="form-group mb-3">
            <label for="summernote-editor">Documento <span class="text-danger">*</span> </label>
            <div class="file-loading">
                <input id="documento" name="documento" class="{{ $errors->has('documento') ? 'is-invalid' : ''}}" type="file" >
                {!! $errors->first('documento', '<p class="invalid-feedback">:message</p>') !!}
            </div>
        </div>
    </div>
</div>

<div class="custom-control custom-checkbox">
    <input type="checkbox" class="custom-control-input" id="publicar" value="publicado" name="publicar" {{ isset($transparencia) ? ( ($transparencia->publicar=='publicado') ? 'checked' : '' ) : 'checked' }}>
    <label class="custom-control-label" for="publicar">Publicar documento</label>
</div>

<br><br>
<hr>

<div class="text-right">
    <a href="{{ route('admin.transparencia.index', $categoria) }}" title="Listado de documentos"><button type="button" class="btn btn-dark btn-sm"><i class="fa fa-arrow-left" aria-hidden="true"></i> Retroceder</button></a>
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
        $("#descripcion").summernote({
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

    $("#documento").fileinput({
        language: 'es',
        uploadAsync: false,
        maxFileCount: 1,
        showUpload: false,
        preferIconicPreview: true, // this will force thumbnails to display icons for following file extensions
        previewFileIconSettings: { // configure your icon file extensions
            'pdf': '<i class="fas fa-file-pdf text-danger"></i>',
        },
        theme: 'explorer-fas',
        reversePreviewOrder: true,
        initialPreviewAsData: true,
        overwriteInitial: false,
        allowedFileExtensions: ["pdf"],
        showBrowse: false,
        browseOnZoneClick: true,
    }).on('filesorted', function(e, params) {
        console.log('File sorted params', params);
    }).on('fileuploaded', function(e, params) {
        console.log('File uploaded params', params);
    });
</script>
