<section id="content">
    <div>
        <button id ="btnAgregar" class="boton" onclick="location.href='<?php echo base_url()."/personalSaludControlador/agregarPersonalSalud"; ?>'; return false;"> Añadir Personal de Salud</button>
    </div>
    <div id="paginacion" align="center">
        <?php if(isset($paginacion))echo $paginacion?>
    </div>
    <table id="tabla">
        <thead align="center">
            <tr>
                <th scope="col"><b>Nombre </b></th>
                <th scope="col"><b>Apellido</b></th>
                <th scope="col"><b>identificacion</b></th>
                <th scope="col"><b>especialidad</b></th>
                <th scope="col" colspan="3"><b>Accion</b></th>
            </tr>
        </thead>
        <?php if (isset($personal) && $personal != null): ?>
            <tbody>
                <?php foreach ($personal->result() as $persona): ?>
                    <tr>
                        <td>
                            <?php echo $persona->primer_nombre; ?>
                        </td>
                        <td>
                            <?php echo $persona->primer_apellido; ?>
                        </td>
                        <td>
                            <?php echo $persona->identificacion; ?>
                        </td>
                        <td>
                            <?php echo $persona->especialidad; ?>
                        </td>
                        <td>
                            <?php echo form_open('personalSaludControlador/actualizarPersonalSalud') ?>
                            <?php echo form_hidden('id_personalsalud', $persona->id_personalsalud); ?>
                            <input id="btnTabla" type="submit" value="Editar" class="boton"/>
                            <?php echo form_close(); ?>
                        </td>
                        <td>
                            <?php echo form_open('personalSaludControlador/eliminarPersonalSalud') ?>
                            <?php echo form_hidden('id_personalsalud', $persona->id_personalsalud); ?>
                            <input id="btnTabla" type="submit" value="Eliminar" class="boton"/>
                            <?php echo form_close(); ?>
                        </td>
                        <td>
                            <?php echo form_open('agendaControlador/buscarDatos') ?>
                            <?php echo form_hidden('id_personalsalud', $persona->id_personalsalud); ?>
                            <input id="btnTabla" type="submit" value="Agenda" class="boton"/>
                            <?php echo form_close(); ?>
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
        <?php if(isset($paginacion))echo $paginacion?>
    </div>
</section>