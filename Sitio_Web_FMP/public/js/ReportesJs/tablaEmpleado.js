const fecha = new Date();
const hoy = fecha.getDate();
const mesActual = fecha.getMonth();
const añoActual = fecha.getFullYear();

$('#rrhh_mes').val(mesActual).trigger("change");
$('#rrhh_anio').val(añoActual).trigger("change");



var fechaVer = añoActual + "-" + mesActual + "-" + fecha.getDate();



var table = null;
table = $('#Historial_table').DataTable({
    "order": [[1, 'desc'], [0, 'asc']],
    "language": {
        "decimal": ".",
        "emptyTable": "No hay datos para mostrar",
        "info": "Del _START_ al _END_ (_TOTAL_ total)",
        "infoEmpty": "Del 0 al 0 (0 total)",
        "infoFiltered": "(Filtrado de todas las _MAX_ entradas)",
        "infoPostFix": "",
        "thousands": "'",
        "lengthMenu": "Mostrar _MENU_ entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "No hay resultados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        },
        "aria": {
            "sortAscending": ": Ordenar de manera Ascendente",
            "sortDescending": ": Ordenar de manera Descendente ",
        }
    },
    "pagingType": "full_numbers",
    "lengthMenu": [[5, 10, 20, 25, 50, -1], [5, 10, 20, 25, 50, "Todos"]],
    "iDisplayLength": 5,
    "responsive": true,
    "autoWidth": true,
    "deferRender": true,
    "ajax": {
        "url": URL_SERVIDOR + "/admin/Historial/Reporte/" + $('#rrhh_mes').val() + '/' + $('#rrhh_anio').val(),
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
        { className: "align-middle", data: "col6" }


    ]
});
function refrescarTable() {
    table.ajax.url(URL_SERVIDOR + "/admin/Historial/Reporte/" + $('#rrhh_mes').val() + '/' + $('#rrhh_anio').val()).load();
}

$('#rrhh_mes').on('select2:select', refrescarTable);
$('#rrhh_anio').on('select2:select', refrescarTable);

//BOTON PARA GENERAR EL REPORTE
$("#descargarLicencias").click(function () {

    if ($('#rrhh_mes').val() == '' || $('#rrhh_anio').val() == '') {
        $("#modalAlerta").modal();
    } else {
        var combo = document.getElementById("rrhh_mes");
        var selected = combo.options[combo.selectedIndex].text;
        $('#mesR').val(selected);
        $('#mes').val($('#rrhh_mes').val());
        $('#anio').val($('#rrhh_anio').val());
        $('#anualesP').val($('#anualesx').text());
        $('#mensualesP').val($('#mensualesx').text());

        $("#modalPDF").modal();
    }//fin else de mostrar advertencia

});
//FIN BOTON PARA GENERAR EL REPORTE

//PARA CALCULAR LAS HORAS
let mensuales, anuales, hrs_m, hrs_a, min_m, min_a, min_t_a, min_t_m;
mensuales = anuales = hrs_m = hrs_a = min_m = min_a = min_t_a = min_t_m = 0;

var permiso = 'nuevo';
$.ajax({
    type: "GET",
    url: URL_SERVIDOR + '/admin/mislicencias/horas-mensual/' + fechaVer + '/' + permiso,
    beforeSend: function () {

    },
    success: function (json) {
        var json = JSON.parse(json);
        mensuales = json.mensuales;
        hrs_m = json.horas_acumuladas;
        min_m = json.minutos_acumulados;
    },
});

$.ajax({
    type: "GET",
    url: URL_SERVIDOR + '/admin/mislicencias/horas-anual/' + fechaVer + '/' + permiso,
    success: function (json) {
        var json = JSON.parse(json);
        anuales = json.anuales;
        hrs_a = json.horas_acumuladas;
        min_a = json.minutos_acumulados;
    },
    complete: function (json) {
        min_t_m = (parseInt(mensuales) * 60) - (parseInt(min_m) + parseInt(hrs_m) * 60);
        min_t_a = (parseInt(anuales) * 60) - (parseInt(min_a) + parseInt(hrs_a) * 60);

        var horas = parseInt(Math.trunc(min_t_a / 60));
        var minutos = parseInt((min_t_a % 60));

        $('#anualesx').text(horas + ' hrs, ' + minutos + ' min');

        var horas = parseInt(Math.trunc(min_t_m / 60));
        var minutos = parseInt((min_t_m % 60));

        $('#mensualesx').text(horas + ' hrs, ' + minutos + ' min');


    }
});
//FIN DE MOSTRAR HORAS DISPONIBLES


function obtenerHora() {
    var fechaVer = $('#rrhh_anio').val()+ "-" + $('#rrhh_mes').val()+ "-" + fecha.getDate();
    var permiso = 'nuevo';
    $.ajax({
        type: "GET",
        url: URL_SERVIDOR + '/admin/mislicencias/horas-mensual/' + fechaVer + '/' + permiso,
        beforeSend: function () {

        },
        success: function (json) {
            var json = JSON.parse(json);
            mensuales = json.mensuales;
            hrs_m = json.horas_acumuladas;
            min_m = json.minutos_acumulados;
        },
    });

    $.ajax({
        type: "GET",
        url: URL_SERVIDOR + '/admin/mislicencias/horas-anual/' + fechaVer + '/' + permiso,
        success: function (json) {
            var json = JSON.parse(json);
            anuales = json.anuales;
            hrs_a = json.horas_acumuladas;
            min_a = json.minutos_acumulados;
        },
        complete: function (json) {
            min_t_m = (parseInt(mensuales) * 60) - (parseInt(min_m) + parseInt(hrs_m) * 60);
            min_t_a = (parseInt(anuales) * 60) - (parseInt(min_a) + parseInt(hrs_a) * 60);

            var horas = parseInt(Math.trunc(min_t_a / 60));
            var minutos = parseInt((min_t_a % 60));

            $('#anualesx').text(horas + ' hrs, ' + minutos + ' min');

            var horas = parseInt(Math.trunc(min_t_m / 60));
            var minutos = parseInt((min_t_m % 60));

            $('#mensualesx').text(horas + ' hrs, ' + minutos + ' min');


        }
    });

}

$('#rrhh_mes').change(obtenerHora).click(obtenerHora);