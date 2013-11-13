<?php echo form_open('personalSaludControlador/editarPersonalSalud/'); ?>
<table id="tablaForm">
    <tr>
        <?php echo form_hidden('id_personalsalud',$personal->id_personalsalud)?>
        <td>
            * Primer Nombre: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'primer_nombre',
                'id' => 'primer_nombre',
                'size' => '40',
                'value' => $personal->primer_nombre
            );
            echo form_error('primer_nombre', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            Segundo Nombre: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'segundo_nombre',
                'id' => 'segundo_nombre',
                'size' => '40',
                'value' => $personal->segundo_nombre
            );
            echo form_error('segundo_nombre', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Primer Apellido: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'primer_apellido',
                'id' => 'primer_apellido',
                'size' => '40',
                'value' => $personal->primer_apellido
            );
            echo form_error('primer_apellido', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            Segundo Apellido: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'segundo_apellido',
                'id' => 'segundo_apellido',
                'size' => '40',
                'value' => $personal->segundo_apellido
            );
            echo form_error('segundo_apellido', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Tipo de Identificacion: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'tipo_identificacion',
                'id' => 'tipo_identificacion',
                'size' => '40',
                'value' => $personal->tipo_identificacion
            );
            echo form_error('tipo_identificacion', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Numero de Identificacion: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'identificacion',
                'id' => 'identificacion',
                'size' => '40',
                'value' => $personal->identificacion
            );
            echo form_error('identificacion', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Numero de Tarjeta Profecional: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'numero_tarjeta',
                'id' => 'numero_tarjeta',
                'size' => '40',
                'value' => $personal->numero_tarjeta
            );
            echo form_error('numero_tarjeta', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Especialidad: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'especialidad',
                'id' => 'especialidad',
                'size' => '40',
                'value' => $personal->especialidad
            );
            echo form_error('especialidad', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        
        <td>
            * Consultorio: 
        </td>
        <td> <?php echo form_dropdown('consultorio', $consultorios);?></td>
    </tr>
    <tr>
        <td>
            <input id="btnAgregar" class="boton" type="submit" value="Actualizar"/>
        </td>
        <td>
            <button id ="btnAgregar" class="boton" onclick="location.href='<?php echo base_url()."/personalSaludControlador/mostrarPersonalSalud"; ?>'; return false;"> Cancelar</button>
        </td>
    </tr>
</table>
<?php echo form_close(); ?>
