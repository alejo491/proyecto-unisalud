<body id="page1">
    <div class="body1"></div>
    <div class="body2" style="">
        <div class="main"><div class="ic"></div>
            <!--header -->
            <header>
                    <?php
                    $user = $this->session->all_userdata();
                    if (isset($user['id_usuario'])) {?>
                            <?php $this->load->view("estandar/micuenta");?>
                        <?php
                    } else {
                        ?>
                            <?php $this->load->view("estandar/inicioSesion");
                            ?>
                            <?php
                    }
                    ?>
                <div class="wrapper">
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