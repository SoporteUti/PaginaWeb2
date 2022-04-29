Dropzone.autoDiscover = false;

$(".dropzoneimagen").dropzone({
    paramName: "file",
    acceptedFiles: "image/*",
    parallelUploads: 1,
});


$(".dropzonepdf").dropzone({
    paramName: "file",
    acceptedFiles: "application/pdf",
    parallelUploads: 1,
});

$('.modal').on('hidden.bs.modal', function() {
    location.reload(); 
});

$('.bs-example-modal-lg').on('hidden.bs.modal', function() {
    location.reload(); 
});

