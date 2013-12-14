<?php echo form_open('agendaControlador/editarHorarioAtencion/'); ?>
<h1 style="font-size: 25px;color: black">Editar Horario de Atencion</h1><br /><br /><br />
            <h4 style="font-size: 15px;color: grey">Los campos marcados con (*) son obligatorios</h2><br /><br />
<table id="tablaForm">
    <tr>
        <?php echo form_hidden('id_personalsalud', $horario->id_personalsalud) ?>
        <?php echo form_hidden('id_agenda', $horario->id_agenda) ?>
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
            echo form_dropdown('dia', $data,$horario->dia);
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
            echo form_dropdown('hora_i', $hora,$hora_i);
            echo ":";
            echo form_dropdown('min_i', $minseg,$min_i);
            echo ":";
            echo form_dropdown('seg_i', $minseg,$seg_i);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            * Hora Final (HH:mm:ss): 
        </td>
        <td> <?php
            echo form_dropdown('hora_f', $hora,$hora_f);
            echo ":";
            echo form_dropdown('min_f', $minseg,$min_f);
            echo ":";
            echo form_dropdown('seg_f', $minseg,$seg_f);
            ?>
        </td>
    </tr>
    <tr>
        <td>
            <input id="btnAgregar" class="boton" type="submit" value="Actualizar"/>
            <?php echo form_close(); ?>
        </td>
        <td>
        <?php echo form_open('agendaControlador/buscarDatos') ?>
        <?php echo form_hidden('id_personalsalud', $horario->id_personalsalud); ?>
         <input id="btnAgregar" type="submit" value="Cancelar" class="boton"/>
        <?php echo form_close(); ?></td>
    </tr>
</table>

