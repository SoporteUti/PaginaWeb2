var items = [];

//Funcion para eliminar fila
let btncallback = function (e, cell) {
    Swal.fire({
        title: "Advertencia",
        text: "Se elimina este registro, ¿Desea continuar?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "No",
        confirmButtonText: "Si"
    }).then(result => {
        if (result.isConfirmed) {
            let row = cell.getRow();
            row.delete();
            updateChangeTable();
        }
    });
};

//funciona para gregar el boton de eliminar fila
let btn = function (value, data, cell, row, options) {
    return `<center><button type="button" class="btn btn-sm btn-secondary" title="Eliminar Fila"> <i class="fa fa-times"></i> </button></center>`;
};

//funciont para actualizar el monto por fila
function updateHour(cell) {
    var alert = '';
    let row = cell.getRow();
    let data = cell.getData();
    let inicio = data.hora_inicio;
    let fin = data.hora_fin;
    let resul = CalcularHoras(inicio,fin);

    if(isNaN(inicio) && isNaN(fin) ){
        let H = resul.split(":");
        if (parseInt(H[0]) > 10 || (parseInt(H[0]) >= 10 && H[1] != '00')) {
            alert += `<div class="alert alert-danger mt-3" role="alert">
                            <div class="alert-message">
                                <strong> <i class="fa fa-info-circle"></i> Información!</strong> Las horas registradas exceden el número de horas permitidas
                            </div>
                        </div>`;
            row.update({ 'hora_inicio': null });
            row.update({ 'hora_fin': null });
        }else{
            row.update({ 'jornada': resul });
        }
    }


    let valor = $("#auxJornada").val();
    let hoursTotal = fnHoras();

    let total = CalcularHoras(hoursTotal,valor);
    validateHoras(valor, total);
    // console.log('T ' + total);
    $("#_horas").val('' + total);

    //Valores de Carga Academica
    //let id = $("#id_emp").val();
    //validarCarga_Jornada(id,row,data,inicio,fin);

    //para validar el horario segun horario de carga academica
    /*if (parseInt(inicio) > 0 && parseInt(fin) > 0){
        if(parseInt(inicio)>=parseInt(fin)){
            alert += `<div class="alert alert-danger mt-3" role="alert">
                            <div class="alert-message">
                                <strong> <i class="fa fa-info-circle"></i> Información!</strong>  Horas inválidas, la hora de entrada no puede ser mayor que la hora de salida
                            </div>
                        </div>`;
            row.update({ 'hora_inicio': null });
            row.update({ 'hora_fin': null });
        }else if (!Boolean((data.dia).trim())) {//para validar que este selecciona un Dia por fila
            alert += `<div class="alert alert-danger mt-3" role="alert">
                            <div class="alert-message">
                                <strong> <i class="fa fa-info-circle"></i> Información!</strong>  Seleccione un dia para continuar con el registro
                            </div>
                        </div>`;
        } else if (Boolean((data.dia).trim())) {
            $.ajax({
                type: "POST",
                url: '/admin/jornada-check-dia',
                data: {
                    empleado: $("#id_emp").val(),
                    inicio: inicio,
                    fin: fin,
                    dia: data.dia,
                    periodo: $("#id_periodo").val()
                },
                success: function (data) {
                    console.log(data);
                },
                error: function (xhr, status, error) {
                    console.error(xhr);
                }
            });
        }
    } */

    // para validar el total de las horas
    validateHoras(valor, total);
    $("#days-table").after(alert);
}

/*function validarCarga_Jornada(id,row,data,inicio,fin) {
    var alert = '';
    let datas = getData('GET', `/admin/jornada/detalleCarga/`+id);
        datas.then(function(response){
            $(response).each(function (index, element) {
                if(element.dias == data.dia){
                    console.log(element.dias + ' ----- '+data.dia);
                    if(parseInt(inicio) >= parseInt(element.inicio)){
                        console.log(inicio + ' ----- '+ element.inicio);

                        //No salen alertas de comparacion entre carga academica y jornada
                        alert += `<div class="alert alert-danger mt-3" role="alert">
                            <div class="alert-message">
                            <strong> <i class="fa fa-info-circle"></i> Información!</strong>  Horas no permitida, la hora de entrada no puede ser mayor a la hora de inicio de clase
                            </div>
                        </div>`;
                        row.update({ 'hora_inicio': null });
                    }else{
                        if(parseInt(fin) < parseInt(element.fin) ){
                            alert += `<div class="alert alert-danger mt-3" role="alert">
                                    <div class="alert-message">
                                        <strong> <i class="fa fa-info-circle"></i> Información!</strong>  Horas no permitida, la hora de salida no puede ser menor a la hora de finalizacion de clase
                                    </div>
                                </div>`;
                            row.update({ 'hora_fin': null });
                        }
                    }
                }
            });
        });
}*/

