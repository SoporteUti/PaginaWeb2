function editar(json){$("#_id").val(json.id);$("#nombre").val(json.nombre);
$("#titulo").val(json.titulo);$("#modalidad").val(json.modalidad);$("#duracion").val(json.duracion);
$("#asignaturas").val(json.numero_asignatura);$("#unidades").val(json.unidades_valorativas);
$("#precio").val(json.precio);$("#dirigido").val(json.dirigido);};
function eliminarPlan (id)
{$('#complementario').val(id);
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