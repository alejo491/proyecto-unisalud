<?php echo form_open('agendaControlador/aniadirDatos/'); ?>
<h1 style="font-size: 25px;color: black">Agregar Horario de Atencion</h1><br /><br /><br />
            <h4 style="font-size: 15px;color: grey">Los campos marcados con (*) son obligatorios</h2><br /><br />
<table id="tablaForm">
    <tr>
        <?php echo form_hidden('id_personalsalud', $id_personalsalud) ?>
        <td>
            * Dia: 
        </td>
        <td> <?php
            $data['lunes'] = 'lunes';
            $data['martes'] = 'martes';
            $data['miercoles'] = 'miercoles';
            $data['jueves'] = 'jueves';
            $data['viernes'] = 'viernes';
            $data['sabado'] = 'sabado';
            echo form_error('dia', '<b><p style="color:red;">', '</p></b>');
            echo form_dropdown('dia', $data);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Hora Inicial (HH:mm): 
        </td>
        <td> <?php
            for ($i = 0; $i < 24; $i++):
                $hora[$i] = $i;
            endfor;
            for ($i = 0; $i < 60; $i++):
                $minseg[$i] = $i;
            endfor;
            echo form_dropdown('hora_i', $hora);
            echo ":";
            echo form_dropdown('min_i', $minseg);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Hora Final (HH:mm): 
        </td>
        <td> <?php
            echo form_dropdown('hora_f', $hora);
            echo ":";
            echo form_dropdown('min_f', $minseg);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <input id="btnAgregar" class="boton" type="submit" value="Agregar"/>
            <?php echo form_close(); ?>
        </td>
        <td>
        <?php echo form_open('agendaControlador/buscarDatos') ?>
        <?php echo form_hidden('id_personalsalud', $id_personalsalud); ?>
         <input id="btnAgregar" type="submit" value="Cancelar" class="boton"/>
        <?php echo form_close(); ?></td>
    </tr>
</table>

