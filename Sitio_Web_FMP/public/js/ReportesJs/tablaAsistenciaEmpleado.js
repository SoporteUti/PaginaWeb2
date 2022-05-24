var table = null;    
table = $('#EmpleadoAsistencia').DataTable({
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
        "url": URL_SERVIDOR+"/admin/ReporteAsistencia/"+$('#mes_select').val()+'/'+$('#anio_select').val(),
        //"url":"/admin/licencias/RRHH/datableJson/tipo/depto/anio/mes",
        "method": "GET",
        "dataSrc": function (json) {
            return json;
        }
    },
    "columns": [
        { className: "align-middle", data: "row0" },
        { className: "align-middle", data: "row1" },
        { className: "align-middle", data: "row2" },
        { className: "align-middle", data: "row3" },
      
    ]               
});  
function refrescarTable(){
    table.ajax.url(URL_SERVIDOR+"/admin/ReporteAsistencia/"+$('#mes_select').val()+'/'+$('#anio_select').val()).load();
}

$('#mes_select').on('select2:select',refrescarTable);
$('#anio_select').on('select2:select',refrescarTable);
