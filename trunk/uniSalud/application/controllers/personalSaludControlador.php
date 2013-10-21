<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class personalSaludControlador extends CI_Controller {

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
            $crud->set_table('personalsalud');
            $crud->set_subject('Personal De Salud');
            $crud->set_relation_n_n('personalsalud', 'atiende', 'programasalud', 'id_personalsalud', 'id_programasalud', 'tipo_servicio');
            $crud->set_relation('id_consultorio', 'consultorio','numero_consultorio');
            $crud->required_fields('id_consultorio','numero_tarjeta', 'identificacion', 'tipo_identificacion','primer_nombre','primer_apellido');
            $crud->columns('primer_nombre', 'primer_apellido', 'id_consultorio','especialidad');
            $crud->display_as('id_consultorio', 'Numero de Consultorio');
            $crud->display_as('primer_nombre', 'Primer Nombre');
            $crud->display_as('segundo_nombre', 'Segundo Nombre');
            $crud->display_as('primer_apellido', 'Primer Apellido');
            $crud->display_as('segundo_apellido', 'Segundo Apellido');
            $crud->display_as('personalsalud', 'Programa de Salud');
            $crud->display_as('numero_tarjeta','Numero Tarjeta');
            $crud->callback_edit_field('tipo_identificacion', array($this, 'inputTipoId'));
            $crud->callback_add_field('tipo_identificacion',array($this,'inputTipoId'));
            $crud->unset_read();
            $crud->unset_print();
            $crud->unset_export();
            $crud->add_action('Agenda', '', 'http://localhost/uniSalud/agendaControlador/index/', 'ui-icon-plus');
            $crud->set_crud_url_path(site_url('personalSaludControlador/index'));
            $output = $crud->render();
            $this->mostrar($data, $output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }
    function inputTipoId() {
            return '<select name="tipo_identificacion">
  <option value="Cedula de Ciudadania" selected="selected">Cedula de Ciudadania</option>
  <option value="Cedula Extranjera">Cedula Extranjera</option>
</select>';
       }
}
