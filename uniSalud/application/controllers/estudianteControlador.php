<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class estudianteControlador extends CI_Controller {

    /*Constructor de la clase*/
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /*Funcion Principal del controlador*/
    public function index(){
        $this->set_session('mensaje', NULL);
        $this->mostrarEstudiantes();
    }
    
    /*Funcion Encargada de cargar la tabla donde se muestran los estudiantes con su respectiva paginacion y posibles acciones*/
    public function mostrarEstudiantes() {
        //Definicion de la interface
        $this->load->library('pagination');
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/contentEstudiantes';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Estudiantes";
        $estudiantes = $this->estudianteModelo->obtenerEstudiantes();
        if ($estudiantes != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();
            //numero de items por pagina
            $opciones['per_page'] = 5;
            //linck de la paginacion
            $opciones['base_url'] = base_url() . '/estudianteControlador/mostrarEstudiantes/';
            //numero total de tuplas en la base de datos
            $opciones['total_rows'] = $estudiantes->num_rows();
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
            $estudiantes = $this->estudianteModelo->obtenerEstudiantes($opciones['per_page'], $this->uri->segment(3));
            //carga de datos del resultado de la consulta
            $data['estudiantes'] = $estudiantes;
            //creacion de los linck de la paginacion
            $data['paginacion'] = $this->pagination->create_links();
            //FIN_PAGINACION...
        } else {
            $data['programas'] = NULL;
        }
        $this->load->view('plantilla', $data);
    }
    
    public function buscarEstudiante(){
        $this->load->library('pagination');
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/contentEstudiantes';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Programas de Salud";
        if(isset($_POST['id_estudiante'])&& isset($_POST['primer_nombre']) && isset($_POST['primer_apellido']) && isset($_POST['identificacion'])){
            $filtro['id_estudiante']=$_POST['id_estudiante'];
            $filtro['primer_nombre']=$_POST['primer_nombre'];
            $filtro['primer_apellido']=$_POST['primer_apellido'];
            $filtro['identificacion']=$_POST['identificacion'];
            $this->set_session('filtro',$filtro);
        }else{
               $session=$this->get_session();
               $filtro=$session['filtro'];
        }
        $respuesta = $this->estudianteModelo->buscarFiltradoEstudiante($filtro);
        if ($respuesta != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();
            //numero de items por pagina
            $opciones['per_page'] = 5;
            //linck de la paginacion
            $opciones['base_url'] = base_url() . 'estudianteControlador/buscarEstudiante/';
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
            $respuesta = $this->estudianteModelo->buscarFiltradoEstudiante($filtro,$opciones['per_page'], $this->uri->segment(3));
            //carga de datos del resultado de la consulta
            $data['estudiantes'] = $respuesta;
            //creacion de los linck de la paginacion
            $data['paginacion'] = $this->pagination->create_links();
            //FIN_PAGINACION...
            } else {
                $data['estudiantes'] = NULL;
            }
        $this->load->view('plantilla', $data);
}

/*Funcion encargada de validar todosl los campos que son ingresados mediante los formularios de ingreso o edicion,
 * considerando unas reglas predefinidas para cada campo.
 */
    public function validar() {
        $this->load->library('form_validation');
        $config = array(
            array(
                'field' => 'costo',
                'label' => 'Costo',
                'rules' => 'trim|required|numeric|xss_clean'
            ),
            array(
                'field' => 'tipo_servicio',
                'label' => 'Tipo De Servicio',
                'rules' => 'trim|required|xss_clean'
            ),
            array(
                'field' => 'actividad',
                'label' => 'Actividad',
                'rules' => 'trim|required|xss_clean'
            )
        );

        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('required', 'El campo %s es Obligatorio');
        $this->form_validation->set_message('trim', 'Caracteres Invalidos');
        $this->form_validation->set_message('numeric', 'El campo %s debe ser numerico');
        return $this->form_validation->run();
    }
    //funciones para acceder y modificar las variables de session
    public function set_session($var,$cont=NULL){
        $this->session->set_userdata($var, $cont);
    }
    public function get_session(){
        return $this->session->all_userdata();
    }
}
?>