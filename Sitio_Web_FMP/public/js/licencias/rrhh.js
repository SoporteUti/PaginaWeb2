var table = null;    
table = $('#misLicenciasRRHHTable').DataTable({
    "order": [[ 1, 'desc' ], [ 0, 'asc' ]],
    "language": {
        "decimal":        ".",
        "emptyTable":     "No hay datos para mostrar",
        "info":           "Del _START_ al _END_ (_TOTAL_ total)",
        "infoEmpty":      "Del 0 al 0 (0 total)",
        "infoFiltered":   "(Filtrado de todas las _MAX_ entradas)",
        "infoPostFix":    "",
        "thousands":      "'",
        "lengthMenu":     "Mostrar _MENU_ entradas",
        "loadingRecords": "Cargando...",
        "processing":     "Procesando...",
        "search":         "Buscar:",
        "zeroRecords":    "No hay resultados",
        "paginate": {
                "first":      "Primero",
                "last":       "Ultimo",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
        "aria": {
                "sortAscending":  ": Ordenar de manera Ascendente",
                "sortDescending": ": Ordenar de manera Descendente ",
            }
    },
    "pagingType": "full_numbers",
    "lengthMenu": [[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
    "iDisplayLength": 5,
    "responsive": true,                
    "autoWidth": true,                
    "deferRender": true,
    "ajax":{
        "url": URL_SERVIDOR+"/admin/licencias/RRHH/datableJson/"+$('#rrhh_depto').val()+'/'+$('#rrhh_mes').val()+'/'+$('#rrhh_anio').val()+'/'+$('#filtrar').val(),
        //"url":"/admin/licencias/RRHH/datableJson/tipo/depto/anio/mes",
        "method": "GET",
        "dataSrc": function (json) {
            return json;
        }
    },
    "columns": [
        { className: "align-middle", data: "col0" },
        { className: "align-middle", data: "col1" },
        { className: "align-middle", data: "col2" },
        { className: "align-middle", data: "col3" },
        { className: "align-middle", data: "col4" },
        { className: "align-middle", data: "col5" },
        { className: "align-middle", data: "col6" },
        { className: "align-middle text-center", data: "col7" }
    ]               
});  
function refrescarTable(){
    table.ajax.url(URL_SERVIDOR+"/admin/licencias/RRHH/datableJson/"+$('#rrhh_depto').val()+'/'+$('#rrhh_mes').val()+'/'+$('#rrhh_anio').val()+'/'+$('#filtrar').val()).load();
}

$('#rrhh_depto').on('select2:select',refrescarTable);
$('#rrhh_mes').on('select2:select',refrescarTable);
$('#rrhh_anio').on('select2:select',refrescarTable);
$('#filtrar').on('select2:select',refrescarTable);


$( function () {
        $('.select2').select2();            

        $(".summernote-config").summernote({
            lang: 'es-ES',
            height: 100,
            toolbar: [
                ['view', ['fullscreen']],           
            ]
        });
        $('#justificacion').summernote('disable');
        $('#observaciones').summernote('disable');
        $("#tipo_representante").prop("disabled", true);
        $("#tipo_permiso").prop("disabled", true);
         //para la constancia de olvido de marcaje
         $('#justificacionConst').summernote('disable');
        $("#marcaje").prop("disabled", true);
            
        $('#btnArchivoExcel').click(function(){$('#modalExcel').modal();});    
    });

$('#ActualizarTabla').click(refrescarTable);

$('#tipo_permiso').on('select2:select',obtenerHora);
$('#fecha_de_uso').change(obtenerHora).click(obtenerHora);
$('#hora_inicio').change(calcularHora).click(calcularHora);
$('#hora_final').change(calcularHora).click(calcularHora);

 //FUNCION PARA ACEPTAR CONSTANCIA
 function aceptarConst(boton){
    $('#aceptarr_id').val($(boton).val());
    $('#modalAceptarConst').modal();
}
//FIN DE FUNCION PARA ACEPTAR CONSTANCIA
    
function aceptar(boton){
    $('#aceptar_id').val($(boton).val());
    $('#modalAceptar').modal();
}
function observaciones(boton){
    if($(boton).val()!=null){
            $.ajax({
                type: "GET",
                url: URL_SERVIDOR+'/admin/mislicencias/procesos/'+$(boton).val(),
                beforeSend: function() {
                    $(boton).prop('disabled', true).html(''
                        +'<i class="fa fa-edit font-16 py-1" aria-hidden="true"></i>'
                    );
                    $(boton).prop('disabled', true).html(''
                        +'<div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></div>'
                    );
                },
                success: function(json) {   
                    var json = JSON.parse(json);   
                    var tabla = $('#obs-table').DataTable();
                    tabla.clear().draw(false);
                    for (var i in json) {     
                        var html= '<tr>'
                        +'<td class="col-sm-3">'+json[i].fecha+'</td>'
                        +'<td class="col-sm-3"><span class="badge badge-primary font-13">'+json[i].proceso+'</span></td>'
                        +'<td class="col-xs-6">'+(json[i].observaciones==null?'Ninguna':json[i].observaciones)+'</td>'
                        +'</tr>';    
                        tabla.row.add($.parseHTML(html)[0]).draw(false);
                    }   
                    $("#modalObservaciones").modal();
                },
                complete: function(json) {
                    $(boton).prop('disabled', false).html(''
                        +'<i class="fa fa-eye font-16 py-1" aria-hidden="true"></i>'
                    );
                }
            });                
    }
};

$('.modal').on('hidden.bs.modal',function(){
    $("form").trigger("reset");
});

//FUNCION PARA VER LOS DATOS DE CONSTANCIA DE OLVIDO
function verDatosConst(boton) {
    if ($(boton).val() != null) {
        $.ajax({
            type: "GET",
            url: URL_SERVIDOR+'/admin/licencias/jefaturaRRHH/' + $(boton).val(),
            beforeSend: function() {
                $(boton).prop('disabled', true).html('' +
                    '<div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></div>'
                );
            },
            success: function(json) {
                var json = JSON.parse(json);
                console.log(json);
                $('#idPermisoC').val(json.permiso);
                $('#nombreC').val(json.nombre);
                $('#apellidoC').val(json.apellido);
                $('#justificacionConst').summernote("code", json.justificacion);             
                $('#marcaje').val(json.olvido).trigger("change");
                $('#fecha').val(json.fecha_uso).change();
                $('#hora').val(json.hora_inicio);
                $('#observacionesConst').summernote("code", json.observaciones);
                json.rrhh?$('#guardar_registro_constancia').show():$('#guardar_registro_constancia').hide();
                !json.rrhh?$('#constancia_rrhh').hide():$('#constancia_rrhh').show();
                                 
                $('#modalConstancia').modal();
            },
            complete: function(json) {
                $(boton).prop('disabled', false).html('' +
                    '<i class="fa fa-file-alt font-16 py-1" aria-hidden="true"></i>'
                );
            }
        });
    }
}
//FIN DE VER DATOS DE CONSTANCIA DE OLVIDO

function verDatos(boton) {
    if($(boton).val()!=null){
        $.ajax({
            type: "GET",
            url: URL_SERVIDOR+'/admin/licencias/jefaturaRRHH/'+$(boton).val(),
            beforeSend: function() {
                $(boton).prop('disabled', true).html(''
                    +'<div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></div>'
                );
            },
            success: function(json) {  
                var json = JSON.parse(json); 
                console.log(json.rrhh);
                $('#idPermiso').val(json.permiso);  
                $('#nombre').val(json.nombre);                 
                $('#apellido').val(json.apellido);                 
                $('#justificacion').summernote("code",json.justificacion);
                $('#observaciones').summernote("code",json.observaciones);
                $('#tipo_representante').val(json.tipo_representante).trigger("change");
                $('#tipo_permiso').val(json.tipo_permiso).trigger("change");
                $('#fecha_de_presentacion').val(json.fecha_presentacion).change();
                $('#fecha_de_uso').val(json.fecha_uso).change();                                   
                $('#hora_inicio').val(json.hora_inicio);
                $('#hora_final').val(json.hora_final);
                json.rrhh?$('#guardar_rrhh').show():$('#guardar_rrhh').hide();
                !json.rrhh?$('#observaciones_recursos_humanos_constancia').hide():$('#observaciones_recursos_humanos_constancia').show();
                $('#modalRegistro').modal();
            },
            complete: function(json) {
                $(boton).prop('disabled', false).html(''
                    +'<i class="fa fa-file-alt font-16 py-1" aria-hidden="true"></i>'
                );
            }
        });                
    }
}