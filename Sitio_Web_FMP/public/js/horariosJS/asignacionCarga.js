$(document).ready(function() {
    
    $.ajax({
        url: 'ver',
        type: "GET",
        success: function(data){
            document.getElementById("carga").disabled=false;
           data=JSON.parse(data);

            let $select = $('#carga');
            $('#carga').empty();
            $select.append('<option value="">' + "Seleccione "+'</option>');
            for (let index = 0; index < data.length; index++) {
                console.log('cuantos'+ data[index].nombre_carga);
               /* $select.append('<option value=' + data[index].id + '>' + data[index].nombre_carga+
                '</option>');*/

                document.getElementById("carga").innerHTML += "<option value='"+data[index].id+"'>"+data[index].nombre_carga+"</option>";
                
            }
            $("#carga").selectpicker('refresh')
           

        }, 
        error: function(){
            document.getElementById("carga").disabled=true;
            let $select = $('#carga');
            $('#carga').empty();
                $select.append('<option value="" selected>No hay datos</option>');
                
         }

        }); 
  });
$('.select2-multiple').select2();