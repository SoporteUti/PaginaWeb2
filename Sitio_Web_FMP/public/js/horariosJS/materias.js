function editar(json){

    $("#_id").val(json.id);
    $("#codigo_materia").val(json.codigo_materia);
    $("#nombre_materia").val(json.nombre_materia);
    $("#id_carrera").val(json.id_carrera);
    $("#uv_materia").val(json.uv_materia);
    $("#nivel").val(json.nivel);
    
    };
    
    function eliminarMateria(id)
    {
        //alert(id);
        $('#B_materia').val(id);
    };
    
    function ActivarCarrer(id)
    {
        //alert(id);
        $('#M_Activar').val(id);
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