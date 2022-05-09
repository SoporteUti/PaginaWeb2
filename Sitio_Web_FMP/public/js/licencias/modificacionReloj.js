var table = null;    

$("#anio_modificacion").change(function () {

table = $('#reloj_cambios').DataTable({
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
    "destroy": true,
    "responsive": true,
    "autoWidth": true,
    "deferRender": true,
    "ajax": {
        "url": URL_SERVIDOR+"/Importaciones/Modificacion/tabla/"+$('#mes_modificacion').val()+"/"+$('#anio_modificacion').val(),
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
        { className: "align-middle text-center", data: "col5" }
      
    ]
});

});

function Asis(boton){
    if($(boton).val()!=null){
        $("#dui").val($(boton).val());               

        $("#ModificacionIncon").modal({backdrop:'static', keyboard:false});               
    }
};

//LIMPIAR ASISTENCIA 
function AsisMenSubmit() {
                           
    $(".asisMen").val(null).trigger("change").select2();
    $("#AsisMensual")[0].reset();
    $('#ModificacionIncon').modal('hide')
}
//FIN DE LIMPIAR ASISTENCIA
/*function refrescarTable(){
    table.ajax.url(URL_SERVIDOR+"/Importaciones/Modificacion/tabla/"+$('#mes_modificacion').val()+"/"+$('#anio_modificacion').val()).load();
}

$('#anio_modificacion').on('select2:select',refrescarTable);*/