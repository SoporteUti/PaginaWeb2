const fecha = new Date();
const hoy = fecha.getDate();
const mesActual = fecha.getMonth();
const añoActual = fecha.getFullYear();


$('#mes_select').val(mesActual).trigger("change");
$('#anio_select').val(añoActual).trigger("change");




var table = null;    
table = $('#EmpleadoAsistencia').DataTable({
    "order": [[ 0, 'asc' ]],
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
        { className: "align-middle", data: "row4" },

      
    ]               
});  
function refrescarTable(){
    table.ajax.url(URL_SERVIDOR+"/admin/ReporteAsistencia/"+$('#mes_select').val()+'/'+$('#anio_select').val()).load();
}

$('#mes_select').on('select2:select',refrescarTable);
$('#anio_select').on('select2:select',refrescarTable);

//CODIGO PARA LOS MODALES

//MODAL DESCUENTOS
$('#btnDescuento').click(function(){
    // $('#modalDescuentos').modal();
     $('#modalDescuentos').modal({backdrop: 'static', keyboard: false})
 
 }); 
 //FIN DE MODAL DESCUENTOS


//PARA REPORTE DE ASISTENCIA PERSONAL
$('#btnAsistencia').click(function(){
    // $('#modalDescuentos').modal();
     $('#AsistenciasProcesar').modal({backdrop: 'static', keyboard: false})
 
 }); 

 //LIMPIAR ASISTENCIA 
function AsisSubmit() {
                           
    $(".asis").val(null).trigger("change").select2();
    $("#AsisModal")[0].reset();
    $('#AsistenciasProcesar').modal('hide')
}
//FIN DE LIMPIAR ASISTENCIA
//FIN DE REPORTE DE ASISTENCIA PERSONAL

//PARA LOS MINUTOS DE IMPUNTUALIDAD
$('#btnImpuntualidad').click(function(){
    // $('#modalDescuentos').modal();
     $('#impuntualidad').modal({backdrop: 'static', keyboard: false})
 
 }); 

 //LIMPIAR ASISTENCIA 
function ImputSubmit() {
                           
    $(".impu").val(null).trigger("change").select2();
    $("#Impuntual")[0].reset();
    $('#impuntualidad').modal('hide')
}

//FIN DE IMPUNTUALIDAD




 //FUNCION PARA SETEAR TODOS LOS MODALES
function CancelSubmit() {
                           
    $(".todos_select").val(null).trigger("change").select2();
    $("#TodosForm")[0].reset();
    $('#modalDescuentos').modal('hide')
}
//FIN DE LIMPIAR TODOS LOS MODALES
