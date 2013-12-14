<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class consultorioControlador extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        $this->session->set_userdata('mensaje', NULL);
        $this->mostrarConsultorios();
    }

    public function mostrarConsultorios() {
        //Definicion de la interface
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/contentConsultorio';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Consultorios";
        $consultorios = $this->consultorioModelo->obtenerConsultorios();
        if ($consultorios != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();
            //numero de items por pagina
            $opciones['per_page'] = 5;
            //linck de la paginacion
            $opciones['base_url'] = base_url() . '/consultorioControlador/mostrarConsultorios';
            //numero total de tuplas en la base de datos
            $opciones['total_rows'] = $consultorios->num_rows();
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
            $consultorios = $this->consultorioModelo->obtenerConsultorios($opciones['per_page'], $this->uri->segment(3));
            //carga de datos del resultado de la consulta
            $data['consultorios'] = $consultorios;
            //creacion de los linck de la paginacion
            $data['paginacion'] = $this->pagination->create_links();
            //FIN_PAGINACION...
        } else {
            $data['personal'] = NULL;
        }
        $this->load->view('plantilla', $data);
    }

    public function agregarConsultorio() {
        //definicion de la interface...
        $this->session->set_userdata('mensaje', NULL);
        $this->load->model('consultorioModelo');
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/contentRegistrarConsultorio';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Agregar Consultorio";

        $this->load->view('plantilla', $data);
    }

    public function aniadirDatos() {
        $this->load->library('form_validation');
        if ($_POST) {
            if ($this->validar() == FALSE) {
                $data['header'] = 'includes/header';
                $data['menu'] = 'personal/menu';
                $data['topcontent'] = 'estandar/topcontent';
                $data['content'] = 'personal/contentRegistrarConsultorio';
                $data['footerMenu'] = 'personal/footerMenu';
                $data['title'] = "Agregar Consultorio";
                $this->load->view('plantilla', $data);
            } else {
                $consultorio['numero_consultorio'] = $_POST['numero_consultorio'];
                $consultorio['descripcion'] = $_POST['descripcion'];
                $id = $this->consultorioModelo->ingresarConsultorio($consultorio);
                if ($id) {
                    $this->session->set_userdata('mensaje', 'Consultorio Ingresado Con Exito');
                    $this->session->set_userdata('exito', TRUE);
                } else {
                    $this->session->set_userdata('mensaje', 'Fallo al Ingresar el Consultorio');
                    $this->session->set_userdata('exito', FALSE);
                }
                redirect('consultorioControlador/mostrarConsultorios');
            }
        }
    }

    public function buscarConsultorio() {
        $this->session->set_userdata('mensaje', NULL);
        $id = $_POST['id_consultorio'];
        $data['consultorio'] = $this->consultorioModelo->buscarConsultorio($id);
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/editarConsultorio';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Editar Consultorio";
        $this->load->view('plantilla', $data);
    }

    public function editarConsultorio() {
        if ($_POST) {
            if ($this->validar() == FALSE) {
                $id = $_POST['id_consultorio'];
                $data['consultorio'] = $this->consultorioModelo->buscarConsultorio($id);
                $data['header'] = 'includes/header';
                $data['header'] = 'includes/header';
                $data['menu'] = 'personal/menu';
                $data['topcontent'] = 'estandar/topcontent';
                $data['content'] = 'personal/editarConsultorio';
                $data['footerMenu'] = 'personal/footerMenu';
                $data['title'] = "Editar Consultorio";
                $this->load->view('plantilla', $data);
            } else {
                $data['id_consultorio'] = $_POST['id_consultorio'];
                $data['numero_consultorio'] = $_POST['numero_consultorio'];
                $data['descripcion'] = $_POST['descripcion'];
                $respuesta = $this->consultorioModelo->editarConsultorio($data);
                if ($respuesta) {
                    $this->session->set_userdata('mensaje', 'Consultorio Actualizado Con Exito');
                    $this->session->set_userdata('exito', TRUE);
                } else {
                    $this->session->set_userdata('mensaje', 'Fallo al Actualizar el Consultorio');
                    $this->session->set_userdata('exito', FALSE);
                }
                redirect('consultorioControlador/mostrarConsultorios');
            }
        }
    }

    public function eliminarConsultorio() {
        $this->session->set_userdata('mensaje', NULL);
        $id = $this->uri->segment(3);
        if($this->validar_eliminar($id)){
        
            $respuesta = $this->consultorioModelo->eliminarConsultorio($id);
            if ($respuesta) {
                $this->session->set_userdata('mensaje', 'Consultorio Eliminado Con Exito');
                $this->session->set_userdata('exito', TRUE);
            } else {
                $this->session->set_userdata('mensaje', 'Fallo al Eliminar el Consultorio');
                $this->session->set_userdata('exito', FALSE);
            }
        }else{
                $this->session->set_userdata('mensaje', 'Fallo al Eliminar, hay personal de salud que atiende en este consultorio');
                $this->session->set_userdata('exito', FALSE);
            }
        redirect('consultorioControlador/mostrarConsultorios');
    }

    public function filtrarConsultorio() {
        //Definicion de la interface
        $this->load->library('pagination');
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/contentConsultorio';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Consultorios";
        if (isset($_POST['numero_consultorio']) && isset($_POST['descripcion'])) {
            $filtro['numero_consultorio'] = $_POST['numero_consultorio'];
            $filtro['descripcion'] = $_POST['descripcion'];
            $this->session->set_userdata('filtro', $filtro);
        } else {
            $session = $this->session->all_userdata();
            $filtro = $session['filtro'];
        }
        $respuesta = $this->consultorioModelo->buscarFiltradoConsultorio($filtro);
        if ($respuesta != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();
            //numero de items por pagina
            $opciones['per_page'] = 5;
            //linck de la paginacion
            $opciones['base_url'] = base_url() . 'consultorioControlador/filtrarConsultorio/';
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
            $respuesta = $this->consultorioModelo->buscarFiltradoConsultorio($filtro, $opciones['per_page'], $this->uri->segment(3));
            //carga de datos del resultado de la consulta
            $data['consultorios'] = $respuesta;
            //creacion de los linck de la paginacion
            $data['paginacion'] = $this->pagination->create_links();
            //FIN_PAGINACION...
        } else {
            $data['consultorios'] = NULL;
        }
        $this->load->view('plantilla', $data);
    }

    public function validar() {
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'numero_consultorio',
                'label' => 'Numero de Consultorio',
                'rules' => 'trim|required|numeric| xss_clean'
            ),
            array(
                'field' => 'descripcion',
                'label' => 'Descripcion',
                'rules' => 'trim||required|xss_clean'
            )
        );

        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('required', 'El campo %s es Obligatorio');
        $this->form_validation->set_message('trim', 'Caracteres Invalidos');
        $this->form_validation->set_message('numeric', 'El campo %s debe ser numerico');
        $this->form_validation->set_message('is_unique', 'Esta identificacion ya esta registrada');
        return $this->form_validation->run();
    }
    
    function validar_eliminar($str){
        
        return $this->consultorioModelo->validar_e($str);
    }

}

?>
