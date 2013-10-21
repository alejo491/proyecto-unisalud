<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class consultorioControlador extends CI_Controller {

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
        $this->session->set_userdata('medico_id',"");
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        //$data['topcontent'] = 'personal/topcontentPersonalMedico';
        $data['topcontent']='estandar/topcontent';
        $data['content'] = 'personal/contentPersonalMedico';
        $data['footerMenu'] = 'personal/footerMenu';

        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('datatables');
            $crud->set_table('consultorio');
            $crud->set_subject('Consultorio');
            $crud->required_fields('numero_consultorio');
            $crud->columns('numero_consultorio', 'descripcion');
            $crud->display_as('numero_consultorio', 'Numero de Consultorio');
            $crud->display_as('descripcion', 'Descripcion');
            $crud->unset_read();
            $crud->unset_print();
            $crud->unset_export();
            $crud->set_crud_url_path(site_url('consultorioControlador/index'));
            $output = $crud->render();
            $this->mostrar($data, $output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
}
