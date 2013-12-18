<section id="content">
    <div>
        <button id ="btnAgregar" class="boton" onclick="location.href = '<?php echo base_url() . "estandarControlador/registrarse"; ?>';
                return false;"> Añadir Estudiante</button>
    </div>
    <div id="paginacion" align="center">
<?php if (isset($paginacion)) echo $paginacion ?>
    </div>
    <table id="tabla">
        <thead align="center">
            <tr>
                <th scope="col"><b>Codigo</b></th>
                <th scope="col"><b>Primer Nombre</b></th>
                <th scope="col"><b>Primer Apellido</b></th>
                <th scope="col"><b>Identificacion</b></th>
                <th scope="col" colspan="3"><b>Accion</b></th>
            </tr>
        </thead>
            <?php if (isset($estudiantes) && $estudiantes != null): ?>
            <tbody>
    <?php foreach ($estudiantes->result() as $estudiante): ?>
                    <tr>
                        <td>
        <?php echo $estudiante->id_estudiante; ?>
                        </td>
                        <td>
        <?php echo $estudiante->primer_nombre; ?>
                        </td>
                        <td>
        <?php echo $estudiante->primer_apellido; ?>
                        </td>
                        <td>
        <?php echo $estudiante->identificacion; ?>
                        </td>
                        <!--<td>
                            <?php echo form_open(' ') ?>
                            <?php echo form_hidden('id_estudiante', $estudiante->id_estudiante); ?>
                            <input id="btnTabla" type="submit" value="Editar" class="boton"/>
        <?php echo form_close(); ?>
                        </td>
                        <td>
                            <?php //echo form_open('programaSaludControlador/eliminarProgramaSalud') ?>
                            <?php //echo form_hidden('id_programasalud', $programa->id_programasalud); ?>
                            <input id="btnTabla" type="submit" value="Eliminar" onclick="eliminar('<?php echo base_url()?>programaSaludControlador/eliminarProgramaSalud','<?php echo $estudiante->id_estudiante?>');" class="boton"/>
        <?php //echo form_close(); ?>
                        </td>-->
                        <td>
                            <?php echo form_open('citaControlador/buscarEstudiante') ?>
                            <?php echo form_hidden('id_estudiante', $estudiante->id_estudiante); ?>
                            <input id="btnTabla" type="submit" value="Cita Medica" class="boton"/>
        <?php echo form_close(); ?>
                        </td>
                    </tr>
    <?php endforeach; ?>
            </tbody>
            <tfoot>
                <?php echo form_open('estudianteControlador/buscarEstudiante') ?>
                <tr>
                    <td>
                        <?php
                        $data_form = array(
                            'name' => 'id_estudiante',
                            'id' => 'id_estudiante',
                            'size' => '20',
                            'value' => ''
                        );
                        echo form_input($data_form);
                        ?>
                    </td>
                    <td>
                        <?php
                        $data_form = array(
                            'name' => 'primer_nombre',
                            'id' => 'primer_nombre',
                            'size' => '20',
                            'value' => ''
                        );
                        echo form_input($data_form);
                        ?>
                    </td>
                    <td>
                        <?php
                        $data_form = array(
                            'name' => 'primer_apellido',
                            'id' => 'primer_apellido',
                            'size' => '20',
                            'value' => ''
                        );
                        echo form_input($data_form);
                        ?>
                    </td>
                    <td>
                        <?php
                        $data_form = array(
                            'name' => 'identificacion',
                            'id' => 'identificacion',
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
                </tr>
            </tfoot>
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