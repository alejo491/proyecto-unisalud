<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class serviciosControlador extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('grocery_CRUD');
    }

    public function mostrar($data, $output = null) {
        $data['output'] = $output;
        $this->load->view('plantilla', $data);
    }

    public function index() {
        
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'personal/topcontentServicios';
        $data['content'] = 'personal/contentServicios';
        $data['footerMenu'] = 'personal/footerMenu';

        try {
            $crud = new grocery_CRUD();
            $crud->set_table('servicio');
            $crud->set_subject('Servicio');
            $crud->required_fields('costo', 'tipo_servicio');
            $crud->display_as('tipo_servicio', 'Tipo de Servicio');
            $crud->unset_read();
            $crud->unset_print();
            $crud->set_crud_url_path(site_url('serviciosControlador/index'));

            $output = $crud->render();
            $this->mostrar($data, $output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
}

?>