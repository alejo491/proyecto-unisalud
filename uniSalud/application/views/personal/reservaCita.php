<?php echo form_open('citaControlador/reservar_Cita/'); ?>
<h1 style="font-size: 25px;color: black">Reservar Cita</h1><br /><br /><br />
            <h4 style="font-size: 15px;color: grey">Los campos marcados con (*) son obligatorios</h2><br /><br />
<table id="tablaForm">
    
            
        
    
    <tr>
        <td>
            <b> Codigo:</b>
        </td>
        <td> 
            <?php echo $estudiante->id_estudiante; echo form_hidden('id_estudiante', $estudiante->id_estudiante);?>
        </td>
        <td>
            <?php echo form_error('id_estudiante', '<b><p style="color:red; padding-left: 10%;">', '</p></b>'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <b> Programa: </b>
        </td>
        <td> 
            <?php echo $estudiante->id_programa; ?>
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
            <strong>Programa de Salud:* </strong> 
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
            <strong>Personal de Salud:* </strong><br />
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
            <strong>Fecha de Consulta:* </strong>
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
            <strong>Hora de Consulta:*</strong> 
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
            <strong>Observaciones:*</strong>
        </td>
        <td>
        <?php
          $data_form = array(
                'name' => 'observacion',
                'id' => 'observacion',
                'type'=>'textarea'
                
                
            );
             
          echo form_input($data_form);
          ?>
        </td>
        <td>
            <?php echo form_error('observacion', '<b><p style="color:red; padding-left: 10%;">', '</p></b>'); ?>
        </td>
    </tr>
    <tr>
        <td>
            <input id="btnAgregar" class="boton" type="submit" value="Reservar"/>
        </td>
        <td>
            <button id ="btnAgregar" class="boton" onclick="location.href = '<?php echo base_url() . "estudianteControlador"; ?>';
                    return false;"> Cancelar</button>
        </td>
    </tr>
</table>
<?php echo form_close(); ?>
