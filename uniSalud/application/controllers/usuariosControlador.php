<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class UsuariosControlador extends CI_Controller {

    /*Constructor de la clase*/
    function __construct() {
        parent::__construct();
        $this->load->model('usuarioModelo');   
    }
    /*Funcion que permite la comprovacion del usuario, y su respectivo inicio de sesion segun el rol*/
    public function login() {
       if ($_POST) {
            $this->form_validation->set_rules('email', 'Email', 'trim|required|xss_clean|valid_email|callback_Existe');
            $this->form_validation->set_rules('contrasena', 'Contraseña', 'trim|required|xss_clean|callback_Contra');
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
                    $this->set_session('id_usuario', $usuarioActual['id_usuario']);
                    $this->set_session('email', $usuarioActual['email']);
                    $id_rol=$this->usuarioModelo->getRol($usuarioActual['id_usuario']);
                    $this->set_session('id_rol',$id_rol['id_rol']);
                }
            }
            $this->load->view('plantilla',$data);
        }
    }
 /*Funcion que elimina los datos de sesion del sistema*/
    public function logout() {
        $this->session->sess_destroy();
        redirect(base_url());
    }
    /*Funcion que comprueba la existencia o no de un usuario en la Base de Datos*/
    function Existe(){
        $email = $this->input->post('email', true);
        
        if($this->usuarioModelo->Existe($email)){
            $this->form_validation->set_message('Existe', 'No existe el usuario');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    /*Funcion que mediante el modelo verifica la atenticacion de un usuario*/
    function Contra(){
        $email = $this->input->post('email', true);
        $email = $this->input->post('email', true);
        $contrasena = sha1($this->input->post('contrasena', true));
                
        if(!$this->usuarioModelo->login($email, $contrasena)){
            $this->form_validation->set_message('Contra', 'Contraseña incorrecta');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    //funciones para acceder y modificar las variables de session
    public function set_session($var,$cont=NULL){
        $this->session->set_userdata($var, $cont);
    }
    public function get_session(){
        return $this->session->all_userdata();
    }
}
