//PARA CARGAR LOS DATOS DINAMICAMENTE EN LA TABLA
var table=null;
$("#deptoR").change(function () {
  // alert($('#inicio').val());
   // alert($('#fin').val());
    if ($('#inicio').val() == '' ||  $('#fin').val()=='') {
        $("#modalAlerta").modal();
    } else {

        table = $('#Licencias_Acuerdo_table').DataTable({
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
                "url": URL_SERVIDOR+"/admin/LicenciasAcuerdo/Tabla/Reporte/" + $('#inicio').val() + "/" + $('#fin').val() + "/" + $('#deptoR').val(),
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
                { className: "align-middle", data: "row4" }
            ]
        });

    }//fin else de mostrar advertencia

});

//FIN PARA CARGAR LOS DATOS EN LA TABLA DINAMICAMENTE

//BOTON PARA GENERAR EL REPORTE
$( "#descargarLicencias" ).click(function() {

    if ($('#inicio').val() == '' || $('#fin').val()=='') {
        $("#modalAlerta").modal();
    } else {
        $('#inicioR').val($('#inicio').val());
        $('#finR').val($('#fin').val());
        $('#deptoR_R').val($('#deptoR').val());
        $("#modalPDF").modal();
    }//fin else de mostrar advertencia
    
  });
//FIN BOTON PARA GENERAR EL REPORTE

$("#si").click(function() {
    $('#modalPDF').modal('toggle');
});