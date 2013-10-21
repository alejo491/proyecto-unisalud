<div style="float:right;color: white">
            <?php 
            $email=$this->session->all_userdata();
            echo 'Hola '. $email['email'].' ';?>
            <?php echo anchor('usuariosControlador/logout', 'Cerrar Sesion'); ?><br />
            </div>