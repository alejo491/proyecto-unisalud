function saludo()
{
    alert("hola");
}
/*
 function carga_ajax(ruta,valor1,valor2,div) 
        {
          // alert(ruta );
           $.post(ruta,{primero:valor1,segundo:valor2},function(resp)
           {
                $("#"+div+"").html(resp);
           });
        }
  */      /*
         function carga_ajax(ruta,id,div) 
        {
          // alert(ruta );
           $.post(ruta,{id:id,},function(resp)
           {
                $("#"+div+"").html(resp);
           });
        }*/

function carga_programa(ruta,div) 
        {
        //alert(ruta );
            var id = $('select#facultad').val(); 
           $.post(ruta,{id:id},function(resp)
           {
                $('#programas').html(resp);
           });
        }