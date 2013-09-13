<!--content -->

<div class="main">
    <div style="padding-left: 150px">
		   <?php
                   
                   
                    
                    $this->load->helper('form');
                    $atributos=array(
                        
                        'id'    => 'formRegistroPersonal'
                    );
                    echo form_open('usuario/registrar', $atributos);
                    ?>
                    <h1 style="font-size: 25px;color: black">Registro de Nuevo Usuario</h1><br /><br /><br />
                    <h4 style="font-size: 15px;color: grey">Los campos marcados con (*) son obligatorios</h2><br /><br />
                    <table>
                        
                        <tr style="height: 35px ">
                            <td style="width: 200px"><strong>Nombres y Apellidos:*</strong><br /></td>
                            <td><?php
                                $data_form=array(
                                    'id'        => 'nombre',
                                    'nombre'    =>  'nombre',
                                    'size'      =>  '40',
                                    'value'     => set_value('nombre'),
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                );
                               echo form_error('nombre','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?><br /></td>
                         </tr>
                         
                         <tr  style="height: 35px">
                             <td><strong>Cedula:*</strong><br /></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'cedula',
                                    'nombre'    =>  'cedula',
                                    'size'      =>  '40',
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                    
                                );
                               echo form_error('cedula','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?><br /></td>
                         </tr>
                        
                         
                         
                          <tr  style="height: 35px">
                             <td><strong>E-mail:*</strong><br /></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'email',
                                    'nombre'    =>  'email',
                                    'size'      =>  '40',
                                    'style'     => "background:whitesmoke; border: 1px solid"
                                );
                               echo form_error('email','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?><br /></td>
                         </tr>
                         <tr  style="height: 35px">
                             <td><strong>Contrase&ntilde;a:*</strong><br /></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'Contrasena',
                                    'nombre'    =>  'Contrasena',
                                    'size'      =>  '40',
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                );
                               echo form_error('Contrasena','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?><br /></td>
                         </tr>
                         <tr  style="height: 35px">
                             <td><strong>Comfirmar contrase&ntilde;a:*</strong><br /></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'CContrasena',
                                    'nombre'    =>  'CContrasena',
                                    'size'      =>  '40',
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                );
                               echo form_error('CContrasena','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?><br /></td>
                         </tr>
                           <tr  style="height: 35px">
                             <td><strong>Facultad:*</strong><br /></td>
                             <td><?php
                                $data_form=array(
                                    'null'      => 'selecciones una opcion',
                                    'id'        => 'facultad',
                                    'nombre'    =>  'facultad',
                                    'size'      =>  '40',
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                );
                               echo form_error('facultad','<b><p style="color:red;">','</p></b>'); 
                               echo form_dropdown('facultad',$data_form,array(),'style="background:whitesmoke;border: 1px solid;width:273px"');
                            
                            
                                ?><br /></td>
                         </tr>
                         <tr  style="height: 35px">
                             <td><strong>Programa:*</strong><br /></td>
                             <td><?php
                                $data_form=array(
                                    'null'      => 'selecciones una opcion',
                                    'id'        => 'programa',
                                    'nombre'    =>  'programa',
                                    'size'      =>  '40',
                                    'style'     => "background:whitesmoke;border: 1px solid"
                                );
                               echo form_error('programa','<b><p style="color:red;">','</p></b>'); 
                               echo form_dropdown('programa',$data_form,array(),'style="background:whitesmoke;border: 1px solid;width:273px"');
                            
                            
                                ?><br /></td>
                         </tr>
                   
                    </table><br />
                    <br />
                    <table id ="btnRegistro">
                            <tr style="height: 35px">
                                <td><input  type="submit" value="Registrar" /></td><td><input  type="button" value="Cancelar" onclick="cancelar" /></td>
                                
                             </tr>
                    </table>
 
		
                   <?php
                               echo form_close();
                   ?>
		
	</div>
</div>
