function saludo()
{
    alert("hola");
}
function carga_programa(ruta,div) 
        {
        //alert(ruta );
            var id = $('select#facultad').val(); 
           $.post(ruta,{id:id},function(resp)
           {
                $('#programas').html(resp);
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