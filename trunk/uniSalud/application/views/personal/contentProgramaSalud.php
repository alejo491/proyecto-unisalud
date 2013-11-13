<section id="content">
    <div>
        <button id ="btnAgregar" class="boton" onclick="location.href='<?php echo base_url()."/programaSaludControlador/agregarProgramaSalud"; ?>'; return false;"> Añadir Programa de Salud</button>
    </div>
    <div id="paginacion" align="center">
        <?php if(isset($paginacion))echo $paginacion?>
    </div>
    <table id="tabla">
        <thead align="center">
            <tr>
                <th scope="col"><b>Tipo de Servicio</b></th>
                <th scope="col"><b>Actividad</b></th>
                <th scope="col"><b>Costo</b></th>
                <th scope="col" colspan="2"><b>Accion</b></th>
            </tr>
        </thead>
        <?php if (isset($programas) && $programas != null): ?>
            <tbody>
                <?php foreach ($programas->result() as $programa): ?>
                    <tr>
                        <td>
                            <?php echo $programa->tipo_servicio; ?>
                        </td>
                        <td>
                            <?php echo $programa->actividad; ?>
                        </td>
                        <td>
                            <?php echo $programa->costo; ?>
                        </td>
                        <td>
                            <?php echo form_open('programaSaludControlador/actualizarProgramaSalud') ?>
                            <?php echo form_hidden('id_programasalud', $programa->id_programasalud); ?>
                            <input id="btnTabla" type="submit" value="Editar" class="boton"/>
                            <?php echo form_close(); ?>
                        </td>
                        <td>
                            <?php echo form_open('programaSaludControlador/eliminarProgramaSalud') ?>
                            <?php echo form_hidden('id_programasalud', $programa->id_programasalud); ?>
                            <input id="btnTabla" type="submit" value="Eliminar" class="boton"/>
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