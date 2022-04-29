<h4 class="text-center text-danger font-weight-bold"> <i class="fa fa-search"></i> Buscar información...</h4>
<hr>
<form method="GET" action="{{ route('transparencia.busqueda') }}" accept-charset="UTF-8"  role="search">
    <div class="row mb-0">
        <div class="col-12 col-sm-3 mb-3">
            <select class="custom-select" name="category" id="category">
                <option selected>Categoria</option>
                @foreach($categorias as $key => $value)
                    <option value="{{ $value['ruta'] }}" {{ (isset($categoria) && $categoria==$value['ruta']) ? 'selected' : '' }}>{{ $key }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-9 mb-3">
            <div class="form-group mb-0">
                <div class="input-group">
                    <input type="text" name="search" class="form-control" placeholder="Buscar información" aria-label="Recipient's username" value="{{ isset($busqueda) ? $busqueda : '' }}">
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-3 mb-3" >
            <select class="custom-select" name="subcategory" id="subcategory" {!! isset($categoria) ? ( (strcmp('documentos-jd', strtolower($categoria))==0) ? '' : 'style="display: none;"') : 'style="display: none;"' !!} >
                <option selected>Sub Categoria</option>
                @foreach($categorias['Documentos de Junta Directiva']['subcategorias'] as $key => $value)
                    <option value="{{ $key }}" {{ (isset($subcategoria) && $subcategoria==$key) ? 'selected' : '' }}>{{ Str::ucfirst($key) }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12 col-sm-7 mb-3">
            <div class="form-group">
                <div class="input-daterange input-group" data-provide="datepicker">
                    <input type="text" class="form-control" placeholder="Seleccione la fecha de inicio" name="start" value="{{ isset($start) ? $start : '' }}" />
                    <input type="text" class="form-control" placeholder="Seleccione la fecha final" name="end" value="{{ isset($end) ? $end : '' }}" />
                </div>
            </div>
        </div>
        <div class="col-12 col-sm-2 mb-3">
            <button type="submit" title="Filtrar la informacion" class="btn btn-danger btn-block"><i class="fa fa-search"></i> Buscar</button>
        </div>

    </div>
</form>
@section('footerjs')
<script type="text/javascript">

    $("#category").on('change', function () {
        let valor = $(this).val();
        $('#subcategory').hide();

        if(valor==='documentos-JD')
            $('#subcategory').show('slow');

    });

    $('.input-daterange').datepicker({
        format: "dd/mm/yyyy",
        clearBtn: true,
        language: "es",
        autoclose: false,
        todayHighlight: true,
        toggleActive: true,
        orientation: 'bottom'
    });
</script>
@endsection
