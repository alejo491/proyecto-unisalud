<?php echo form_open('programaSaludControlador/aniadirDatos/'); ?>
<table id="tablaForm">
    <tr>
        <td>
            * Costo: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'costo',
                'id' => 'costo',
                'size' => '40',
                'value' => set_value('costo')
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
                'value' => set_value('tipo_servicio')
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
                'name' => 'actividad',
                'id' => 'actividad',
                'size' => '40',
                'value' => set_value('actividad')
            );
            echo form_error('actividad', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <input id="btnAgregar" class="boton" type="submit" value="Agregar"/>
        </td>
        <td>
            <button id ="btnAgregar" class="boton" onclick="location.href='<?php echo base_url()."programaSaludControlador/mostrarProgramas"; ?>'; return false;"> Cancelar</button>
        </td>
    </tr>
</table>
<?php echo form_close(); ?>
