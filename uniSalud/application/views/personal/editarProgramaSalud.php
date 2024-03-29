<?php echo form_open('programaSaludControlador/editarProgramaSalud/'); ?>
<h1 style="font-size: 25px;color: black">Editar Programa de Salud</h1><br /><br /><br />
            <h4 style="font-size: 15px;color: grey">Los campos marcados con (*) son obligatorios</h2><br /><br />
<table id="tablaForm">
    <tr>
        <td>
            * Costo: 
        </td>
        <td> <?php
            echo form_hidden('id_programasalud', $programa->id_programasalud);
            $data_form = array(
                'name' => 'costo',
                'id' => 'costo',
                'size' => '40',
                'value' => $programa->costo
            );
            echo form_error('costo', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Tipo de Servicio: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'tipo_servicio',
                'id' => 'tipo_servicio',
                'size' => '40',
                'value' => $programa->tipo_servicio
            );
            echo form_error('tipo_servicio', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Actividad: 
        </td>
        <td> <?php
            $data_form = array(
                'asistencial' => 'Asistencial',
                'prevencion y promocion' => 'Prevencion y Promocion',
                'administrativas' => 'Administrativas'
            );
            echo form_error('actividad', '<b><p style="color:red;">', '</p></b>');
            echo form_dropdown('actividad',$data_form,$programa->actividad);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <input id="btnAgregar" class="boton" type="submit" value="Actualizar"/>
        </td>
        <td>
            <button id ="btnAgregar" class="boton" onclick="location.href = '<?php echo base_url() . "programaSaludControlador/mostrarProgramas"; ?>';
                    return false;"> Cancelar</button>
        </td>        
    </tr>
</table>
<?php echo form_close(); ?>
