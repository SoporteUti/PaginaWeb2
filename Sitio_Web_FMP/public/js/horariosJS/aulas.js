function editar(json){

    $("#_id").val(json.id);
    $("#codigo_aula").val(json.codigo_aula);
    $("#nombre_aula").val(json.nombre_aula);
    $("#ubicacion_aula").val(json.ubicacion_aula);
    $("#capacidad_aula").val(json.capacidad_aula);    
    };
    
    function eliminarAula(id)
    {
        //alert(id);
        $('#E_Aula').val(id);
    };
    
    function ActivarAula(id)
    {
        //alert(id);
        $('#A_Activar').val(id);
    };
    (function(window){
        window.htmlentities = {
            /**
             * Convierte una cadena a sus caracteres html por completo.
             *
             * @param {String} str String with unescaped HTML characters
             **/
            encode : function(str) {
                var buf = [];
                
                for (var i=str.length-1;i>=0;i--) {
                    buf.unshift(['&#', str[i].charCodeAt(), ';'].join(''));
                }
                
                return buf.join('');
            },
            /**
             * Convierte un conjunto de caracteres html en su carácter original.
             *
             * @param {String} str htmlSet entities
             **/
            decode : function(str) {
                return str.replace(/&#(\d+);/g, function(match, dec) {
                    return String.fromCharCode(dec);
                });
            }
        };
    })(window);