function exitoEliminar()
{
    alert("hola");
}
function carga_programa(ruta,div) 
        {
        //alert(ruta );
            var id = $('select#facultad').val(); 
           $.post(ruta,{id:id},function(resp)
           {
                $('#programa').html(resp);
           });
        }
function carga_personal(ruta) 
        {
        //alert(ruta );
            var id = $('select#programa').val(); 
           $.post(ruta,{id:id},function(resp)
           {
                $('#personal').html(resp);
           });
        }
function carga_fecha(ruta) 
        {
        //alert(ruta );
            var id = $('select#personal').val(); 
           $.post(ruta,{id:id},function(resp)
           {
                $('#fecha').html(resp);
           });
        }
function carga_horas(ruta) 
        {
        //alert(ruta );
            var id = $('select#fecha').val(); 
           $.post(ruta,{id:id},function(resp)
           {
                $('#hora').html(resp);
           });
        }
function cancelar(ruta) 
        {
            if(confirm('Confirma que desea cancelar el registro de un nuevo usuario')){
                
                window.location.href = ruta;
            }else{
                
                alert("cancelado");
            }
       
        }
function eliminar(ruta,id) 
        {
            if(confirm('Confirma que desea Eliminar este campo,\nSi esta información es necesaria en otro servicio del sistema, no se eliminara')){
                window.location.href = ruta+"/"+id;
            }       
        }