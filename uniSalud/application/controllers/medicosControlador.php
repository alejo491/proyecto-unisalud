<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class medicosControlador extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        //$this->load->model('medicosModelo');
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
            $crud->set_table('medico');
            $crud->set_relation_n_n('medico', 'atiende', 'servicio', 'id_medico', 'id_servicio', 'tipo_servicio');
            $crud->set_subject('Medico');
            $crud->required_fields('numero_tarjeta', 'identificacion', 'nombre_medico');
            $crud->display_as('nombre_medico', 'Nombre');
            $crud->display_as('medico', 'Servicios');
            $crud->unset_read();
            $crud->unset_print();
            $crud->unset_export();
            $crud->add_action('Agenda', '', 'http://localhost/uniSalud/agendaControlador/index/', 'ui-icon-plus');
            $crud->set_crud_url_path(site_url('medicosControlador/index'));
            $output = $crud->render();
            $this->mostrar($data, $output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
}
