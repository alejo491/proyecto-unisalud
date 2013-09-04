<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Usuario extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('usuariosModel');
        
       
    }
    
    

    
    
    public function login() {
        
       if ($_POST) {
            $this->form_validation->set_rules('email', 'Buscar', 'trim|required|xss_clean|valid_email');
            $this->form_validation->set_rules('contrasena', 'Buscar', 'trim|required|xss_clean');
            $this->form_validation->set_message('required', 'El campo %s es requerido');
            $this->form_validation->set_message('valid_email', 'El campo %s debe ser un email');
            $this->form_validation->set_message('trim', 'No se admiten caracteres especiales');
            $this->form_validation->set_message('xss_clean', 'Codigo malicioso detectado');
            if ($this->form_validation->run() == TRUE) {
                $email = $this->input->post('email', true);
                $contrasena = $this->input->post('contrasena', true);
                $usuarioActual = $this->usuariosModel->login($email, $contrasena);
                 
               if (isset($usuarioActual)) {
                   
                
                    
                    $this->session->set_userdata('id_usuario', $usuarioActual['id_usuario']);
                    $this->session->set_userdata('email', $usuarioActual['email']);
                    $this->session->set_userdata('id_rol',$this->usuariosModel->getRol($usuarioActual['id_usuario'])['id_rol']);
                    
                }
            }
            else{
                
               
            }
            
           redirect(base_url());
        }
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }
    
   
    
    
}
