<?php echo form_open('personalSaludControlador/aniadirDatos/'); ?>
<table id="tablaForm">
    <tr>
        <td>
            <b> Codigo:</b>
        </td>
        <td> 
            <?php echo $estudiante->id_estudiante; ?>
        </td>
    </tr>
    <tr>
        <td>
            <b> Programa: </b>
        </td>
        <td> 
            Falta Cargarlo segun el Codigo del Programa.
        </td>
    </tr>
    <tr>
        <td>
            <b>Primer Nombre:</b>
        </td>
        <td> 
            <?php echo $estudiante->primer_nombre; ?>
        </td>
    </tr>
    <tr>
        <td>
            <b> Primer Apellido:</b>
        </td>
        <td> 
            <?php echo $estudiante->primer_apellido; ?>
        </td>
    </tr>
    <tr>
        <td>
            <b> Identificacion: </b>
        </td>
        <td> 
            <?php echo $estudiante->identificacion; ?>
        </td>
    </tr>
    <tr>

        <td>
            <strong>Programa de Salud: </strong> 
        </td>
        <td>
            <select name="programa" id="programa" style="background:whitesmoke;border: 1px solid;width:273px" onchange="carga_personal('<?php echo base_url() ?>citaControlador/obtenerPersonalSalud');">
                <option value="">Selecciona una Opcion</option>
                <?php
                foreach ($programas->result() as $fila) {

                    echo '<option value="' . $fila->id_programasalud . '">' . $fila->tipo_servicio . '</option>';
                }
                ?>  
            </select>
        </td>
        <td>
            <?php echo form_error('programa', '<b><p style="color:red; padding-left: 10%;">', '</p></b>'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <strong>Personal de Salud: </strong><br />
        </td>
        <td>
            <select name="personal" id="personal" style="background:whitesmoke;border: 1px solid;width:273px" onchange="carga_fecha('<?php echo base_url() ?>citaControlador/obtenerFechas');">
            <option value="">Selecciona una opcion</option>

            </select>
        </td>   
        <td>
            <?php echo form_error('personal', '<b><p style="color:red; padding-left: 10%;">', '</p></b>'); ?>
        </td>
    </tr>
    <tr>
        <td>
            Fecha de Consulta: 
        </td>
        <td>
          <select name="fecha" id="fecha" style="background:whitesmoke;border: 1px solid;width:273px" onchange="carga_horas('<?php echo base_url() ?>citaControlador/obtenerHoras');">
                <option value="">Selecciona una Opcion</option> 
          </select>
        </td>
        <td>
            <?php echo form_error('fecha', '<b><p style="color:red; padding-left: 10%;">', '</p></b>'); ?>
        </td>
    </tr>
    <tr>
        <td>
            Hora de Consulta: 
        </td>
        <td>
        <select name="hora" id="hora" style="background:whitesmoke;border: 1px solid;width:273px">
                <option value="">Selecciona una Opcion</option> 
            </select>
        </td>
        <td>
            <?php echo form_error('hora', '<b><p style="color:red; padding-left: 10%;">', '</p></b>'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <input id="btnAgregar" class="boton" type="submit" value="Agregar"/>
        </td>
        <td>
            <button id ="btnAgregar" class="boton" onclick="location.href = '<?php echo base_url() . "personalSaludControlador/mostrarPersonalSalud"; ?>';
                    return false;"> Cancelar</button>
        </td>
    </tr>
</table>
<?php echo form_close(); ?>
