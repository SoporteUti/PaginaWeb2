$(function() {
    $('.select2').select2(
        {    
            tags: "true",
            placeholder: "Seleccione una opciÃ³n",
            allowClear: true,
            width: "100%",
            allowHtml: true,
            dropdownParent: $('#modalRegistro')
        }
    ).select2();
});

function editar(id,boton){
    $.ajax({
        type: "GET",
        url: '/admin/GS/'+id,
        beforeSend: function() {
            $(boton).prop('disabled', true).html(''
                +'<div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></div>'
            );
        },
        success: function(json) {
            json=JSON.parse(json);
            //console.log(json);
                $("#idMR").val(json.id);
                $('#id_jornada').val(json.id_tipo_jornada).trigger("change");;
                $('#hrsA').val(json.anuales);
                $('#hrsM').val(json.mensuales);
                $("#modalRegistro").modal();
        },
        complete: function() {
            $(boton).prop('disabled', false).html(''
                +'<i class="fa fa-edit font-16" aria-hidden="true"></i>'
            );
        }
    });
};
