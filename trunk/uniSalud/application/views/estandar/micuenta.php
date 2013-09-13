<div style="float:right;color: white">
            <?php echo 'Hola ' . $this->session->all_userdata()['email']; ?><blockquote />
            <?php echo anchor('usuario/logout', 'cerrar sesion'); ?><br />
            </div>