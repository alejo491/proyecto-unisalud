<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class consultorioControlador extends CI_Controller {

    /*Constructor de la clase*/
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    /*Funcion Principal del controlador*/
    public function index() {
        $this->set_session('mensaje', NULL);
        $this->mostrarConsultorios();
    }
    
    /*Funcion Encargada de cargar la tabla donde se muestran los consultorios con su respectiva paginacion y posibles acciones*/
    public function mostrarConsultorios() {
        //Definicion de la interface
        $data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentConsultorio';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Consultorios";
        $consultorios = $this->consultorioModelo->obtenerConsultorios();
        if ($consultorios != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();$opciones['per_page'] = 5;$opciones['base_url'] = base_url() . '/consultorioControlador/mostrarConsultorios';$opciones['total_rows'] = $consultorios->num_rows();$opciones['uri_segment'] = 3;$opciones['num_links'] = 2; $opciones['first_link'] = 'Primero';$opciones['last_link'] = 'Ultimo';$opciones['full_tag_open'] = '<h3>';$opciones['full_tag_close'] = '</h3>';
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
    
    /*Funcion que se encarga de cargar los datos necesarios para cargar el formulario de registro de un consultorio*/
    public function agregarConsultorio() {
        //definicion de la interface...
        $this->set_session('mensaje', NULL);$this->load->model('consultorioModelo');$data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentRegistrarConsultorio';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Agregar Consultorio";
        $this->load->view('plantilla', $data);
    }

    /*Funcion que obtiene y valida los datos obtenidos del formulario por medio del metodo
     * POST, seguido a esto se vale del modelo para ingresar los datos respectivos en la Base de Datos
     */
    public function aniadirDatos() {
        $this->load->library('form_validation');
        if ($_POST) {
            if ($this->validar() == FALSE) {
                $data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentRegistrarConsultorio';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Agregar Consultorio";
                $this->load->view('plantilla', $data);
            } else {
                $consultorio['numero_consultorio'] = $_POST['numero_consultorio'];
                $consultorio['descripcion'] = $_POST['descripcion'];
                $id = $this->consultorioModelo->ingresarConsultorio($consultorio);
                if ($id) {
                    $this->set_session('mensaje', 'Consultorio Ingresado Con Exito');$this->set_session('exito', TRUE);
                } else {
                    $this->set_session('mensaje', 'Fallo al Ingresar el Consultorio');$this->set_session('exito', FALSE);
                }
                redirect('consultorioControlador/mostrarConsultorios');
            }
        }
    }

    /*Funcion que carga segun el item seleccionado en la interfaz de usuario, los
     * datos correspondientes al mismo, en un formulario donde se podran editar
     */
    public function buscarConsultorio() {
        $this->set_session('mensaje', NULL); $id = $_POST['id_consultorio'];
        $data['consultorio'] = $this->consultorioModelo->buscarConsultorio($id);
        $data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/editarConsultorio';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Editar Consultorio";
        $this->load->view('plantilla', $data);
    }

    /*Funcion que obtiene y valida los datos obtenidos del formulario por medio del metodo
     * POST, seguido a esto se vale del modelo para editar los datos respectivos en la Base de Datos
     */
    public function editarConsultorio() {
        if ($_POST) {
            if ($this->validar() == FALSE) {
                $id = $_POST['id_consultorio'];
                $data['consultorio'] = $this->consultorioModelo->buscarConsultorio($id);
                $data['header'] = 'includes/header';$data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/editarConsultorio';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Editar Consultorio";
                $this->load->view('plantilla', $data);
            } else {
                $data['id_consultorio'] = $_POST['id_consultorio'];$data['numero_consultorio'] = $_POST['numero_consultorio'];$data['descripcion'] = $_POST['descripcion'];
                $respuesta = $this->consultorioModelo->editarConsultorio($data);
                if ($respuesta) {
                    $this->set_session('mensaje', 'Consultorio Actualizado Con Exito');$this->set_session('exito', TRUE);
                } else {
                    $this->set_session('mensaje', 'Fallo al Actualizar el Consultorio');$this->set_session('exito', FALSE);
                }
                redirect('consultorioControlador/mostrarConsultorios');
            }
        }
    }

    /*Funcion que despues de confirmar la eliminacion de una tupla, realiza el eliminado de la misma en la base
 * de datos valiendose del modelo.
 */
    public function eliminarConsultorio() {
        $this->set_session('mensaje', NULL);
        $id = $this->uri->segment(3);
        if($this->validar_eliminar($id)){
        
            $respuesta = $this->consultorioModelo->eliminarConsultorio($id);
            if ($respuesta) {
                $this->set_session('mensaje', 'Consultorio Eliminado Con Exito'); $this->set_session('exito', TRUE);
            } else {
                $this->set_session('mensaje', 'Fallo al Eliminar el Consultorio');$this->set_session('exito', FALSE);
            }
        }else{
                $this->set_session('mensaje', 'Fallo al Eliminar, hay personal de salud que atiende en este consultorio'); $this->set_session('exito', FALSE);
            }
        redirect('consultorioControlador/mostrarConsultorios');
    }

    /*Funcion que filtra y carga las tuplas que se muestran en la interfaz de usuario, segun uno o varios criterios de busqueda */
    public function filtrarConsultorio() {
        //Definicion de la interface
        $this->load->library('pagination');
        $data['header'] = 'includes/header';$data['menu'] = 'personal/menu'; $data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentConsultorio'; $data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Consultorios";
        if (isset($_POST['numero_consultorio']) && isset($_POST['descripcion'])) {
            $filtro['numero_consultorio'] = $_POST['numero_consultorio'];$filtro['descripcion'] = $_POST['descripcion'];
            $this->set_session('filtro', $filtro);
        } else {
            $session = $this->get_session();
            $filtro = $session['filtro'];
        }
        $respuesta = $this->consultorioModelo->buscarFiltradoConsultorio($filtro);
        if ($respuesta != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();$opciones['per_page'] = 5;$opciones['base_url'] = base_url() . 'consultorioControlador/filtrarConsultorio/';$opciones['total_rows'] = $respuesta->num_rows();$opciones['uri_segment'] = 3;$opciones['num_links'] = 2;$opciones['first_link'] = 'Primero';$opciones['last_link'] = 'Ultimo';$opciones['full_tag_open'] = '<h3>';$opciones['full_tag_close'] = '</h3>';
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

    /*Funcion encargada de validar todosl los campos que son ingresados mediante los formularios de ingreso o edicion,
 * considerando unas reglas predefinidas para cada campo.
 */
    public function validar() {
        $this->load->library('form_validation');
        $config = array(
            array('field' => 'numero_consultorio','label' => 'Numero de Consultorio','rules' => 'trim|required| xss_clean'),
            array('field' => 'descripcion','label' => 'Descripcion','rules' => 'trim||required|xss_clean')
        );

        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('required', 'El campo %s es Obligatorio');$this->form_validation->set_message('trim', 'Caracteres Invalidos');$this->form_validation->set_message('numeric', 'El campo %s debe ser numerico');$this->form_validation->set_message('is_unique', 'Esta identificacion ya esta registrada');
        return $this->form_validation->run();
    }
    
    function validar_eliminar($str){
        
        return $this->consultorioModelo->validar_e($str);
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
