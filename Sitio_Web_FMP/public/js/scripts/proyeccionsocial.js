function modificar(json) {
    $('#nombre').val(json.nombre);
    $('#contacto').val(json.sector_dep_unid);
    $('#_id').val(json.id);
}

function eliminar(id) {
    $('#_idEliminar').val(id);
}