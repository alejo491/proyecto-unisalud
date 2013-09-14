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
        $this->load->model('agendaModelo');
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'personal/topcontentHorarioAtencion';
        $data['content'] = 'personal/contentHorarioAtencion';
        $data['footerMenu'] = 'personal/footerMenu';
        $session = $this->session->all_userdata();
        if (isset($session['medico_id']) && $session['medico_id']!="") {
            $id_medico = $session['medico_id'];
        } else {
            $id_medico = $this->uri->segment(3);
            $this->session->set_userdata('medico_id', $id_medico);
        }
        $data['medico'] = $this->agendaModelo->getMedico($id_medico);
        try {
            $crud = new grocery_CRUD();
            $crud->set_theme('datatables');
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
            $crud->callback_edit_field('dia', array($this, 'inputDia'));
            $crud->callback_add_field('dia',array($this,'inputDia'));
            $crud->callback_edit_field('hora_inicial', array($this, 'inputHoraI'));
            $crud->callback_add_field('hora_inicial',array($this,'inputHoraI'));
            $crud->callback_edit_field('hora_final', array($this, 'inputHoraF'));
            $crud->callback_add_field('hora_final',array($this,'inputHoraF'));
            $crud->unset_print();
            $crud->unset_export();
            $crud->unset_read();
            $crud->set_crud_url_path(site_url('agendaControlador/index'));

            $output = $crud->render();
            $this->mostrar($data, $output);
        } catch (Exception $e) {
            show_error($e->getMessage() . ' --- ' . $e->getTraceAsString());
        }
    }

    function cargarMedico() {
        $session = $this->session->all_userdata();
            $id_medico=$session['medico_id'];
            return '<input style="visibility:hidden;" type="text" maxlength="50" value="'.$id_medico.'" name="id_medico" style="width:400px"/>';
       }
       function inputDia() {
            return '<select name="dia">
  <option value="lunes" selected="selected">lunes</option>
  <option value="martes">martes</option>
  <option value="miercoles">miercoles</option>
  <option value="jueves">jueves</option>
  <option value="viernes">viernes</option>
  <option value="sabado">sabado</option>
</select>';
       }
       function inputHoraI(){
           /*return '<select name="hora"><option value="6" selected="selected">6</option>
               <option value="7">7</option><option value="8">8</option><option value="9">9</option>
               <option value="10">10</option><option value="11">11</option><option value="12">12</option>
               <option value="13">13</option><option value="14">14</option><option value="15">15</option>
               <option value="16">16</option><option value="17">17</option><option value="18">18</option>
               </select>
               <input type="text" name="hora_inicial" value="'.  set_value('hora').':00:00"/>';*/
           return '<input type="text" name="hora_inicial" value="00:00:00"/>  HH:mm:ss';
       }
       function inputHoraF(){
           return'<input type="text" name="hora_final" value="00:00:00"/>  HH:mm:ss';
       }
}
?>