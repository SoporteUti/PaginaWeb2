function editar(id,boton){
    $.ajax({
        type: "GET",
        url: '/Administrativa/Carga/'+id,
        beforeSend: function() {
            $(boton).prop('disabled', true).html(''
                +'<div class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></div>'
            );
        },
        success: function(json) {
            json=JSON.parse(json);
            //console.log(json);
            $("#_id").val(json.id);
            $("#nombre_carga").val(json.nombre_carga); 
            $('#jefe').val(json.id_jefe).trigger('change');
            $("#carga").modal();
        },
        complete: function() {
            $(boton).prop('disabled', false).html(''
                +'<i class="fa fa-edit font-16" aria-hidden="true"></i>'
            );
        }
    });
} 




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