//para calcular el total horas por fila
function fnHoras() {
    let dataColumn = table.getColumn('jornada');
    let hourRow = 0;
    let minuteRow = 0;

    $.each(dataColumn.getCells(), function (indexInArray, valueOfElement) {
        let cellVall = valueOfElement._cell.value;
        let fieldCell = cellVall.split(':');
        let HourCell = isNaN(parseFloat(fieldCell[0])) ? 0 : parseFloat(fieldCell[0]); let MinuteCell = isNaN(parseFloat(fieldCell[1])) ? 0 : parseFloat(fieldCell[1]);
        var horas_Cell = HourCell * 3600; var minutos_Cell = MinuteCell * 60; var segundosC = minutos_Cell + horas_Cell;
        var hoursCe = Math.floor( segundosC / 3600 ); var minutesCe = Math.floor( (segundosC % 3600) / 60 );

        //Anteponiendo un 0 a los minutos y horas si son menos de 10
        minutesCe = minutesCe < 10 ? '0' + minutesCe : minutesCe;
        hoursCe = hoursCe < 10 ? '0' + hoursCe : hoursCe;

        hourRow += parseInt(hoursCe);
        minuteRow += parseInt(minutesCe);
        // console.log('Hora row' + hoursCe + ":" + minutesCe);
    });
    hourRow =  isNaN(hourRow) ? 0 : parseInt(hourRow);
    minuteRow =  isNaN(minuteRow) ? 0 : parseInt(minuteRow);
    // console.log('Hora AA ' + hourRow + ':' + minuteRow);

    let timeT = hourRow + ':' + minuteRow;

    return isNaN(timeT) ? timeT : '' ;
}

//funcion para gregar una nueva fila
$("#btnNewRow").on('click', function () {
    table.addRow({ dia: "", hora_inicio: "", hora_fin: "", jornada: "" }, false);
});

