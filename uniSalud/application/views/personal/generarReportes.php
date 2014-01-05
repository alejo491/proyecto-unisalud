<h1 style="font-size: 25px;color: black">Reportes</h1><br /><br /><br />
<section id="content">
    <div>
        <?php echo form_open('citaControlador/reporteEstudiantesPrograma/'); ?>

        <h2>Numero de estudiantes que usan un servicio, clasificados por programa</h2><br /><br />
        
        
        <table>
            <tr>

                <td>
                    <h4 style="font-size: 15px;color: grey">Escoga un programa de salud:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4>
                </td>
                <td>
                    <select name="programa" id="programa" style="background:whitesmoke;border: 1px solid;width:273px" >
                        <option value="">Selecciona una Opcion</option>
                        <?php
                        foreach ($programas->result() as $fila) {

                            echo '<option value="' . $fila->tipo_servicio . '">' . $fila->tipo_servicio . '</option>';
                        }
                        ?>  
                    </select><br /><br />
                </td>
                <td>
                    <?php echo form_error('programa', '<b><p style="color:red; padding-left: 10%;">', '</p></b>'); ?>
                </td>
            </tr>
            <tr>
              <td>
                     <input id="btnGenerar" class="boton" type="submit" value="Generar Reporte"/>
                </td> 
            </tr>
            
            
        </table>
        <?php echo form_close(); ?>
    </div>
    
    <div>
        <?php echo form_open('citaControlador/reporteEstudiantesFacultad/'); ?>

        <h2>Numero de estudiantes que usan un servicio, clasificados por facultad</h2><br /><br />
        
        
        <table>
            <tr>

                <td>
                    <h4 style="font-size: 15px;color: grey">Escoga un programa de salud:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4><br /><br />
                </td>
                <td>
                    <select name="programa1" id="programa1" style="background:whitesmoke;border: 1px solid;width:273px" >
                        <option value="">Selecciona una Opcion</option>
                        <?php
                        foreach ($programas->result() as $fila) {

                            echo '<option value="' . $fila->tipo_servicio . '">' . $fila->tipo_servicio . '</option>';
                        }
                        ?>  
                    </select><br /><br />
                </td>
                <td>
                    <?php echo form_error('programa1', '<b><p style="color:red; padding-left: 10%;">', '</p></b>'); ?>
                </td>
            </tr>
            <tr>
              <td>
                     <input id="btnGenerar" class="boton" type="submit" value="Generar Reporte"/>
                </td> 
            </tr>
            
        </table>
        <?php echo form_close(); ?>
    </div>
    <div>
        <?php echo form_open('citaControlador/reporteServicioMasSolicitado/'); ?>
        <h2>Servicio mas solicitado</h2><br /><br />
        <input id="btnGenerar" class="boton" type="submit" value="Generar Reporte"/>
        <?php echo form_close(); ?>
    </div>
    <div>
        <?php echo form_open('citaControlador/reporteEstudiantesPorFecha/'); ?>
        <h2>Listado de estudiantes por atender en determinada fecha</h2><br /><br />
        <table>
        <tr>

                <td>
                    <h4 style="font-size: 15px;color: grey">Escoga el personal de salud:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</h4><br /><br />
                </td>
                <td>
                    <select name="personal" id="personal" style="background:whitesmoke;border: 1px solid;width:273px">
                        <option value="">Selecciona una Opcion</option>
                        <?php
                        foreach ($personal->result() as $fila) {

                            echo '<option value="' . $fila->id_personalsalud . '">' . $fila->primer_nombre .' '.$fila->primer_apellido. '</option>';
                        }
                        ?>  
                    </select><br /><br />
                </td>
                <td>
                    <?php echo form_error('personal', '<b><p style="color:red; padding-left: 10%;">', '</p></b>'); ?>
                </td>
            </tr>
            <tr  style="height: 35px">
                             <td><strong>Seleccione una fecha:*</strong>(YYYY-MM-DD)<br /></td>
                             <td><input type="text" id="fecha_nac" size="15" style="border-style:solid;border-width:1px;"name= "fecha_nac" readonly/>
                             </td>
                             <td>
                                <?php echo form_error('fecha_nac','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
            <tr>
              <td>
                     <input id="btnGenerar" class="boton" type="submit" value="Generar Reporte"/>
                </td> 
            </tr>
           </table>
        <?php echo form_close(); ?>
    </div>
    
</section>
