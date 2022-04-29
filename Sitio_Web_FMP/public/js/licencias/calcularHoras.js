let mensuales, anuales, hrs_m, hrs_a, min_m, min_a, min_t_a, min_t_m;
    mensuales = anuales = hrs_m = hrs_a = min_m = min_a = min_t_a = min_t_m = 0;

    function obtenerHora() {
        if(($('#tipo_permiso').val() =='LC/GS' || $('#tipo_permiso').val() =='CITA MEDICA') && $('#fecha_de_uso').val().trim() != ""){
                var permiso = $('#idPermiso').val().trim()==''?'nuevo':$('#idPermiso').val();
                $.ajax({
                    type: "GET",
                    url: URL_SERVIDOR+'/admin/mislicencias/horas-mensual/'+$('#fecha_de_uso').val()+'/'+permiso,
                    beforeSend: function() {
                        $('#hora_mensual').val('Cargando...');
                        $('#hora_anual').val('Cargando...');
                    },
                    success: function(json) {
                        var json = JSON.parse(json);
                        mensuales = json.mensuales;
                        hrs_m = json.horas_acumuladas;
                        min_m = json.minutos_acumulados;
                    },
                });
                
                $.ajax({
                    type: "GET",
                    url: URL_SERVIDOR+'/admin/mislicencias/horas-anual/'+$('#fecha_de_uso').val()+'/'+permiso,
                    success: function(json) {
                        var json  =  JSON.parse(json);
                        anuales = json.anuales;
                        hrs_a = json.horas_acumuladas;
                        min_a = json.minutos_acumulados;
                    },
                    complete: function(json) {  
                        min_t_m = (parseInt(mensuales)*60)-(parseInt(min_m) + parseInt(hrs_m)*60);
                        min_t_a = (parseInt(anuales)*60)-(parseInt(min_a) + parseInt(hrs_a)*60);

                        var horas = parseInt(Math.trunc(min_t_a/ 60));
                        var minutos = parseInt((min_t_a % 60));
                        
                        $('#hora_anual').val(horas+' hrs, '+minutos+' min');

                        var horas = parseInt(Math.trunc(min_t_m/ 60));
                        var minutos = parseInt((min_t_m % 60));

                        $('#hora_mensual').val(horas+' hrs, '+minutos+' min');               

                        if($('#hora_inicio').val().trim() != "" && $('#hora_final').val().trim() != ""){
                            $('#hora_inicio').click();
                            $('#hora_final').click();
                        }
                    }
                });
        }else{
            $('#hora_anual').val('Ilimitado');
            $('#hora_mensual').val('Ilimitado');
            mensuales = anuales = hrs_m = hrs_a = min_m = min_a = min_t_a = min_t_m = 0;
        }
    }

    function calcularHora() {
        var hora_inicio = $('#hora_inicio').val();
        var hora_final = $('#hora_final').val();
        
        // Expresión regular para comprobar formato
        var formatohora = /^([01]?[0-9]|2[0-3]):[0-5][0-9]$/;
        
        // Si algún valor no tiene formato correcto sale
        if (!(hora_inicio.match(formatohora)
                && hora_final.match(formatohora))){
            return;
        }
        // Calcula los minutos de cada hora
        var minutos_inicio = hora_inicio.split(':')
            .reduce((p, c) => parseInt(p) * 60 + parseInt(c));
        var minutos_final = hora_final.split(':')
            .reduce((p, c) => parseInt(p) * 60 + parseInt(c));
        // Si la hora final es anterior a la hora inicial sale
        if (minutos_final < minutos_inicio) return;
        
        // Diferencia de minutos
        var diferencia = minutos_final - minutos_inicio;

        // Cálculo de horas y minutos de la diferencia
        var horas = parseInt(Math.trunc(diferencia / 60));
        var minutos = parseInt((diferencia % 60));        

        $('#hora_actuales').val(horas+' hrs, '+minutos+' min');
        if(($('#tipo_permiso').val() =='LC/GS' || $('#tipo_permiso').val() =='CITA MEDICA') && $('#fecha_de_uso').val().trim() != ""){
            var horas = parseInt(Math.trunc((min_t_a-diferencia)/ 60));
            var minutos = parseInt(((min_t_a-diferencia) % 60));
            
            $('#hora_anual').val(horas+' hrs, '+minutos+' min');

            var horas = parseInt(Math.trunc((min_t_m-diferencia)/ 60));
            var minutos = parseInt(((min_t_m-diferencia) % 60));

            $('#hora_mensual').val(horas+' hrs, '+minutos+' min');
        }else{
            $('#hora_anual').val('Ilimitado');
            $('#hora_mensual').val('Ilimitado');
        }
    }