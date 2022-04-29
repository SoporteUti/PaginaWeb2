<div class="text-center">
    <button type="button" data-id="{{ $id }}" data-categoria="{{ $categoria }}" data-toggle="modal" data-target="#modalViewPDF" class="btn btn-outline-info btn-sm btnViewPDF" title="Visualizar PDF"><i class="fa fa-file-pdf fa-fw" aria-hidden="true"></i></button>
    <a href="{{ route('admin.transparencia.edit', [$categoria, $id]) }}" title="Modificar contenido"><button class="btn btn-outline-primary btn-sm"><i class="fa fa-edit fa-fw" aria-hidden="true"></i></button></a>
    {{-- <form method="POST" action="{{ url('/employees' . '/' . $id) }}" accept-charset="UTF-8" style="display:inline">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <button type="submit" class="btn btn-danger btn-sm" title="Eliminar" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></button>
    </form> --}}
</div>
