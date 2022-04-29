function editarNL(json) {
    $('#titulo').val(json.titulo);
    $('#subtitulo').val(json.subtitulo);
    $('#contenido').summernote("code", json.contenido);
    $('#_id_local').val(json.id);
}

function editarEX(json) {
    $('#tituloUrl').val(json.titulo);
    $('#subtituloUrl').val(json.subtitulo);
    $('#urlfuente').val(json.urlfuente);
    $('#_id_externa').val(json.id);
}

$('#myModalNoticia').on('hidden.bs.modal', function() { location.reload(); });