<div style="float:left; display: inline; width: 100%; margin-top: 2%; margin-left: 2%;">
    <?php echo form_open('usuariosControlador/login');?>

        <table cellpadding="20%" cellspacing="20%" style="width: 100%;">
            <tbody align="left">
            <tr>
                <td><h4>E-mail:</h4></td>
                <td><input class="text" name="email" id='email' size="15" maxlength="64" style="height: 100%; width: 80%"/></td>
                
                <td><h4>Contraseña: </h4></td>
                <td><input type='password' class="text" name="contrasena" id='contrasena' size="15" maxlength="64" style="height: 100%; width: 80%" /></td>
                
                <td align="left">
                    <input value="Ingresar" type="submit" style=" cursor: pointer; width: 90%; color: #673f85;height: 100%;border-radius: 15% 15% 15% 15%;box-shadow:3px 3px 5px #402f55;"/></td>
                <td style=" text-align: right;"><a  style="color:white" href="http://localhost/uniSalud/estandarControlador/registrarse"><h4>Registrarse</h4></a></td>
                <td style=" text-align: right; padding-right: 5%;"><a  style="color:white" href=""><h4>Recuperar Contraseña</h4></a></td>
                
            </tr>
            <tbody>
        </table>
    <?php echo form_close();?>
    </form>
</div>
