<section id="content_top">
    <?php 
    $user = $this->session->all_userdata();
                            if(isset($user['id_usuario']) && $user['id_rol']==3){
                                $this->load->view("personal/menu");
                            }
                            elseif(isset($user['id_usuario']) && $user['id_rol']==1){
                                $this->load->view("estudiante/menu");
                            }
                            else{
                                $this->load->view("estandar/menu");
                            }
    ?>
</section>