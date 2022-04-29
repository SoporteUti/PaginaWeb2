function editar(json) {
    $("#_id").val(json.id);
    $("#nombre").val(json.nombre);
    $("#titulo").val(json.titulo);
    $("#modalidad").val(json.modalidad);
    $("#duracion").val(json.duracion);
    $("#asignaturas").val(json.numero_asignatura);
    $("#unidades").val(json.unidades_valorativas);
    $("#precio").val(json.precio);
    $("#contenido").summernote("code", json.contenido);
};

function eliminarMaestria(maestria) { $('#maestria').val(maestria); };
$('.bs-example-modal-center').on('hidden.bs.modal', function() { location.reload(); });