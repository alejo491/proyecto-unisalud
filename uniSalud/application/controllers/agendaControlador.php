<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class agendaControlador extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function index(){
        $this->session->set_userdata('mensaje', NULL);
        $this->buscarDatos();
    }
    function buscarDatos(){
        if(isset($_POST['id_personalsalud'])){
            $id = $_POST['id_personalsalud'];
            $this->session->set_userdata('id_personalsalud',$id);
        }else{
            $session=$this->session->all_userdata();
            $id=$session['id_personalsalud'];
        }
        $data['personal'] = $this->personalSaludModelo->buscarPersonal($id);
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/contentHorarioAtencion';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Horario de Atencion";
        $agenda= $this->agendaModelo->obtenerAgenda($id);
        if ($agenda != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();
            //numero de items por pagina
            $opciones['per_page'] = 5;
            //linck de la paginacion
            $opciones['base_url'] = base_url() . '/agendaControlador/buscarDatos';
            //numero total de tuplas en la base de datos
            $opciones['total_rows'] = $agenda->num_rows();
            //segmento que se usara para pasar los datos de la paginacion
            $opciones['uri_segment'] = 3;
            //numero de links mostrados en la paginacion antes y despues de la pagina actual
            $opciones['num_links'] = 2;
            //nombre de la primera y ultima pagina
            $opciones['first_link'] = 'Primero';
            $opciones['last_link'] = 'Ultimo';
            $opciones['full_tag_open'] = '<h3>';
            $opciones['full_tag_close'] = '</h3>';
            //inicializacion de la paginacion
            $this->pagination->initialize($opciones);
            //consulta a la base de datos segun paginacion
            $agenda = $this->agendaModelo->obtenerAgenda($id,$opciones['per_page'], $this->uri->segment(3));
            //carga de datos del resultado de la consulta
            $data['agenda'] = $agenda;
            //creacion de los linck de la paginacion
            $data['paginacion'] = $this->pagination->create_links();
            //FIN_PAGINACION...
        } else {
            $data['agenda'] = NULL;
        }
        $this->load->view('plantilla', $data);
    }
    public function agregarHorarioAtencion() {
        //definicion de la interface...
        $this->session->set_userdata('mensaje', NULL);
        $data['id_personalsalud']=$_POST['id_personalsalud'];
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/contentRegistrarHorarioAtencion';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Agregar Horario de Atencion";
        $this->load->view('plantilla', $data);
    }

    public function aniadirDatos() {
        $this->load->library('form_validation');
        if ($_POST) {
            if ($this->validar() == FALSE) {
                $data['id_personalsalud']=$_POST['id_personalsalud'];
                $data['header'] = 'includes/header';
                $data['menu'] = 'personal/menu';
                $data['topcontent'] = 'estandar/topcontent';
                $data['content'] = 'personal/contentRegistrarHorarioAtencion';
                $data['footerMenu'] = 'personal/footerMenu';
                $data['title'] = "Horario de Atencion";
                $this->load->view('plantilla', $data);
            } else {
                $horario['id_personalsalud'] = $_POST['id_personalsalud'];
                $horario['hora_inicial'] =$_POST['hora_i'].':'.$_POST['min_i'].':'.$_POST['seg_i'];
                $horario['hora_final'] =$_POST['hora_f'].':'.$_POST['min_f'].':'.$_POST['seg_f'];
                $horario['dia'] = $_POST['dia'];
                
                $id = $this->agendaModelo->ingresarHorarioAgenda($horario);
                if ($id) {
                    $this->session->set_userdata('mensaje', 'Horario Ingresado Con Exito');
                    $this->session->set_userdata('exito', TRUE);
                } else {
                    $this->session->set_userdata('mensaje', 'Fallo al Ingresar el Horario');
                    $this->session->set_userdata('exito', FALSE);
                }
                //$this->buscarDatos();
                redirect('agendaControlador/buscarDatos');
            }
        }
    }

    public function buscarHorarioPersonal() {
        $this->session->set_userdata('mensaje', NULL);
        $id = $_POST['id_agenda'];
        $data['horario']=$this->agendaModelo->obtenerHorarioAtencion($id);
        $str='';
        $i=0;
        while(strcmp($data['horario']->hora_inicial[$i],":")!=0 && $i<strlen($data['horario']->hora_inicial)){
            $str=$str.$data['horario']->hora_inicial[$i];
            $i++;
        }
        $i++;
        $data['hora_i']=(int)$str;
        $str='';
        while(strcmp($data['horario']->hora_inicial[$i],":")!=0 && $i<strlen($data['horario']->hora_inicial)){
            $str=$str.$data['horario']->hora_inicial[$i];
            $i++;
        }
        $i++;
        $data['min_i']=(int)$str;
        $str='';
        while($i<strlen($data['horario']->hora_inicial)){
            $str=$str.$data['horario']->hora_inicial[$i];
            $i++;
        }
        $i++;
        $data['seg_i']=(int)$str;
        $i=0;
        $str='';
        while(strcmp($data['horario']->hora_final[$i],":")!=0 && $i<strlen($data['horario']->hora_final)){
            $str=$str.$data['horario']->hora_final[$i];
            $i++;
        }
        $i++;
        $data['hora_f']=(int)$str;
        $str='';
        while(strcmp($data['horario']->hora_final[$i],":")!=0 && $i<strlen($data['horario']->hora_final)){
            $str=$str.$data['horario']->hora_final[$i];
            $i++;
        }
        $i++;
        $data['min_f']=(int)$str;
        $str='';
        while($i<strlen($data['horario']->hora_final)){
            $str=$str.$data['horario']->hora_final[$i];
            $i++;
        }
        $data['seg_f']=(int)$str;
        
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/editarHorarioAtencion';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Editar Horario de Atencion";
        $this->load->view('plantilla', $data);
    }

    public function editarHorarioAtencion() {
        $this->load->library('form_validation');
        if ($_POST) {
            if ($this->validar() == FALSE) {
                $data['id_personalsalud']=$_POST['id_personalsalud'];
                $data['header'] = 'includes/header';
                $data['menu'] = 'personal/menu';
                $data['topcontent'] = 'estandar/topcontent';
                $data['content'] = 'personal/contentRegistrarHorarioAtencion';
                $data['footerMenu'] = 'personal/footerMenu';
                $data['title'] = "Agregar Horario Atencion";
                $this->load->view('plantilla', $data);
            } else {
                $data['id_agenda'] = $_POST['id_agenda'];
                $data['id_personalsalud'] = $_POST['id_personalsalud'];
                $data['hora_inicial'] =$_POST['hora_i'].':'.$_POST['min_i'].':'.$_POST['seg_i'];
                $data['hora_final'] =$_POST['hora_f'].':'.$_POST['min_f'].':'.$_POST['seg_f'];
                $data['dia'] = $_POST['dia'];
                
                $respuesta = $this->agendaModelo->actualizarHorarioAtencion($data);
                if ($respuesta) {
                    $this->session->set_userdata('mensaje', 'Horario Actualizado Con Exito');
                    $this->session->set_userdata('exito', TRUE);
                } else {
                    $this->session->set_userdata('mensaje', 'Fallo al Actualizar el Horario');
                    $this->session->set_userdata('exito', FALSE);
                }
                redirect('agendaControlador/buscarDatos');
            }
        }
    }

    public function eliminarHorarioAtencion() {
        $this->session->set_userdata('mensaje', NULL);
        $id = $this->uri->segment(3);
        
            $respuesta = $this->agendaModelo->eliminarHorario($id);
            if ($respuesta) {
                $this->session->set_userdata('mensaje', 'Horario Eliminado Con Exito');
                $this->session->set_userdata('exito', TRUE);
            } else {
                $this->session->set_userdata('mensaje', 'Fallo al Eliminar el Horario');
                $this->session->set_userdata('exito', FALSE);
            }
        redirect('AgendaControlador/buscarDatos');
    }

    public function validar() {
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'dia',
                'label' => 'Dia',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'hora_i',
                'label' => 'Hora Inicial',
                'rules' => 'trim|xss_clean|required'
            ),
            array(
                'field' => 'hora_f',
                'label' => 'Hora Final',
                'rules' => 'trim|required|xss_clean'
            )
        );

        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('required', 'El campo %s es Obligatorio');
        $this->form_validation->set_message('trim', 'Caracteres Invalidos');
        return $this->form_validation->run();
    }
}

?>