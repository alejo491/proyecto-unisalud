<?php echo form_open('consultorioControlador/aniadirDatos/'); ?>
<table id="tablaForm">
    <tr>
        <td>
            * Numero Consultorio: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'numero_consultorio',
                'id' => 'numero_consultorio',
                'size' => '40',
                'value' => set_value('numero_consultorio')
            );
            echo form_error('numero_consultorio', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Descripcion: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'descripcion',
                'id' => 'descripcion',
                'size' => '40',
                'value' => set_value('descripcion')
            );
            echo form_error('descripcion', '<b><p style="color:red;">', '</p></b>');
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