<?php echo form_open('consultorioControlador/editarConsultorio/'); ?>
<table id="tablaForm">
    <tr>
        <td>
            * Costo: 
        </td>
        <td> <?php
            echo form_hidden('id_consultorio', $consultorio->id_consultorio);
            $data_form = array(
                'name' => 'numero_consultorio',
                'id' => 'numero_consultorio',
                'size' => '40',
                'value' => $consultorio->numero_consultorio
            );
            echo form_error('numero_consultorio', '<b><p style="color:red;">', '</p></b>');
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
                'name' => 'descripcion',
                'id' => 'descripcion',
                'size' => '40',
                'value' => $consultorio->descripcion
            );
            echo form_error('descripcion', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <input id="btnAgregar" class="boton" type="submit" value="Actualizar"/>
        </td>
        <td>
            <button id ="btnAgregar" class="boton" onclick="location.href = '<?php echo base_url() . "consultorioControlador/mostrarConsultorios"; ?>';
                    return false;"> Cancelar</button>
        </td>        
    </tr>
</table>
<?php echo form_close(); ?>
