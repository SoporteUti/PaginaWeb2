function editar(url,id,boton){
    
    $.ajax({
        type: "GET",
        url: url+'/Usuario/'+id,
        beforeSend: function() {
            $(boton).prop('disabled', true).html(''
                +'<div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></div>'
            );
        },
        success: function(json) {
            json=JSON.parse(json);
            $('#idUser').val(json.id);
            $('#usuario').val(json.name);
            $('#correo').val(json.email);
            $('#empleado').val(json.empleado).trigger('change');
        },
    });
    $.ajax({
        type: "GET",
        url: url+'/UsuarioRol/'+id,
        beforeSend: function() {
            $(boton).prop('disabled', true).html(''
                +'<div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></div>'
            );
        },
        success: function(json) {
            json=JSON.parse(json); 
            var values = [];
            for(var i in json){
                values[i] = json[i].name;
            }
            $('#roles').val(values);
            $('#roles').trigger('change');
            $('#modalRegistro').modal();
        },
        complete: function() {
            $(boton).prop('disabled', false).html(''
                +'<i class="fa fa-edit font-16" aria-hidden="true"></i>'
            );
        }
    });
    
}

$('.select2-multiple').select2();

$('.modal').on('hidden.bs.modal',function(){
    $('.selectpicker').val(null).trigger('change');
    $('.select2-multiple').val(null).trigger('change');
});