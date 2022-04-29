<div class="text-center">
    <a href="{{ route('admin.transparencia.directorios.edit', $id) }}" title="Modificar contenido"><button class="btn btn-outline-primary btn-sm"><i class="fa fa-edit fa-fw" aria-hidden="true"></i></button></a>
    {{--  <a href="{{ route('admin.transparencia.directorios.destroy') }}" title="Modificar contenido"><button class="btn btn-outline-danger btn-sm"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></button></a>  --}}
    <form method="POST" action="{{ route('admin.transparencia.directorios.destroy', $id) }}" accept-charset="UTF-8" style="display:inline">
        {{ method_field('DELETE') }}
        {{ csrf_field() }}
        <button type="submit" class="btn btn-outline-danger btn-sm" title="Eliminar" onclick="return confirm(&quot;Desea eliminar el Directorio?&quot;)"><i class="fa fa-trash fa-fw" aria-hidden="true"></i></button>
    </form>
</div>
