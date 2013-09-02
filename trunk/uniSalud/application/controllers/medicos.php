<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Medicos extends CI_Controller {

    function _construct() {
        parent::_construct();
    }

    public function index() {
         $data['titulo'] = "Personal UniSalud";
	 $data['title'] = 'Personal UniSalud';
         $data['content'] = 'reegistro_medico';
         $this->load->view('plantilla', $data);
       
    }

    public function registrar(){}
    
}
