<?php echo form_open('personalSaludControlador/aniadirDatos/'); ?>
<h1 style="font-size: 25px;color: black">Registrar Personal de Salud</h1><br /><br /><br />
            <h4 style="font-size: 15px;color: grey">Los campos marcados con (*) son obligatorios</h2><br /><br />
<table id="tablaForm">
    <tr>
        <td>
            * Primer Nombre: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'primer_nombre',
                'id' => 'primer_nombre',
                'size' => '40',
                'value' => set_value('primer_nombre')
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
                'value' => set_value('segundo_nombre')
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
                'value' => set_value('primer_apellido')
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
                'value' => set_value('segundo_apellido')
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
                'cedula de ciudadania' => 'cedula de ciudadania',
                'cedula extranjera' => 'cedula extranjera',
                'tarjeta de identidad' => 'tarjeta de identidad',
                'registro civil' => 'registro civil'
            );
            echo form_error('tipo_identificacion', '<b><p style="color:red;">', '</p></b>');
            echo form_dropdown('tipo_identificacion',$data_form,  set_value('tipo_identificacion'));
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
                'value' => set_value('identificacion')
            );
            echo form_error('identificacion', '<b><p style="color:red;">', '</p></b>');
            echo form_input($data_form);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Numero de Tarjeta Profesional: 
        </td>
        <td> <?php
            $data_form = array(
                'name' => 'numero_tarjeta',
                'id' => 'numero_tarjeta',
                'size' => '40',
                'value' => set_value('numero_tarjeta')
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
                'value' => set_value('especialidad')
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
        <td> 
            <?php 
            foreach ($consultorios->result_array() as $consultorio):
                $data[$consultorio['id_consultorio']]=($consultorio['numero_consultorio']);
            endforeach;
            echo form_dropdown('consultorio', $data);?>
        </td>
    </tr>
    <tr>
        
        <td>
            * Programa de Salud: 
        </td>
        <td> <strong>Escoja uno o varios programas de salud</strong><br />
            <?php 
             echo form_error('programa_salud', '<b><p style="color:red;">', '</p></b>');
            $i=0;
            foreach ($programas->result() as $programa):
                echo '<input type="checkbox" name="opcion['.$i.']" value="'.$programa->id_programasalud.'">'.$programa->tipo_servicio.'<br>';
                $i=$i+1;
            endforeach;
        ?></td>
    </tr>
    <tr>
        <td>
            <input id="btnAgregar" class="boton" type="submit" value="Registrar"/>
        </td>
        <td>
            <button id ="btnAgregar" class="boton" onclick="location.href='<?php echo base_url()."personalSaludControlador/mostrarPersonalSalud"; ?>'; return false;"> Cancelar</button>
        </td>
    </tr>
</table>
<?php echo form_close(); ?>
