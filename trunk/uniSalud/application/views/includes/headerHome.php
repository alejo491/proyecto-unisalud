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
                        <p>En esta pagina se encontrara informacion sobre los servicios
                        ofrecidos por la division de salud integral de la Universidad del Cauca,
                        el personal de salud que lo compone y la realizacion de citas medicas.
                        </p>
                    </article>
                </div>
            </header>
        </div>
    </div>
    <!--header end-->