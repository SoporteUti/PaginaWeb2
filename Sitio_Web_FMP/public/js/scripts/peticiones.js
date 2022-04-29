function getData(method, url, notificacion, data = {}) {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });


    return new Promise((resolve, reject) => {
        $.ajax({
            type: method,
            url: url,
            dataType: "JSON",
            data: data,
            error: function (jqXHR, textStatus) {
                if (jqXHR.status === 0) {

                    errorServer(notificacion, 'No conectar: ​​Verifique la red.');

                } else if (jqXHR.status == 404) {

                    errorServer(notificacion, 'No se encontró la página solicitada [404]');

                } else if (jqXHR.status == 500) {

                    errorServer(notificacion, 'Error interno del servidor [500].');

                } else if (textStatus === 'parsererror') {

                    errorServer(notificacion, 'Error al analizar JSON solicitado.');

                } else if (textStatus === 'timeout') {

                    errorServer(notificacion, 'Error de tiempo de espera.');

                } else if (textStatus === 'abort') {

                    errorServer(notificacion, 'Solicitud de Ajax cancelada.');

                } else {

                    errorServer(notificacion, 'Error no detectado: ' + jqXHR.responseText);
                }
                $('.modal').scrollTop($('.modal').height());
            },
            beforeSend: function (jqXHR, textStatus) {
                $(notificacion).removeClass().addClass('alert alert-info bg-info text-white border-0').html(''
                    + '<div class="row">'
                    + '    <div class="col-lg-1 px-2">'
                    + '        <div class="spinner-border text-white m-2" role="status"></div>'
                    + '    </div>'
                    + '    <div class="col-lg-11 align-self-center" >'
                    + '      <h3 class="col-xl text-white">Cargando...</h3>'
                    + '    </div>'
                    + '</div>'
                ).show();
                $('.modal').scrollTop(0);
            },
            success: function (data) {
                $(notificacion).removeClass().addClass('alert alert-success bg-success text-white border-0').html(''
                    + '<div class="row">'
                    + '    <div class="col-lg-11 align-self-center" >'
                    + '      <h3 class="col-xl text-white">Registro Cargado con Éxito...</h3>'
                    + '    </div>'
                    + '</div>'
                ).show();
                $('.modal').scrollTop(0);

                resolve(data)
            },
        })
    })
};
