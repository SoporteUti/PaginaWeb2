
Dropzone.autoDiscover = false;

$(".dropzone").dropzone({
    paramName: "file",
    acceptedFiles: "application/pdf",
    parallelUploads: 1,
    init: function() {
        this.on("success", function(file, response) {
            $(response.boton).attr('href', response.archivo)
        })
    }
});

$('#dropZonePdf').on('hidden.bs.modal',function(){ 
    Dropzone.forElement(".dropzone").removeAllFiles();
});