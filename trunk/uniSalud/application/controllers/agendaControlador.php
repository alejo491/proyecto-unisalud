<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class agendaControlador extends CI_Controller {
        function _construct() {
            parent::_construct();
        }

	public function index()
	{
		$this->load->view('plantilla');
	}
}
?>