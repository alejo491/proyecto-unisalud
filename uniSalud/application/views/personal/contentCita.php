<section id="content">
    <div id="paginacion" align="center">
        <?php if(isset($paginacion))echo $paginacion?>
    </div>
    <table id="tabla">
        <thead align="center">
            <tr>
                <th scope="col"><b>Info Estudiante</b></th>
                <th scope="col"><b>Info Personal de Salud</b></th>
                <th scope="col"><b>Info Programa de Salud</b></th>
                <th scope="col"><b>Dia y Hora</b></th>
                <th scope="col"><b>Estado</b></th>
                <th scope="col" colspan="2"><b>Accion</b></th>
            </tr>
        </thead>
        <?php if (isset($citas) && $citas != null): ?>
            <tbody>
                <?php foreach ($citas->result() as $cita): ?>
                    <tr>
                        <td>
                            <?php echo $cita->pnestudiante; ?></br>
                            <?php echo $cita->paestudiante; ?></br>
                            <?php echo $cita->idestudiante; ?></br>
                        </td>
                        <td>
                            <?php echo $cita->pnpersonal; ?></br>
                            <?php echo $cita->papersonal; ?></br>
                            <?php echo $cita->idpersonal; ?></br>
                        </td>
                        <td>
                            <?php echo $cita->tipo_servicio; ?></br>
                            <?php echo $cita->actividad; ?></br>
                        </td>
                        <td>
                            <?php echo $cita->dia; ?></br>
                            <?php echo $cita->hora_inicio; ?> - 
                            <?php echo $cita->hora_fin; ?></br>
                        </td>
                        <td>
                            <?php if($cita->estado == 2):
                                    echo "No Activa";
                            else:
                                echo "Activada";
                            endif;
                                ?>
                        </td>
                        <td>
                            <input id="btnTabla" type="submit" value="Cancelar" onclick="cancelar('<?php echo base_url()?>citaControlador/cancelarCita','<?php echo $cita->id_estudiante.':'.$cita->id_personalsalud.':'.$cita->id_programasalud?>');" class="boton"/>
                       
                        </td>
                        <td>
                            <input id="btnTabla" type="submit" value="Activar" onclick="activar('<?php echo base_url()?>citaControlador/activarCita','<?php echo $cita->id_estudiante.':'.$cita->id_personalsalud.':'.$cita->id_programasalud?>');" class="boton"/>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot><!--
                <?php echo form_open('consultorioControlador/filtrarConsultorio') ?>
                <tr>
                    <td>
                        <?php
                        $data_form = array(
                            'name' => 'numero_consultorio',
                            'id' => 'numero_consultorio',
                            'size' => '20',
                            'value' => ''
                        );
                        echo form_input($data_form);
                        ?>
                    </td>
                    <td>
                        <?php
                        $data_form = array(
                            'name' => 'descripcion',
                            'id' => 'descripcion',
                            'size' => '20',
                            'value' => ''
                        );
                        echo form_input($data_form);
                        ?>
                    </td>
                    <td colspan="3">
                            <input id="btnTabla" type="submit" value="Buscar" class="boton"/>
                            <?php echo form_close(); ?>
                    </td>
                </tr>-->
            </tfoot>
        <?php else: ?>
            <tfoot>
                <tr>
                    <td colspan="4">No hay Citas </td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>
    <div id="paginacion" align="center">
        <?php if(isset($paginacion))echo $paginacion?>
    </div>
</section>