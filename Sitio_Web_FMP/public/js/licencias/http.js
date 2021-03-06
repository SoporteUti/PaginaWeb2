function submitForm(formulario,notificacion){
    $.ajaxSetup({
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
    });
    $.ajax({
        type: $(formulario).attr('method'),
        url: $(formulario).attr('action'),
        dataType: "html",
        data: new FormData(document.getElementById(formulario.replace('#',''))),
        processData: false,
        contentType: false,
        error : function(jqXHR, textStatus){
            if (jqXHR.status === 0) {

                errorServer(notificacion,'No conectar: ​​Verifique la red.');

            } else if (jqXHR.status == 404) {

                errorServer(notificacion,'No se encontró la página solicitada [404]');

            } else if (jqXHR.status == 419) {

                errorServer(notificacion,'Su sesión expiró [419]');

            } else if (jqXHR.status == 500) {

                errorServer(notificacion,'Error interno del servidor [500].');

            } else if (textStatus === 'parsererror') {

                errorServer(notificacion,'Error al analizar JSON solicitado.');

            } else if (textStatus === 'timeout') {

                errorServer(notificacion,'Error de tiempo de espera.');

            } else if (textStatus === 'abort') {

                errorServer(notificacion,'Solicitud de Ajax cancelada.');

            } else {

                errorServer(notificacion,'Error no detectado: ' + jqXHR.responseText);
            }
            $('.modal').scrollTop($('.modal').height());
        },beforeSend:function(jqXHR, textStatus){
            $(notificacion).removeClass().addClass('alert alert-info bg-info text-white border-0').html(''
                    +'<div class="row">'
                    +'    <div class="col-lg-1 px-2">'
                    +'        <div class="spinner-border text-white m-2" role="status"></div>'
                    +'    </div>'
                    +'    <div class="col-lg-11 align-self-center" >'
                    +'      <h3 class="col-xl text-white">Cargando...</h3>'
                    +'    </div>'
                    +'</div>'
                ).show();
                $('.modal').scrollTop(0);
                disableform(formulario);
                $('.btn').prop('disabled', true);
        },
    }).then(function(data) {

        data = JSON.parse(data);
        if(data.error!=null){

            $(notificacion).removeClass().addClass('alert alert-danger bg-danger text-white border-0');
            $errores = '';

            let tipo = $.type(data.error);
            if (tipo === 'string') {
                $errores = data.error;
            } else {
                for (let index = 0; index < data.error.length; index++) {
                    $error = '<li>' + data.error[index] + '</li>';
                    $errores += $error;
                }
            }

            $(notificacion).html('<h4 Class = "text-white">Completar Campos:</h4>'
                +'<div class="row">'
                +'<div class="col-lg-9 order-firts">'
                +'<ul>'+$errores+'</ul>'
                +'</div>'
                +'<div class="col-lg-3 order-last text-center">'
                +'<li class="fa fa-exclamation-triangle fa-5x"></li>'
                +'</div>'
                +'</div>'
            ).show();
            enableform(formulario);
            $('.btn').prop('disabled', false);
        }else{
            if(data.mensaje!=null && data.error==null){
                $(notificacion).removeClass().addClass('alert alert-success bg-success text-white ').html(''
                    +'<div class="row">'
                        +'<div class="col-xl-11 order-last">'
                            +' <h3 class="col-xl text-white">'+data.mensaje+'</h3>'
                        +'</div>'
                        +'<div class="col-xl-1 order-firts">'
                            +'<i class="fa fa-check  fa-3x"></i>'
                        +'</div>'
                    +'</div>'
                ).show();                
                $('.modal').modal('hide'); 
                enableform(formulario);    
                $(formulario)[0].reset();
                $('.btn').prop('disabled', false);

            }
        }
       $('.modal').scrollTop(0);
    });
};

function errorServer(notificacion, error){
    $(notificacion).removeClass().show().addClass('alert alert-danger bg-danger text-white border-0')
    .html('<h4 Class = "text-white">Error:</h4>'
        +'<div class="row">'
        +'<div class="col-xl-8">'
        +'<ul><li>'+error+'</li></ul>'
        +'</div>'
        +'<div class="col-lg-4 text-center">'
        +'<li class="fa fa-exclamation-triangle fa-3x"></li>'
        +'</div>'
        +'</div>'
    );
};

// Add the following code if you want the name of the file appear on select
$(".custom-file-input").on("change", function() {
    var fileName = $(this).val().split("\\").pop();
    $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
});

$('.modal').on('hidden.bs.modal',function(){
    var summernote = document.getElementsByClassName('summernote-config');
    for (let index = 0; index < summernote.length; index++) {
        const element = summernote[index];
        if(Boolean(element.id)){
            $('#'.concat(element.id)).summernote("code","");
        }
    }$(".alert").hide();$("form").trigger("reset");
    $('.custom-file-input').siblings(".custom-file-label").addClass("selected").html('Seleccionar imagen');
    table.ajax.reload();     
});

function disableform(formId) {
    formId=formId.replace('#', '');
    var f = document.forms[formId].getElementsByTagName('input');
    for (var i=0;i<f.length;i++)
        f[i].disabled=true
    var f = document.forms[formId].getElementsByTagName('textarea');
    for (var i=0;i<f.length;i++)
        f[i].disabled=true
    var f = document.forms[formId].getElementsByClassName('button');
    for (var i=0;i<f.length;i++)
        f[i].disabled=false
}

function enableform(formId) {
    formId=formId.replace('#', '');
    var f = document.forms[formId].getElementsByTagName('input');
    for (var i=0;i<f.length;i++)
        f[i].disabled=false
    var f = document.forms[formId].getElementsByTagName('textarea');
    for (var i=0;i<f.length;i++)
        f[i].disabled=false
    var f = document.forms[formId].getElementsByClassName('button');
    for (var i=0;i<f.length;i++)
        f[i].disabled=false
}
