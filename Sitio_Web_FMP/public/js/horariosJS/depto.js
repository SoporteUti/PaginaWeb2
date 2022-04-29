function editar(json){
$("#_id").val(json.id);
$("#nombre_departamento").val(json.nombre_departamento);
};

function eliminarDepto(id)
{
	//alert(id);
	$('#E_depto').val(id);
};

function ActivarDepto(id)
{
	//alert(id);
	$('#E_Activar').val(id);
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