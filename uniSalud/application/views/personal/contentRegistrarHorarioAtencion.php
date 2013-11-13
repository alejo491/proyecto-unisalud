<?php echo form_open('agendaControlador/aniadirDatos/'); ?>
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
            * Hora Inicial (HH:mm:ss): 
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
            echo ":";
            echo form_dropdown('seg_i', $minseg);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Hora Final (HH:mm:ss): 
        </td>
        <td> <?php
            echo form_dropdown('hora_f', $hora);
            echo ":";
            echo form_dropdown('min_f', $minseg);
            echo ":";
            echo form_dropdown('seg_f', $minseg);
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