//Create Date Editor
var dateEditor = function (cell, onRendered, success, cancel) {
    //cell - the cell component for the editable cell
    //onRendered - function to call when the editor has been rendered
    //success - function to call to pass the successfuly updated value to Tabulator
    //cancel - function to call to abort the edit and return to a normal cell

    //create and style input
    var cellValue = moment(cell.getValue, "HH:mm").format("HH:mm"),
        input = document.createElement("input");

    input.setAttribute("type", "time");

    input.style.padding = "4px";
    input.style.width = "100%";
    input.style.boxSizing = "border-box";

    input.value = cellValue;

    onRendered(function () {
        input.focus();
        input.style.height = "100%";
    });

    function onChange() {
        if (input.value != cellValue) {

            if(input.value!==''){
                let alert = '';
                success(moment(input.value, "HH:mm").format("HH:mm"));
                $("#days-table").after(alert);
            }
        } else {
            cancel();
        }
    }

    //submit new value on blur or change
    input.addEventListener("blur", onChange);

    //submit new value on enter
    input.addEventListener("keydown", function (e) {
        if (e.keyCode == 13) { onChange(); }
        if (e.keyCode == 27) { cancel(); }
    });

    return input;
};
//initialize table
var table = new Tabulator("#days-table", {
    data: items,           //load row data from array
    layout: "fitColumns",      //fit columns to width of table
    responsiveLayout: "hide",  //hide columns that dont fit on the table
    tooltips: true,            //show tool tips on cells
    addRowPos: "top",          //when adding a new row, add it to the top of the table
    history: true,             //allow undo and redo actions on the table
    pagination: false,       //paginate the data
    // paginationSize:7,         //allow 7 rows per page of data
    movableColumns: true,      //allow column order to be changed
    resizableRows: true,       //allow row order to be changed
    initialSort: [             //set the initial sort order of the data
    ],

    columns: [//define the table columns
        // { title: "", field: "id" },
        { title: "", field: "option", formatter: btn, cellClick: btncallback },
        { title: "Dia", field: "dia", editor: "select", validator: ["required", "unique"], editorParams: { values: ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"] }, cellEdited: updateHour},
        { title: "Entrada", field: "hora_inicio", hozAlign: "center", sorter: "time", editor: dateEditor,cellEdited: updateHour},
        { title: "Salida", field: "hora_fin", hozAlign: "center", sorter: "time", editor: dateEditor, cellEdited: updateHour},
        { title: "Jornada", field: "jornada", editor: false, validator: "numeric"},
    ],
});


function updateJornada() {
    let valor = $("#auxJornada").val();
    let hoursTotal = fnHoras();
    let total = CalcularHoras(hoursTotal,valor);
    // console.log('anted de validar '+ total);
    validateHoras(valor, total);
    return total;
}

function validateHoras(valor, total){
    $(".alert-danger").remove();
    valor = parseInt(valor);
    total = parseInt(total);
    var mensaje = '';
    let validado = true;
    let restante = valor-total;
    //console.log(restante);

    if (restante>valor) {
        validado = false;
        mensaje = 'Las horas registradas exceden el número de horas permitidas';
    }

    if (mensaje!=='') {
        let alert = `<div class="alert alert-danger mt-3" role="alert">
                            <div class="alert-message">
                                <strong> <i class="fa fa-info-circle"></i> Información!</strong>  ${mensaje}
                            </div>
                        </div>`;

        $("#days-table").after(alert);
    }
    return validado;
}

function updateChangeTable(){
    let total = $(".total-horas").val();
    let updatehours = updateJornada();
    // console.log('anted de updateChangeTable '+updatehours);

    $("#_horas").val(updatehours);
    validateHoras(total, updatehours);
}

function CalcularHoras(inicio, fin) {
    //fin
    let hoursF = fin;
    let fieldF = hoursF.split(':');
    let HourF = isNaN(parseFloat(fieldF[0])) ? 0 : parseFloat(fieldF[0]); let MinuteF = isNaN(parseFloat(fieldF[1])) ? 0 : parseFloat(fieldF[1]);
    var horas_F = HourF * 3600; var minutos_F = MinuteF * 60; var segundosF = minutos_F + horas_F;
    var hoursFi = Math.floor( segundosF / 3600 ); var minutesFi = Math.floor( (segundosF % 3600) / 60 );

    //Anteponiendo un 0 a los minutos y horas si son menos de 10
    hoursFi = hoursFi < 10 ? '0' + hoursFi : hoursFi;
    minutesFi = minutesFi < 10 ? '0' + minutesFi : minutesFi;
    // console.log('valor (FIN) ' + hoursFi + ":" + minutesFi);

    //inicio
    let hoursI = inicio;
    let fieldI = hoursI.toString().split(':');
    // console.log('Horas Tot (INICIO) ' + hoursI);

    let HourI = isNaN(parseFloat(fieldI[0])) ? 0 : parseFloat(fieldI[0]); let MinuteI = isNaN(parseFloat(fieldI[1])) ? 0 : parseFloat(fieldI[1]);
    var horas_I = HourI * 3600; var minutos_I = MinuteI * 60; var segundosI = minutos_I + horas_I;
    var hoursIn = Math.floor( segundosI / 3600 ); var minutesIn = Math.floor( (segundosI % 3600) / 60 );

    //Anteponiendo un 0 a los minutos y horas si son menos de 10
    hoursIn = hoursIn < 10 ? '0' + hoursIn : hoursIn;
    minutesIn = minutesIn < 10 ? '0' + minutesIn : minutesIn;
    // console.log('Total CalcularHoras' +hoursIn + ":" + minutesIn);

    var diffMTotal = 0;
    var diffHTotal = 0;

    if(minutesIn > minutesFi ){
        // console.log(minutesIn + ' '+ minutesFi);
        diffMTotal = 60 - parseInt(minutesIn);
        diffHTotal = -1;
        if(parseInt(diffMTotal) < 10){
            diffMTotal = '0' + diffMTotal;
        }
    }else if(parseInt(minutesFi) - parseInt(minutesIn) < 10){
        diffMTotal = '0' + ( parseInt(minutesFi) - parseInt(minutesIn));
    } else{
        diffMTotal = parseInt(minutesFi) - parseInt(minutesIn);
    }

    if(parseInt(hoursIn) > parseInt(hoursFi)){
        // console.log('condicicon 0 ' + hoursIn + ' '+ hoursIn);
        diffHTotal = parseInt(hoursIn);
    } else
    if(parseInt(hoursFi) - parseInt(hoursIn) < 10){
        // console.log('condicicon < 10 ' + hoursIn + ' '+ hoursIn);

        if(parseInt(diffHTotal) == -1 ){
            diffHTotal = parseInt(0) + ( parseInt(diffHTotal) + parseInt(hoursFi) -  (parseInt(hoursIn) ) );
        }else{
            diffHTotal = '0' + ( parseInt(diffHTotal) + (parseInt(hoursFi) - parseInt(hoursIn) ));
        }
    } else{
        // console.log('condicicon ' + hoursIn + ' '+ hoursIn);
        diffHTotal =  parseInt(diffHTotal) + ( parseInt(hoursFi) - (parseInt(hoursIn)));
    }

    // console.log('_horas CalcularHoras'+ diffHTotal + ':' + diffMTotal);
    let total  = ((isNaN(hoursF) - isNaN(hoursI) < 0  ||  isNaN(hoursI)<=0 ) || parseInt(hoursF) - parseInt(hoursI) < 0  ) ? ( parseInt(hoursF) - parseInt(hoursI) ) : ( diffHTotal + ':' + diffMTotal);
    // console.log('To CalcularHoras'+ total);

    return total;
}

jQuery.validator.addMethod("notEqual", function (value, element, param) {
    return this.optional(element) || value != param;
}, "Please specify a different (non-default) value");

$("#frmJornada").validate({
    rules: {
        id_emp: {
            required: true,
        },
        _idaux: {
            required: true,
        },
        id_periodo: {
            required: true
        }
    },
    messages:{
        id_emp:{
            required: 'Seleccione un Empleado'
        },
        id_periodo:{
            required: 'Seleccione un Periodo Valido'
        }
    },
    submitHandler: function (form, event) {
        event.preventDefault();
        let alert = '';

        $(".alert-danger").hide();
        $('<input>', {
            type: 'hidden',
            name: 'items',
            value: JSON.stringify(table.getData())
        }).appendTo('#frmJornada');

        let libres = $("#_horas").val();

        let hourLibres = 0;
        let minuteLibres = 0;

        let fieldCell = libres.split(':');
        let HourCell = isNaN(parseFloat(fieldCell[0])) ? 0 : parseFloat(fieldCell[0]); let MinuteCell = isNaN(parseFloat(fieldCell[1])) ? 0 : parseFloat(fieldCell[1]);
        var horas_Cell = HourCell * 3600; var minutos_Cell = MinuteCell * 60; var segundosC = minutos_Cell + horas_Cell;
        var hoursCe = Math.floor( segundosC / 3600 ); var minutesCe = Math.floor( (segundosC % 3600) / 60 );

        //Anteponiendo un 0 a los minutos y horas si son menos de 10
        minutesCe = minutesCe < 10 ? '0' + minutesCe : minutesCe;
        hoursCe = hoursCe < 10 ? '0' + hoursCe : hoursCe;

        hourLibres += parseInt(hoursCe);
        minuteLibres += parseInt(minutesCe);
        hourLibres =  isNaN(hourLibres) ? 0 : parseInt(hourLibres);
        minuteLibres =  isNaN(minuteLibres) ? 0 : parseInt(minuteLibres);

        let timeT = hourLibres + ':' + minuteLibres;

        let horas = $("#auxJornada").val();
        horas = parseFloat(horas);
        libres = parseFloat(libres);
        console.log(timeT);
        let extra_valid = true;
        if (hourLibres>0 || minuteLibres>0){
            alert = `<div class="alert alert-danger mt-3" role="alert">
                            <div class="alert-message">
                                <strong> <i class="fa fa-info-circle"></i> Información!</strong>  Complete las <strong>${  horas }</strong> horas de la jornada
                            </div>
                        </div>`;
            extra_valid = false;
        }
        $("#days-table").after(alert);

        var valid = table.validate();
        if (valid && extra_valid) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });


            $.ajax({
                type: $('#frmJornada').attr('method'),
                url: $('#frmJornada').attr('action'),
                dataType: "JSON",
                data: new FormData(document.getElementById('#frmJornada'.replace('#', ''))),
                processData: false,
                contentType: false,
                error: function (jqXHR, textStatus) {
                    if (jqXHR.status === 0) {
                        errorServer('#notificacion_jornada', 'No conectar: ​​Verifique la red.');
                    } else if (jqXHR.status == 404) {
                        errorServer('#notificacion_jornada', 'No se encontró la página solicitada [404]');
                    } else if (jqXHR.status == 500) {
                        errorServer('#notificacion_jornada', 'Error interno del servidor [500].');
                    } else if (textStatus === 'parsererror') {
                        errorServer('#notificacion_jornada', 'Error al analizar JSON solicitado.');
                    } else if (textStatus === 'timeout') {
                        errorServer('#notificacion_jornada', 'Error de tiempo de espera.');
                    } else if (textStatus === 'abort') {
                        errorServer('#notificacion_jornada', 'Solicitud de Ajax cancelada.');
                    } else {
                        errorServer('#notificacion_jornada', 'Error no detectado: ' + jqXHR.responseText);
                    }
                    $('.modal').scrollTop($('.modal').height());
                }, beforeSend: function (jqXHR, textStatus) {
                    $('#notificacion_jornada').removeClass().addClass('alert alert-info bg-info text-white border-0').html(''
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
                    // disableform('#frmJornada');
                },
            }).then(function (data) {
                if (data.error != null) {
                    $('#notificacion_jornada').removeClass().addClass('alert alert-danger bg-danger text-white border-0');
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

                    $('#notificacion_jornada').html('<h4 Class = "text-white">Completar Campos:</h4>'
                        + '<div class="row">'
                        + '<div class="col-lg-9 order-firts">'
                        + '<ul>' + $errores + '</ul>'
                        + '</div>'
                        + '<div class="col-lg-3 order-last text-center">'
                        + '<li class="fa fa-exclamation-triangle fa-5x"></li>'
                        + '</div>'
                        + '</div>'
                    ).show();
                    enableform('#frmJornada');

                } else {
                    if (data.mensaje != null && data.error == null) {
                        $('#notificacion_jornada').removeClass().addClass('alert alert-success bg-success text-white ').html(''
                            + '<div class="row">'
                            + '<div class="col-xl-11 order-last">'
                            + ' <h3 class="col-xl text-white">' + data.mensaje + '</h3>'
                            + '</div>'
                            + '<div class="col-xl-1 order-firts">'
                            + '<i class="fa fa-check  fa-3x"></i>'
                            + '</div>'
                            + '</div>'
                        ).show();
                        $('#frmJornada')[0].reset();
                        location.reload();
                    }
                }
                $('.modal').scrollTop(0);
            });

        }else{
            alert = `<div class="alert alert-danger mt-3" role="alert">
                            <div class="alert-message">
                                <strong> <i class="fa fa-info-circle"></i> Información!</strong>  Complete o verifique el contenido de la tabla
                            </div>
                        </div>`;

            $("#days-table").after(alert);
        }
    },
    errorClass: "invalid-feedback",
    validClass: "state-success",
    errorElement: "em",
    highlight: function (element, errorClass, validClass) {
        $(element).closest('.field').addClass(errorClass).removeClass(validClass);
    },
    unhighlight: function (element, errorClass, validClass) {
        $(element).closest('.field').removeClass(errorClass).addClass(validClass);
    },
    errorPlacement: function (error, element) {
        if (element.is(":radio") || element.is(":checkbox")) {
            element.closest('.option-group').after(error);
        } else {
            error.insertAfter(element.parent());
        }
    }
});


