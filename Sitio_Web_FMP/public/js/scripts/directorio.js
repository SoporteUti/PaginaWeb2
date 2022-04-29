function modificar(json){
    $('#nombre').val(json.nombre);$('#contacto').summernote("code",json.contacto);$('#_id').val(json.id);
}

function eliminar(id){
    $('#_idEliminar').val(id);
}