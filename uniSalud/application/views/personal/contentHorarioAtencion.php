<section id="content">
    <div><br/>
        <h4 style="color: #000;"><b>Informacion Personal:</b></h4>
        <h4 style="color: #000;"><b>Nombre:  </b><?php echo $personal->primer_nombre . " " . $personal->primer_apellido; ?></h4>
        <h4 style="color: #000;"><b>Numero de Identificacion:  </b><?php echo $personal->identificacion; ?></h4>
        <h4 style="color: #000;"><b>Numero Tarjeta Profecional:  </b><?php echo $personal->numero_tarjeta; ?></h4>
    </div>
    <div>
        <?php echo form_open('agendaControlador/agregarHorarioAtencion') ?>
        <?php echo form_hidden('id_personalsalud', $personal->id_personalsalud); ?>
        <input id="btnTabla" type="submit" value="Añadir Horario de Atencion" class="boton"/>
        <?php echo form_close(); ?>
    </div>
    <div id="paginacion" align="center">
        <?php if (isset($paginacion)) echo $paginacion ?>
    </div>
    <table id="tabla">
        <thead align="center">
            <tr>
                <th scope="col"><b>Dia</b></th>
                <th scope="col"><b>Hora Inicial</b></th>
                <th scope="col"><b>Hora Final</b></th>
                <th scope="col" colspan="2"><b>Accion</b></th>
            </tr>
        </thead>
        <?php if (isset($agenda) && $agenda != null): ?>
            <tbody>
                <?php foreach ($agenda->result() as $horario): ?>
                    <tr>
                        <td>
                            <?php echo $horario->dia; ?>
                        </td>
                        <td>
                            <?php echo $horario->hora_inicial; ?>
                        </td>
                        <td>
                            <?php echo $horario->hora_final; ?>
                        </td>
                        <td>
                            <?php echo form_open('agendaControlador/buscarHorarioPersonal') ?>
                            <?php echo form_hidden('id_personalsalud', $horario->id_personalsalud); ?>
                            <?php echo form_hidden('id_agenda', $horario->id_agenda); ?>
                            <input id="btnTabla" type="submit" value="Editar" class="boton"/>
                            <?php echo form_close(); ?>
                        </td>
                        <td>
                            <?php //echo form_open('agendaControlador/eliminarHorarioAtencion') ?>
                            <?php //echo form_hidden('id_personalsalud', $horario->id_personalsalud); ?>
                            <?php //echo form_hidden('id_agenda', $horario->id_agenda); ?>
                            <input id="btnTabla" type="submit" value="Eliminar" onclick="eliminar('<?php echo base_url()?>agendaControlador/eliminarHorarioAtencion','<?php echo $horario->id_agenda?>');" class="boton"/>
                            <?php //echo form_close(); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        <?php else: ?>
            <tfoot>
                <tr>
                    <td colspan="4">Ningun Programa Registrado</td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>
    <div id="paginacion" align="center">
        <?php if (isset($paginacion)) echo $paginacion ?>
    </div>
</section>