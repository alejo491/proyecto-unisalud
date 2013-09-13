<div style="float:right;color: white">
            <?php echo 'Hola ' . $this->session->all_userdata()['email']; ?>
            <?php echo anchor('usuariosControlador/logout', 'cerrar sesion'); ?><br />
            </div>