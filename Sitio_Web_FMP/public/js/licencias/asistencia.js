var table = null;    
table = $('#asistenciaLaboral').DataTable({
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
        "url": URL_SERVIDOR+"/admin/ReporteMensual/Asistencia/datableJson/"+$('#rrhh_depto').val(),
        //"url":"/admin/licencias/RRHH/datableJson/tipo/depto/anio/mes",
        "method": "GET",
        "dataSrc": function (json) {
            return json;
        }
    },
    "columns": [
        { className: "align-middle", data: "col0" },
        { className: "align-middle", data: "col1" },
        { className: "align-middle text-center", data: "col2" },
        { className: "align-middle text-center", data: "col3" },
        { className: "align-middle text-center", data: "col4" },
        { className: "align-middle text-center", data: "col5" },
        { className: "align-middle text-center", data: "col6" }
    ]               
}); 

function refrescarTable(){
    table.ajax.url(URL_SERVIDOR+"/admin/ReporteMensual/Asistencia/datableJson/"+$('#rrhh_depto').val()).load();
}

$('#rrhh_depto').on('select2:select',refrescarTable);

function Asis(boton){
    if($(boton).val()!=null){
        $("#_id").val($(boton).val());               

        $("#AsistenciasProcesar").modal({backdrop:'static', keyboard:false});               
    }
};

function AsistenciaMen(boton){
    if($(boton).val()!=null){
        $("#dui").val($(boton).val());               

        $("#AsistenciaMensual").modal({backdrop:'static', keyboard:false});               
    }
};



function descuento(boton){
    if($(boton).val()!=null){
        $("#_id_des").val($(boton).val());               

        $("#modalDescuento").modal({backdrop: 'static', keyboard: false});               
    }
};

$('#btnDescuentos').click(function(){
   // $('#modalDescuentos').modal();
    $('#modalDescuentos').modal({backdrop: 'static', keyboard: false})

});    


//LIMPIAR MODAL DE DESCUENTOS TODOS
function CancelSubmit() {
                           
    $(".todos_select").val(null).trigger("change").select2();
    $("#TodosForm")[0].reset();
    $('#modalDescuentos').modal('hide')
}
//FIN DE LIMPIAR MODAL DE DESCUENTOS TODOS

//LIMPIAR MODAL DE DESCUENTOS PARA UNA PERSONA
function DesSubmit() {
                           
    $(".des").val(null).trigger("change").select2();
    $("#graciaForm")[0].reset();
    $('#modalDescuento').modal('hide')
}
//FIN DE LIMPIAR MODAL DE DESCUENTOS PARA UNA PERSONA


//LIMPIAR ASISTENCIA 
function AsisSubmit() {
                           
    $(".asis").val(null).trigger("change").select2();
    $("#AsisModal")[0].reset();
    $('#AsistenciasProcesar').modal('hide')
}
//FIN DE LIMPIAR ASISTENCIA
//LIMPIAR ASISTENCIA 
function AsisMenSubmit() {
                           
    $(".asisMen").val(null).trigger("change").select2();
    $("#AsisMensual")[0].reset();
    $('#AsistenciaMensual').modal('hide')
}
//FIN DE LIMPIAR ASISTENCIA