$('.select-filter').on('change', function () {
    $("#frmFiltrar").submit();
});

$("#btnNewJornada").click(function () {
    $("#_id").val('');
    $("#modalNewJonarda").modal('show');

    //limpiar el combo select por si se ha editado antes
    $("#id_periodo_text").prop('disabled', true);
    $("#id_periodo").prop('disabled', false);

    $("#id_periodo").val(null).trigger('change');
    $('#id_periodo').selectpicker('refresh');

    //limpiar el combo select por si se ha editado antes
    $("#id_emp_text").prop('disabled', true);
    $("#id_emp").prop('disabled', false);


    $("#id_emp").val(null).trigger('change');
    $('#id_emp').empty();
    $('#id_emp').selectpicker('refresh');
});


//Para obtener la carga academica del docente
/*function fnCargaAcademica(id){
    let datas = getData('GET', `/admin/jornada/detalleCarga/`+id,'#notificacion_jornada');
    datas.then(function(response){
        let contenidox = '';
        $(response).each(function (index, element) {
            contenidox +=`<tr>
                <td>${element.dias}</td>
                <td>${element.nombre_materia}</td>
                <td>${element.inicio}</td>
                <td>${element.fin}</td>
            </tr>`;
        });
        $("#bodyViewH").html(contenidox);
    });
}*/


