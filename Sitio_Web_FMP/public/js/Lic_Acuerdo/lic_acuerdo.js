$(
    function () {
        $('.select2').select2();  
        
        
        $(".js-example-placeholder-multiple").select2({
            placeholder: "Seleccione un empleado"
        });

        $(".summernote-config").summernote({
            lang: 'es-ES',
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['view', ['fullscreen']],           
            ]
        });
    });

    

   
$('.modal').on('hidden.bs.modal',function(){
    $(".alert").hide();
    $("form").trigger("reset");
   

    //$(".select2").val(null).trigger("change");
    //$(".select2").select2();
   
});


