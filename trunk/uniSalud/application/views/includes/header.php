<body id="page2">
<div class="body1"></div>
<div class="body2">
	<div class="main"><div class="ic"></div>
<!--header -->
		<header>
			<div class="wrapper">
                                <?php 
                                    $user=$this->session->all_userdata();
                                    
                                    if(isset($user['id_usuario'])){
                                ?>
                                        <div style="float:right;padding: 5px 5px 0 0;width: 50%;height: 33px">
                                <?php $this->load->view("estandar/micuenta");
                                       
                                ?>
                                            </div><br /><br />
                                <?php
                                    }else{
                               ?>
                                    
                                    <div style="float:right;padding: 5px 5px 0 0;width: 50%;height: 25px">
                               <?php    $this->load->view("estandar/inicioSesion");
                                   ?></div><br /><br />
                               <?php
                                    }
                                    ?>

				<?php $this->load->view($menu);?><br /><br /><br />
				
				<h1><a href="index.html" id="logo">cience</a></h1>
			</div>
			<div class="wrapper">
				<article class="col1 pad_left2">
					<div class="text1">Division De Salud Integral <span>Universidad Del Cauca</span></div>
					<p>Aqui va una descripcion general de la aplicacion. 
                                            Aqui va una descripcion general de la aplicacion.
                                            Aqui va una descripcion general de la aplicacion.
                                            Aqui va una descripcion general de la aplicacion.
                                            Aqui va una descripcion general de la aplicacion.</p>
				</article>
			</div>
		</header>
	</div>
</div>
<!--header end-->