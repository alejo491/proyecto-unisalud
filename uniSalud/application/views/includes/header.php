<body id="page2">
    <div class="body1"></div>
    <div class="body2" style="">
        <div class="main"><div class="ic"></div>
            <!--header -->
            <header>
                    <?php
                    $user = $this->session->all_userdata();
                    if (isset($user['id_usuario'])) {
                        $this->load->view("estandar/micuenta");
                    } else {
                        $this->load->view("estandar/inicioSesion");
                    }
                    ?>
                <div class="wrapper">
                    <h1><a href="http://localhost/uniSalud/" id="logo">cience</a></h1>
                </div>
                <div class="wrapper">
                    <article class="col1 pad_left2">
                        <div class="text1">Division De Salud Integral <span>Universidad Del Cauca</span></div>
                    </article>
                </div>
            </header>
        </div>
    </div>
    <!--header end-->