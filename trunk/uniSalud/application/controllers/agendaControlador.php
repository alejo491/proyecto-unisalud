<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class agendaControlador extends CI_Controller {

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
        $data['topcontent'] = 'personal/topcontentPersonalMedico';
        $data['content'] = 'personal/contentPersonalMedico';
        $data['footerMenu'] = 'personal/footerMenu';

        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('datatables');
            $crud->set_table('medico');
            $crud->set_relation_n_n('medico', 'atiende', 'servicio', 'id_medico', 'id_servicio', 'tipo_servicio');
            $crud->set_subject('Medico');
            $crud->required_fields('numero_tarjeta', 'identificacion', 'nombre_medico', 'especialidad');
            $crud->display_as('nombre_medico', 'Nombre');
            $crud->display_as('medico', 'Servicios');
            $crud->unset_read();
            $crud->unset_print();
            $crud->add_action('Actualizar Agenda', 'hola', 'http://localhost/uniSalud/agendaControlador/actualizarAgenda/', 'ui-icon-plus');
            $crud->set_crud_url_path(site_url('agendaControlador/index'));

            $output = $crud->render();
            $this->mostrar($data, $output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    public function actualizarAgenda() {
        $this->load->model('agendaModelo');
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'personal/topcontentHorarioAtencion';
        $data['content'] = 'personal/contentHorarioAtencion';
        $data['footerMenu'] = 'personal/footerMenu';
        $session = $this->session->all_userdata();
        if (isset($session['medico_id'])) {
            $id_medico = $session['medico_id'];
        } else {
            $id_medico = $this->uri->segment(3);
            $this->session->set_userdata('medico_id', $id_medico);
        }
        $data['medico'] = $this->agendaModelo->getMedico($id_medico);
        try {
            $crud = new grocery_CRUD();
            //$crud->set_theme('datatables');
            $crud->set_table('horarioatencion');
            $crud->set_subject('Horario de Atencion');
            $crud->required_fields('dia', 'hora_inicial', 'hora_final');
            $crud->set_relation('id_medico', 'medico','nombre_medico');
            $crud->fields('dia', 'hora_inicial', 'hora_final','id_medico');
            $crud->where('horarioatencion.id_medico', $id_medico);
            $crud->display_as('hora_inicial', 'Hora de Inicio');
            $crud->display_as('hora_final', 'Hora de Finalizacion');
            $crud->display_as('id_medico', '');
            $crud->callback_edit_field('id_medico', array($this, 'cargarMedico'));
            $crud->callback_add_field('id_medico',array($this,'cargarMedico'));
            $crud->unset_print();
            $crud->set_crud_url_path(site_url('agendaControlador/actualizarAgenda'));

            $output = $crud->render();
            $this->mostrar($data, $output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    function cargarMedico() {
        $session = $this->session->all_userdata();
            $id_medico=$session['medico_id'];
            return '<input style="visibility:hidden;" type="text" maxlength="50" value="'.$id_medico.'" name="id_medico" style="width:400px">';
       }

}

?>