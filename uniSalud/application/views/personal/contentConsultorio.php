<section id="content">
    <div>
        <button id ="btnAgregar" class="boton" onclick="location.href='<?php echo base_url()."consultorioControlador/agregarConsultorio"; ?>'; return false;"> Añadir Consultorio</button>
    </div>
    <div id="paginacion" align="center">
        <?php if(isset($paginacion))echo $paginacion?>
    </div>
    <table id="tabla">
        <thead align="center">
            <tr>
                <th scope="col"><b>Numero de Consultorio </b></th>
                <th scope="col"><b>Descripcion</b></th>
                <th scope="col" colspan="3"><b>Accion</b></th>
            </tr>
        </thead>
        <?php if (isset($consultorios) && $consultorios != null): ?>
            <tbody>
                <?php foreach ($consultorios->result() as $consultorio): ?>
                    <tr>
                        <td>
                            <?php echo $consultorio->numero_consultorio; ?>
                        </td>
                        <td>
                            <?php echo $consultorio->descripcion; ?>
                        </td>
                        <td>
                            <?php echo form_open('consultorioControlador/buscarConsultorio') ?>
                            <?php echo form_hidden('id_consultorio', $consultorio->id_consultorio); ?>
                            <input id="btnTabla" type="submit" value="Editar" class="boton"/>
                            <?php echo form_close(); ?>
                        </td>
                        <td>
                            <?php //echo form_open('personalSaludControlador/eliminarPersonalSalud') ?>
                            <?php //echo form_hidden('id_personalsalud', $persona->id_personalsalud); ?>
                            <input id="btnTabla" type="submit" value="Eliminar" onclick="eliminar('<?php echo base_url()?>consultorioControlador/eliminarConsultorio','<?php echo $consultorio->id_consultorio?>');" class="boton"/>
                            <?php //echo form_close(); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
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
        <?php if(isset($paginacion))echo $paginacion?>
    </div>
</section>