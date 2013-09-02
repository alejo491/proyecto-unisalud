<!--content -->
<div class="body3">
	<div class="main">
		<?php $this->load->view("estandar/topcontent");?>
	</div>
</div>
<div class="main">
	
		<div class="wrapper pad_bot1">
			
                       
       
                    <?php
                    $this->load->helper('form');
                    $atributos=array(
                        
                        'id'    => 'formRegistroPersonal'
                    );
                    echo form_open('medicos/registrar', $atributos);
                    ?>
                    <h1>Registro de Nuevo Usuario</h1><br />
                    <strong>Los campos marcados con (*) son obligatorios</strong><br /><br />
                    <table>
                        
                        <tr>
                            <td><strong>Nombres:*</strong></td>
                            <td><?php
                                $data_form=array(
                                    'id'        => 'nombre',
                                    'nombre'    =>  'nombre',
                                    'size'      =>  '40',
                                    'value'     => set_value('nombre')
                                );
                               echo form_error('nombre','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?></td>
                         </tr>
                         <tr>
                             <td><strong>Apellidos:*</strong></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'apellido',
                                    'nombre'    =>  'apellido',
                                    'size'      =>  '40',
                                    'value'     => set_value('apellido')
                                );
                               echo form_error('apellido','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?></td>
                         </tr>
                         <tr>
                             <td><strong>Cedula:*</strong></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'cedula',
                                    'nombre'    =>  'cedula',
                                    'size'      =>  '40',
                                    
                                );
                               echo form_error('cedula','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?></td>
                         </tr>
                         <tr>
                             <td><strong>N° Tarjeta Profesional:*</strong></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'Tarjeta',
                                    'nombre'    =>  'Tarjeta',
                                    'size'      =>  '40',
                                    
                                );
                               echo form_error('Tarjeta','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?></td>
                         </tr>
                         <tr>
                             <td><strong>Profesion:*</strong></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'Profesion',
                                    'nombre'    =>  'Profesion',
                                    'size'      =>  '40',
                                    
                                );
                               echo form_error('Profesion','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?></td>
                         </tr>
                         <tr>
                             <td><strong>Especialidad:*</strong></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'especialidad',
                                    'nombre'    =>  'especialidad',
                                    'size'      =>  '40',
                                    
                                );
                               echo form_error('especialidad','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?></td>
                         </tr>
                          <tr>
                             <td><strong>E-mail:*</strong></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'email',
                                    'nombre'    =>  'email',
                                    'size'      =>  '40',
                                    
                                );
                               echo form_error('email','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?></td>
                         </tr>
                         <tr>
                             <td><strong>Comfirmar E-mail:*</strong></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'comemail',
                                    'nombre'    =>  'comemail',
                                    'size'      =>  '40',
                                    
                                );
                               echo form_error('comfirmaremail','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?></td>
                         </tr>
                         <tr>
                             <td><strong>Servicio a prestar:*</strong></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'servicio',
                                    'nombre'    =>  'servicio',
                                    'size'      =>  '40',
                                    
                                );
                               echo form_error('servicio','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?></td>
                         </tr>
                           <tr>
                             <td><strong>Servicio a prestar:*</strong></td>
                             <td><?php
                                $data_form=array(
                                    'id'        => 'servicio',
                                    'nombre'    =>  'servicio',
                                    'size'      =>  '40',
                                    
                                );
                               echo form_error('servicio','<b><p style="color:red;">','</p></b>'); 
                               echo form_input($data_form);
                            
                            
                                ?></td>
                         </tr>
                   
                    </table><br />
                    <br />
                    <table id ="btnRegistro">
                            <tr>
                                <td><input  type="submit" value="Registrar" /></td>
                                
                             </tr>
                    </table>
 
		
                   <?php
                               echo form_close();
                   ?>
		</div>
	
</div>