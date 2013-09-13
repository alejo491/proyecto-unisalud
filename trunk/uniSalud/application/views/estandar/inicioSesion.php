<div style="float:right">
<form action="<?php echo base_url(); ?>usuario/login/" method="post">
                    
			<table >
			<tr><td align="left" style="color:white">E-mail:</td><td align="left" style="color:white">Contraseña:</td></tr>
                        <tr><td><input class="text" name="email" id='email' size="15" maxlength="64"/></td><td><input type='password' class="text" name="contrasena" id='contrasena' size="15" maxlength="64" /></td><td><input value="Ingresar" type="submit" /></td><td><a href=".<?php base_url()?>/usuario/index" style="color:white">Registrarse</a></td></tr>
			</table>
        </form>
</div>
