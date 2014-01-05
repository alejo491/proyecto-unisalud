<section id="content">
    <h1 style="font-size: 25px;color: black" align="center"><?php echo $titulo_reporte;?></h1><br /><br /><br />
    <div id="paginacion" align="center">
        <?php if(isset($paginacion))echo $paginacion?>
    </div>
<?php if($tipo_reporte=='1'){ ?>
    <table id="tabla">
        <thead align="center">
            <tr>
                <th scope="col"><b>Programa</b></th>
                <th scope="col"><b>Numero de estudiantes</b></th>
                
            </tr>
        </thead>
        <?php if (isset($reporte) && $reporte != null): ?>
            <tbody>
                <?php foreach ($reporte->result() as $rep): ?>
                    <tr>
                        <td>
                            <?php echo $rep->nombre_programa; ?></br>
                            
                        </td>
                        <td>
                            <?php echo $rep->numero; ?></br>
                            
                        </td>
                        
                       
                    </tr>
                <?php endforeach; ?>
            </tbody>
            
        <?php else: ?>
            <tfoot>
                <tr>
                    <td colspan="6">No hay resultados </td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>
<?php }?>
<?php if($tipo_reporte=='2'){ ?>
    <table id="tabla">
        <thead align="center">
            <tr>
                <th scope="col"><b>Identificacion</b></th>
                <th scope="col"><b>Nombre</b></th>
                <th scope="col"><b>Hora</b></th>
                <th scope="col"><b>Observaciones</b></th>
                
            </tr>
        </thead>
        <?php if (isset($reporte) && $reporte != null): ?>
            <tbody>
                <?php foreach ($reporte->result() as $rep): ?>
                    <tr>
                        <td>
                            <?php echo $rep->identificacion; ?></br>
                            
                        </td>
                        <td>
                            <?php echo $rep->primer_nombre.' '.$rep->primer_apellido; ?></br>
                            
                        </td>
                        <td>
                            <?php echo $rep->hora_inicio; ?></br>
                            
                        </td>
                        <td>
                            <?php echo $rep->observaciones; ?></br>
                            
                        </td>
                        
                       
                    </tr>
                <?php endforeach; ?>
            </tbody>
            
        <?php else: ?>
            <tfoot>
                <tr>
                    <td colspan="6">No hay resultados </td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>
<?php }?> 
<?php if($tipo_reporte=='3'){ ?>
    <table id="tabla">
        <thead align="center">
            <tr>
                <th scope="col"><b>Facultad</b></th>
                <th scope="col"><b>Numero de estudiantes</b></th>
                
            </tr>
        </thead>
        <?php if (isset($reporte) && $reporte != null): ?>
            <tbody>
                <?php foreach ($reporte->result() as $rep): ?>
                    <tr>
                        <td>
                            <?php echo $rep->nombre_facultad; ?></br>
                            
                        </td>
                        <td>
                            <?php echo $rep->numero; ?></br>
                            
                        </td>
                        
                       
                    </tr>
                <?php endforeach; ?>
            </tbody>
            
        <?php else: ?>
            <tfoot>
                <tr>
                    <td colspan="6">No hay resultados </td>
                </tr>
            </tfoot>
        <?php endif; ?>
    </table>
<?php }?>
<?php if($tipo_reporte=='4'){ 
    if($reporte){
        if($reporte->num_rows()>1){
            echo ('Los servicios mas solicitados son: <br />');
            foreach ($reporte->result() as $rep): 

                echo '<strong>'.$rep->tipo_servicio.'</strong><br />';
            endforeach;
        }else{

            echo ('El servicio mas solicitado es: <br />');
            foreach ($reporte->result() as $rep): 

                echo '<strong>'.$rep->tipo_servicio.'</strong><br />';
            endforeach;
        }
    }else{
        
        echo 'No hay resultados';
    }
}?>    
    <div id="paginacion" align="center">
        <?php if(isset($paginacion))echo $paginacion?>
    </div>
    <div>
    <?php echo form_open('reporteControlador') ?>
        
         <input id="btnAgregar" type="submit" value="Volver" class="boton"/>
        <?php echo form_close(); ?>
    </div>
</section>



