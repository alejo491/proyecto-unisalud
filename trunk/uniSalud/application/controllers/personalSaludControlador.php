<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class personalSaludControlador extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    public function  index(){
        $this->session->set_userdata('mensaje', NULL);
        $this->mostrarPersonalSalud();
    }
    public function mostrarPersonalSalud() {
        //Definicion de la interface
        $this->load->library('pagination');
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/contentPersonalMedico';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Programas de Salud";
        $personal = $this->personalSaludModelo->obtenerPersonalSalud();
        if ($personal != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();
            //numero de items por pagina
            $opciones['per_page'] = 5;
            //linck de la paginacion
            $opciones['base_url'] = base_url() . '/personalSaludControlador/mostrarPersonalSalud';
            //numero total de tuplas en la base de datos
            $opciones['total_rows'] = $personal->num_rows();
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
            $personal = $this->personalSaludModelo->obtenerPersonalSalud($opciones['per_page'], $this->uri->segment(3));
            //carga de datos del resultado de la consulta
            $data['personal'] = $personal;
            //creacion de los linck de la paginacion
            $data['paginacion'] = $this->pagination->create_links();
            //FIN_PAGINACION...
        } else {
            $data['personal'] = NULL;
        }
        $this->load->view('plantilla', $data);
    }

    public function agregarPersonalSalud() {
        //definicion de la interface...
        $this->session->set_userdata('mensaje', NULL);
        $this->load->model('consultorioModelo');
        $data['consultorios']=$this->consultorioModelo->obtenerConsultorios();
        $data['programas']=$this->programaSaludModelo->obtenerProgramas();
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/contentRegistrarPersonalSalud';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Agregar Personal de Salud";

        $this->load->view('plantilla', $data);
    }

    public function aniadirDatos() {
        $this->load->library('form_validation');
        if ($_POST) {
            if ($this->validar() == FALSE) {
                $data['header'] = 'includes/header';
                $data['menu'] = 'personal/menu';
                $data['topcontent'] = 'estandar/topcontent';
                $data['content'] = 'personal/contentRegistrarPersonalSalud';
                $data['footerMenu'] = 'personal/footerMenu';
                $data['title'] = "Agregar Personal de Salud";
                $this->load->model('consultorioModelo');
                $data['consultorios']=$this->consultorioModelo->obtenerConsultorios();
                $this->load->view('plantilla', $data);
            } else {
                $personal['primer_nombre'] = $_POST['primer_nombre'];
                $personal['segundo_nombre'] = $_POST['segundo_nombre'];
                $personal['primer_apellido'] = $_POST['primer_apellido'];
                $personal['segundo_apellido'] = $_POST['segundo_apellido'];
                $personal['tipo_identificacion'] = $_POST['tipo_identificacion'];
                $personal['identificacion'] = $_POST['identificacion'];
                $personal['numero_tarjeta'] = $_POST['numero_tarjeta'];
                $personal['especialidad'] = $_POST['especialidad'];
                $personal['id_consultorio'] = $_POST['consultorio'];
                $personal['id_programasalud']=$_POST['id_programasalud'];
                
                $id = $this->personalSaludModelo->ingresarPersonalSalud($personal);
                if ($id) {
                    $this->session->set_userdata('mensaje', 'Personal Ingresado Con Exito');
                    $this->session->set_userdata('exito', TRUE);
                } else {
                    $this->session->set_userdata('mensaje', 'Fallo al Ingresar el Personal');
                    $this->session->set_userdata('exito', FALSE);
                }
                redirect('personalSaludControlador/mostrarPersonalSalud');
            }
        }
    }

    public function actualizarPersonalSalud() {
        $this->session->set_userdata('mensaje', NULL);
        $this->load->model('consultorioModelo');
        $id = $_POST['id_personalsalud'];
        $data['consultorios']=$this->consultorioModelo->obtenerConsultorios();
        $data['personal'] = $this->personalSaludModelo->buscarPersonal($id);
        $data['programas']=$this->programaSaludModelo->obtenerProgramas();
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/editarPersonalSalud';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Editar Personal Salud";
        $this->load->view('plantilla', $data);
    }

    public function editarPersonalSalud() {
        if ($_POST) {
            if ($this->validar() == FALSE) {
                $id = $_POST['id_programasalud'];
                $data['personal'] = $this->personalSaludModelo->buscarPersonal($id);
                $data['header'] = 'includes/header';
                $data['menu'] = 'personal/menu';
                $data['topcontent'] = 'estandar/topcontent';
                $data['content'] = 'personal/editarPersonalSalud';
                $data['footerMenu'] = 'personal/footerMenu';
                $data['title'] = "Editar Personal Salud";
                $this->load->view('plantilla', $data);
            } else {
                $datos['id_personalsalud']=$_POST['id_personalsalud'];
                $datos['primer_nombre'] = $_POST['primer_nombre'];
                $datos['segundo_nombre'] = $_POST['segundo_nombre'];
                $datos['primer_apellido'] = $_POST['primer_apellido'];
                $datos['segundo_apellido'] = $_POST['segundo_apellido'];
                $datos['tipo_identificacion'] = $_POST['tipo_identificacion'];
                $datos['identificacion'] = $_POST['identificacion'];
                $datos['numero_tarjeta'] = $_POST['numero_tarjeta'];
                $datos['especialidad'] = $_POST['especialidad'];
                $datos['id_consultorio'] = $_POST['consultorio'];
                
                $respuesta = $this->personalSaludModelo->editarPersonalSalud($datos);
                if ($respuesta) {
                    $this->session->set_userdata('mensaje', 'Personal de Salud Actualizado Con Exito');
                    $this->session->set_userdata('exito', TRUE);
                } else {
                    $this->session->set_userdata('mensaje', 'Fallo al Actualizar el Personal de Salud');
                    $this->session->set_userdata('exito', FALSE);
                }
                redirect('personalSaludControlador/mostrarPersonalSalud');
            }
        }
    }

    public function eliminarPersonalSalud() {
        $this->session->set_userdata('mensaje', NULL);
        $this->load->model('personalSaludModelo');
        $id = $this->uri->segment(3);
        $respuesta = $this->personalSaludModelo->eliminarPersonalSalud($id);
        if ($respuesta) {
            $this->session->set_userdata('mensaje', 'Personal Salud Eliminado Con Exito');
            $this->session->set_userdata('exito', TRUE);
        } else {
            $this->session->set_userdata('mensaje', 'Fallo al Eliminar el Personal de Salud');
            $this->session->set_userdata('exito', FALSE);
        }
        redirect('personalSaludControlador/mostrarPersonalSalud');
    }
    public function buscarPersonalSalud(){
        //Definicion de la interface
        $this->load->library('pagination');
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/contentPersonalMedico';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Programas de Salud";
        if(isset($_POST['primer_nombre'])&&isset($_POST['primer_apellido'])&&isset($_POST['identificacion'])&&isset($_POST['especialidad'])){
            $filtro['primer_nombre']=$_POST['primer_nombre'];
            $filtro['primer_apellido']=$_POST['primer_apellido'];
            $filtro['identificacion']=$_POST['identificacion'];
            $filtro['especialidad']=$_POST['especialidad'];
            $this->session->set_userdata('filtro',$filtro);
        }
        else{
            $session=$this->session->all_userdata();
            $filtro=$session['filtro'];
        }
        $respuesta = $this->personalSaludModelo->buscarFiltradoPersonalSalud($filtro);
        if ($respuesta != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();
            //numero de items por pagina
            $opciones['per_page'] = 5;
            //linck de la paginacion
            $opciones['base_url'] = base_url() . 'personalSaludControlador/buscarPersonalSalud/';
            //numero total de tuplas en la base de datos
            $opciones['total_rows'] = $respuesta->num_rows();
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
            $respuesta = $this->personalSaludModelo->buscarFiltradoPersonalSalud($filtro,$opciones['per_page'], $this->uri->segment(3));
            //carga de datos del resultado de la consulta
            $data['personal'] = $respuesta;
            //creacion de los linck de la paginacion
            $data['paginacion'] = $this->pagination->create_links();
            //FIN_PAGINACION...
        } else {
            $data['personal'] = NULL;
        }
        $this->load->view('plantilla', $data);
    }
    public function validar() {
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'primer_nombre',
                'label' => 'Primer Nombre',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'segundo_nombre',
                'label' => 'Segundo Nombre',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'primer_apellido',
                'label' => 'Primer Apellido',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'segundo_apellido',
                'label' => 'Segundo Apellido',
                'rules' => 'trim|xss_clean'
            ),
            array(
                'field' => 'tipo_identificacion',
                'label' => 'Tipo de Indentificacion',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'identificacion',
                'label' => 'Numero de Identificacion',
                'rules' => 'trim|required|xss_clean|numeric'
            ),
            array(
                'field' => 'numero_tarjeta',
                'label' => 'Numero de Tarjeta Profecional',
                'rules' => 'trim|required|xss_clean|numeric'
            ),
            array(
                'field' => 'especialidad',
                'label' => 'Especialidad',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'consultorio',
                'label' => 'Consultorio',
                'rules' => 'trim|required|xss_clean|numeric'
            ),
        );

        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('required', 'El campo %s es Obligatorio');
        $this->form_validation->set_message('trim', 'Caracteres Invalidos');
        $this->form_validation->set_message('numeric', 'El campo %s debe ser numerico');
        return $this->form_validation->run();
    }

}

?>