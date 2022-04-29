function modificarj(json){
    $('#nombrej').val(json.nombre);$('#sectorj').val(json.sector_dep_unid);$('#idj').val(json.id);
}

function modificarjf(json){
    $('#nombrejf').val(json.nombre);$('#jefaturajf').val(json.sector_dep_unid);$('#idjf').val(json.id);
}

function eliminar(id){
    $('#eliminar').val(id);
}

Dropzone.options.myAwesomeDropzone = {
    paramName: "file",
    addRemoveLinks: true,
    dictRemoveFile: "Eliminar",
    uploadMultiple: false,
    parallelUploads: 1,
    maxFiles: 1,
    acceptedFiles: "image/*",    
}