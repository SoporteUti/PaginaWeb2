const fecha = new Date();
const hoy = fecha.getDate();
const mesActual = fecha.getMonth();
const añoActual = fecha.getFullYear();

$('#rrhh_mes').val(mesActual).trigger("change");
$('#rrhh_anio').val(añoActual).trigger("change");


var table = null;    
table = $('#Mensuales_table').DataTable({
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
        "url": URL_SERVIDOR+"/admin/ReporteMensual/Reporte/"+$('#rrhh_mes').val()+'/'+$('#rrhh_anio').val(),
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
        { className: "align-middle", data: "col3" }
    ]               
});  
function refrescarTable(){
    table.ajax.url(URL_SERVIDOR+"/admin/ReporteMensual/Reporte/"+$('#rrhh_mes').val()+'/'+$('#rrhh_anio').val()).load();
}

$('#rrhh_mes').on('select2:select',refrescarTable);
$('#rrhh_anio').on('select2:select',refrescarTable);

//BOTON PARA GENERAR EL REPORTE
$( "#descargarLicencias" ).click(function() {

    if ($('#rrhh_mes').val() == '' || $('#rrhh_anio').val()=='') {
        $("#modalAlerta").modal();
    } else {
        var combo = document.getElementById("rrhh_mes");
        var selected = combo.options[combo.selectedIndex].text;
        $('#mesR').val(selected);
        $('#mes').val($('#rrhh_mes').val());
        $('#anio').val($('#rrhh_anio').val());        
        $("#modalPDF").modal();
    }//fin else de mostrar advertencia
    
  });
//FIN BOTON PARA GENERAR EL REPORTE