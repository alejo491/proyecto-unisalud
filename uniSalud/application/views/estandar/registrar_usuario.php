<!--content -->

<div class="main">
    <div style="padding-left: 150px">
                   <?php
                    $this->load->helper('form');
                    $atributos=array(
                        
                        'id'    => 'formRegistroPersonal'
                    );
                    echo form_open('estandarControlador/registrar', $atributos);
                    ?>
                    <h1 style="font-size: 25px;color: black">Registro de Nuevo Usuario</h1><br /><br /><br />
                    <h4 style="font-size: 15px;color: grey">Los campos marcados con (*) son obligatorios</h2><br /><br />
                    <table>
                            <tr style="height: 35px ">
                            <td style="width: 200px"><strong>Codigo Estudiante:* </strong><br /></td>
                            <td><?php 
                                $data_form=array(
                                    'id'        => 'codigoEstudiante',
                                    'name'    =>  'codigoEstudiante',
                                    'size'      =>  '40',
                                    'value'     => set_value('codigoEstudiante'),
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                ); 
                               echo form_input($data_form);?>
                            </td>
                            <td>
                                <?php echo form_error('codigoEstudiante','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                         <tr style="height: 35px ">
                            <td style="width: 200px"><strong>Primer Nombre:* </strong><br /></td>
                            <td><?php
                                $data_form=array(
                                    'id'        => 'primerNombre',
                                    'name'    =>  'primerNombre',
                                    'size'      =>  '40',
                                    'value'     => set_value('primerNombre'),
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                );
                               echo form_input($data_form);?>
                            </td>
                            <td>
                                <?php echo form_error('primerNombre','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                         <tr style="height: 35px ">
                            <td style="width: 200px"><strong>Segundo Nombre: </strong><br /></td>
                            <td><?php
                                $data_form=array(
                                    'id'        => 'segundoNombre',
                                    'name'    =>  'segundoNombre',
                                    'size'      =>  '40',
                                    'value'     => set_value('segundoNombre'),
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                );
                               echo form_input($data_form);
                                ?>
                            </td>
                            <td>
                                <?php echo form_error('segundoNombre','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                         <tr style="height: 35px ">
                            <td style="width: 200px"><strong>Primer Apellido:* </strong><br /></td>
                            <td><?php
                                $data_form=array(
                                    'id'        => 'primerApellido',
                                    'name'    =>  'primerApellido',
                                    'size'      =>  '40',
                                    'value'     => set_value('primerApellido'),
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                );echo form_input($data_form);?>
                            </td>
                            <td>
                                <?php echo form_error('primerApellido','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                         <tr style="height: 35px ">
                            <td style="width: 200px"><strong>Segundo Apellido:* </strong><br /></td>
                            <td><?php
                                $data_form=array(
                                    'id'        => 'segundoApellido',
                                    'name'    =>  'segundoApellido',
                                    'size'      =>  '40',
                                    'value'     => set_value('segundoApellido'),
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                );
                               echo form_input($data_form);?>
                            </td>
                            <td>
                                <?php echo form_error('segundoApellido','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                         <tr style="height: 35px ">
                            <td style="width: 200px"><strong>Genero:*</strong><br /></td>
                            <td><?php
                                $data_form=array(
                                    'm'    =>  'masculino',
                                    'f'      =>  'femenino'
                                );
                               echo form_dropdown('genero',$data_form,array(),'style="background:whitesmoke;border: 1px solid;width:273px"')
                                ?>
                            </td>
                            <td>
                                <?php echo form_error('genero','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                         
                         <tr  style="height: 35px">
                             <td><strong>Facultad:*</strong><br /></td>
                             <td><select name="facultad" id="facultad" style="background:whitesmoke;border: 1px solid;width:273px" onchange="carga_programa('<?php echo base_url()?>estandarControlador/cargarprograma','programa')">
                                <option value="">Selecciona una facultad</option>
                                 <?php 
                                    foreach($facultades->result_array() as $fila)
                                    {
                                    
                                   echo  '<option value="'.$fila['id_facultad'].'">'.$fila['nombre_facultad'].'</option>';
                                    
                                    }
                                    ?>  
                                </select>
                             </td>   
                             <td>
                                <?php echo form_error('facultad','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                         <tr  style="height: 35px">
                             <td><strong>Programa:*</strong><br /></td>
                             <td><select id="programa" name="programa" style="background:whitesmoke;border: 1px solid;width:273px" >
                                <option value="">Selecciona un programa</option>
                                
                                </select>
                             </td>   
                             <td>
                                <?php echo form_error('programa','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                         <tr  style="height: 35px">
                             <td><strong>Fecha de Nacimiento:*</strong>(YYYY-MM-DD)<br /></td>
                             <td><input type="text" id="fecha_nac" size="15" name= "fecha_nac" readonly/>
                             </td>
                             <td>
                                <?php echo form_error('fecha_nac','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                         <tr style="height: 35px ">
                            <td style="width: 200px"><strong>Tipo de Indentificacion:*</strong><br /></td>
                            <td><?php
                                $data_form=array(
                                    'Cedula de Ciudadania'    =>  'Cedula de Ciudadania',
                                    'Tarjeta de Identidad'      =>  'Tarjeta de Identidad',
                                    'Registro Civil'     => 'Registro Civil'
                                );
                               echo form_dropdown('tipoId',$data_form,array(),'style="background:whitesmoke;border: 1px solid;width:273px"')?>
                            </td>
                            <td>
                                <?php echo form_error('tipoId','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>  
                         
                         
                         
                         <tr  style="height: 35px">
                             <td><strong>Numero de Identificacion:*</strong><br /></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'numId',
                                    'name'    =>  'numId',
                                    'size'      =>  '40',
                                    'value'     => set_value('numId'),
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                    
                                );
                               echo form_input($data_form);?>
                             </td>
                             <td>
                                <?php echo form_error('numId','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                          <tr  style="height: 35px">
                             <td><strong>E-mail:*</strong><br /></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'email',
                                    'name'    =>  'email',
                                    'size'      =>  '40',
                                    'style'     => "background:whitesmoke; border: 1px solid"
                                );
                               echo form_input($data_form);?>
                             </td>
                             <td>
                                <?php echo form_error('email','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                         <tr  style="height: 35px">
                             <td><strong>Contrase&ntilde;a:*</strong><br /></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'contrasena',
                                    'name'    =>  'contrasena',
                                   
                                    'size'      =>  '40',
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                );
                               echo form_password($data_form);?>
                             </td>
                             <td>
                                <?php echo form_error('contrasena','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                         <tr  style="height: 35px">
                             <td><strong>Confirmar contrase&ntilde;a:*</strong><br /></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'CContrasena',
                                    'name'    =>  'CContrasena',
                                    'size'      =>  '40',
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                );
                               echo form_password($data_form);?>
                             </td>
                             <td>
                                <?php echo form_error('CContrasena','<b><p style="color:red; padding-left: 10%;">','</p></b>'); ?>
                            </td>
                         </tr>
                   
                    </table><br />
                    <br />
                    <table id ="btnRegistro">
                            <tr style="height: 35px">
                                <td><input  type="submit" value="Registrar" style=" height: 100%;border-radius: 15% 15% 15% 15%;cursor: pointer;box-shadow:3px 3px 5px #402f55;"/></td>
                                <td><input  type="button" value="Cancelar" onclick="cancelar('<?php echo base_url()?>estandarControlador/cancelar')" style=" height: 100%;border-radius: 15% 15% 15% 15%;cursor: pointer;box-shadow:3px 3px 5px #402f55;" /></td>               
                             </tr>
                    </table>
 
                
                   <?php
                               echo form_close();
                   ?>
                
        </div>
</div>