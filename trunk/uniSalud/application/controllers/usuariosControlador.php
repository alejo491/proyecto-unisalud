<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UsuariosControlador extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('usuarioModelo');   
    }

    public function login() {
       if ($_POST) {
            $this->form_validation->set_rules('email', 'Buscar', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('contrasena', 'Buscar', 'trim|required|xss_clean');
            $this->form_validation->set_message('required', 'El campo %s es requerido');
            $this->form_validation->set_message('valid_email', 'El campo %s debe ser un email');
            $this->form_validation->set_message('trim', 'No se admiten caracteres especiales');
            $this->form_validation->set_message('xss_clean', 'Codigo malicioso detectado');
            $data['header'] = 'includes/headerHome';
                $data['menu'] = 'estandar/menu';
                //$data['topcontent'] = 'estandar/topcontentRegistrarse';
                $data['topcontent']='estandar/topcontent';
                $data['content'] = 'estandar/contentHome';
                $data['footerMenu'] = 'estandar/footerMenu';
            if ($this->form_validation->run() == FALSE) {
                $data['errores'] = validation_errors();
            }else{
                $email = $this->input->post('email', true);
                $contrasena = sha1($this->input->post('contrasena', true));
                $usuarioActual = $this->usuarioModelo->login($email, $contrasena);
               if (isset($usuarioActual)) {
                    $this->session->set_userdata('id_usuario', $usuarioActual['id_usuario']);
                    $this->session->set_userdata('email', $usuarioActual['email']);
                    $id_rol=$this->usuarioModelo->getRol($usuarioActual['id_usuario']);
                    $this->session->set_userdata('id_rol',$id_rol['id_rol']);
                }
            }
            $this->load->view('plantilla',$data);
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }
}
