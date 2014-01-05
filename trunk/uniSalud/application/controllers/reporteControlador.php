<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class reporteControlador extends CI_Controller {

    
    /*Funcion Principal del controlador*/
    public function index(){
       
        $this->set_session('mensaje', NULL);
        $data['header'] = 'includes/header';
            $data['menu'] = 'personal/menu';
            $data['topcontent'] = 'estandar/topcontent';
            $data['content'] = 'personal/generarReportes';
            $data['footerMenu'] = 'personal/footerMenu';
            $data['title'] = "Reportes";
            $data['programas'] = $this->programaSaludModelo->obtenerProgramas();
            $data['personal']=$this->personalSaludModelo->obtenerPersonalSalud();
            $this->load->view('plantilla', $data);
        
    }
    
    //funciones para acceder y modificar las variables de session
    public function set_session($var,$cont=NULL){
        $this->session->set_userdata($var, $cont);
    }
    public function get_session(){
        return $this->session->all_userdata();
    }
}
?>
