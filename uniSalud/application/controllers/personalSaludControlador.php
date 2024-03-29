<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class personalSaludControlador extends CI_Controller {

    /*Constructor de la clase*/
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /*Funcion Principal del controlador*/
    public function  index(){
        $this->set_session('mensaje', NULL);
        $this->mostrarPersonalSalud();
    }
    
    /*Funcion Encargada de cargar la tabla donde se muestran el personal de salud con su respectiva paginacion y posibles acciones*/
    public function mostrarPersonalSalud() {
        //Definicion de la interface
        $data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentPersonalMedico';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Programas de Salud";
        $personal = $this->personalSaludModelo->obtenerPersonalSalud();
        if ($personal != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();$opciones['per_page'] = 5;$opciones['base_url'] = base_url() . '/personalSaludControlador/mostrarPersonalSalud';$opciones['total_rows'] = $personal->num_rows();$opciones['uri_segment'] = 3;$opciones['num_links'] = 2;$opciones['first_link'] = 'Primero';$opciones['last_link'] = 'Ultimo';$opciones['full_tag_open'] = '<h3>';$opciones['full_tag_close'] = '</h3>';
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
/*Funcion que se encarga de cargar los datos necesarios para cargar el formulario de registro de un miembro del personal de salud*/
    public function agregarPersonalSalud() {
        //definicion de la interface...
        $this->set_session('mensaje', NULL);
        $this->load->model('consultorioModelo');
        $data['consultorios']=$this->consultorioModelo->obtenerConsultorios();
        $data['programas']=$this->programaSaludModelo->obtenerProgramas();
        $data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentRegistrarPersonalSalud';$data['footerMenu'] = 'personal/footerMenu'; $data['title'] = "Agregar Personal de Salud";

        $this->load->view('plantilla', $data);
    }

    /*Funcion que obtiene y valida los datos obtenidos del formulario por medio del metodo
     * POST, seguido a esto se vale del modelo para ingresar los datos respectivos en la Base de Datos
     */
    public function aniadirDatos() {
        $this->load->library('form_validation');
        if ($_POST) {
            if ($this->validar() == FALSE) {
                $data['header'] = 'includes/header';$data['menu'] = 'personal/menu'; $data['topcontent'] = 'estandar/topcontent'; $data['content'] = 'personal/contentRegistrarPersonalSalud'; $data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Agregar Personal de Salud"; $this->load->model('consultorioModelo');
                $data['consultorios']=$this->consultorioModelo->obtenerConsultorios();
                $data['programas']=$this->programaSaludModelo->obtenerProgramas();
                $this->load->view('plantilla', $data);
            } else {
                $personal['primer_nombre'] = $_POST['primer_nombre'];$personal['segundo_nombre'] = $_POST['segundo_nombre'];$personal['primer_apellido'] = $_POST['primer_apellido'];$personal['segundo_apellido'] = $_POST['segundo_apellido'];$personal['tipo_identificacion'] = $_POST['tipo_identificacion'];$personal['identificacion'] = $_POST['identificacion'];$personal['numero_tarjeta'] = $_POST['numero_tarjeta'];$personal['especialidad'] = $_POST['especialidad'];$personal['id_consultorio'] = $_POST['consultorio'];
                if(isset($_POST['opcion'])){
                $pro=substr(implode(',', $this->input->post('opcion')), 0);
                }else{$pro=NULL;}
                $id = $this->personalSaludModelo->ingresarPersonalSalud($personal,$pro);
                
                if ($id) {
                    $this->set_session('mensaje', 'Personal Ingresado Con Exito'); $this->set_session('exito', TRUE);
                } else {
                    $this->set_session('mensaje', 'Fallo al Ingresar el Personal'); $this->set_session('exito', FALSE);
                }
                redirect('personalSaludControlador/mostrarPersonalSalud');
            }
        }
    }

    /*Funcion que carga segun el item seleccionado en la interfaz de usuario, los
     * datos correspondientes al mismo, en un formulario donde se podran editar
     */
    public function actualizarPersonalSalud() {
        $this->set_session('mensaje', NULL);
        $this->load->model('consultorioModelo');
        $id = $_POST['id_personalsalud'];
        $data['consultorios']=$this->consultorioModelo->obtenerConsultorios();
        $data['personal'] = $this->personalSaludModelo->buscarPersonal($id);
        $data['programas']=$this->programaSaludModelo->obtenerProgramas();
        $data['programas_personal']=$this->personalSaludModelo->programasPersonal($id);
        $data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent'; $data['content'] = 'personal/editarPersonalSalud'; $data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Editar Personal Salud";
        $this->load->view('plantilla', $data);
    }
    
    /*Funcion que obtiene y valida los datos obtenidos del formulario por medio del metodo
     * POST, seguido a esto se vale del modelo para editar los datos respectivos en la Base de Datos
     */
    public function editarPersonalSalud() {
        if ($_POST) {
            if ($this->validar_actualizar() == FALSE) {
                $id = $_POST['id_personalsalud'];
                $data['consultorios']=$this->consultorioModelo->obtenerConsultorios();
                $data['personal'] = $this->personalSaludModelo->buscarPersonal($id);
                $data['programas']=$this->programaSaludModelo->obtenerProgramas();
                $data['programas_personal']=$this->personalSaludModelo->programasPersonal($id);
                $data['header'] = 'includes/header'; $data['menu'] = 'personal/menu'; $data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/editarPersonalSalud';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Editar Personal Salud";
                $this->load->view('plantilla', $data);
            } else {
                $datos['id_personalsalud']=$_POST['id_personalsalud']; $datos['primer_nombre'] = $_POST['primer_nombre'];$datos['segundo_nombre'] = $_POST['segundo_nombre']; $datos['primer_apellido'] = $_POST['primer_apellido'];$datos['segundo_apellido'] = $_POST['segundo_apellido'];$datos['tipo_identificacion'] = $_POST['tipo_identificacion']; $datos['identificacion'] = $_POST['identificacion'];$datos['numero_tarjeta'] = $_POST['numero_tarjeta'];$datos['especialidad'] = $_POST['especialidad']; $datos['id_consultorio'] = $_POST['consultorio'];
                if(isset($_POST['opcion'])){
                $pro=substr(implode(',', $this->input->post('opcion')), 0);
                }else{
                    
                    $pro=NULL;
                }
                $respuesta = $this->personalSaludModelo->editarPersonalSalud($datos,$pro);
                
                if ($respuesta) {
                    $this->set_session('mensaje', 'Personal de Salud Actualizado Con Exito');$this->set_session('exito', TRUE);
                } else {
                    $this->set_session('mensaje', 'Fallo al Actualizar el Personal de Salud'); $this->set_session('exito', FALSE);
                }
                redirect('personalSaludControlador/mostrarPersonalSalud');
            }
        }
    }

    /*Funcion que despues de confirmar la eliminacion de una tupla, realiza el eliminado de la misma en la base
 * de datos valiendose del modelo.
 */
    public function eliminarPersonalSalud() {
        $this->set_session('mensaje', NULL);
        $this->load->model('personalSaludModelo');
        $id = $this->uri->segment(3);
        $confirmacion=$this->personalSaludModelo->verificar_citas($id);
        if($confirmacion){
            $respuesta = $this->personalSaludModelo->eliminarPersonalSalud($id);
            if ($respuesta) {
                $this->set_session('mensaje', 'Personal Salud Eliminado Con Exito'); $this->set_session('exito', TRUE);
            } else {
                $this->set_session('mensaje', 'Fallo al Eliminar el Personal de Salud');$this->set_session('exito', FALSE);
            }
        }else{
                $this->set_session('mensaje', 'Fallo al Eliminar el Personal de Salud, hay citas por atender');$this->set_session('exito', FALSE);
            
        }
        redirect('personalSaludControlador/mostrarPersonalSalud');
    }
    
    /*Funcion que filtra y carga las tuplas que se muestran en la interfaz de usuario, segun uno o varios criterios de busqueda */
    public function buscarPersonalSalud(){
        //Definicion de la interface
        $this->load->library('pagination');
        $data['header'] = 'includes/header'; $data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentPersonalMedico';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Programas de Salud";
        if(isset($_POST['primer_nombre'])&&isset($_POST['primer_apellido'])&&isset($_POST['identificacion'])&&isset($_POST['especialidad'])){
            $filtro['primer_nombre']=$_POST['primer_nombre'];$filtro['primer_apellido']=$_POST['primer_apellido'];$filtro['identificacion']=$_POST['identificacion'];$filtro['especialidad']=$_POST['especialidad'];
            $this->set_session('filtro',$filtro);
        }
        else{
            $session=$this->get_session();
            $filtro=$session['filtro'];
        }
        $respuesta = $this->personalSaludModelo->buscarFiltradoPersonalSalud($filtro);
        if ($respuesta != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();
            $opciones['per_page'] = 5; $opciones['base_url'] = base_url() . 'personalSaludControlador/buscarPersonalSalud/';$opciones['total_rows'] = $respuesta->num_rows();$opciones['uri_segment'] = 3;$opciones['num_links'] = 2;$opciones['first_link'] = 'Primero'; $opciones['last_link'] = 'Ultimo';$opciones['full_tag_open'] = '<h3>'; $opciones['full_tag_close'] = '</h3>';
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
    
    /*Funcion encargada de validar todosl los campos que son ingresados mediante los formularios de ingreso o edicion,
 * considerando unas reglas predefinidas para cada campo.
 */
    public function validar() {
        $this->load->library('form_validation');
        $config = array(
            array('field' => 'primer_nombre','label' => 'Primer Nombre','rules' => 'trim|required|xss_clean'),
            array('field' => 'segundo_nombre','label' => 'Segundo Nombre','rules' => 'trim|xss_clean' ),
            array('field' => 'primer_apellido','label' => 'Primer Apellido','rules' => 'trim|required|xss_clean'),
            array('field' => 'segundo_apellido','label' => 'Segundo Apellido','rules' => 'trim|xss_clean'),
            array('field' => 'tipo_identificacion','label' => 'Tipo de Indentificacion','rules' => 'trim|required|xss_clean'),
            array('field' => 'identificacion','label' => 'Numero de Identificacion','rules' => 'trim|required|xss_clean|numeric|is_unique[personalsalud.identificacion]'),
            array('field' => 'numero_tarjeta','label' => 'Numero de Tarjeta Profecional','rules' => 'trim|required|xss_clean|numeric'),
            array('field' => 'especialidad','label' => 'Especialidad','rules' => 'trim|required|xss_clean'),
            array('field' => 'consultorio','label' => 'Consultorio','rules' => 'trim|required|xss_clean|numeric'),
            array('field' => 'programa_salud','label' => 'Programa Salud','rules' => 'callback_isChecked'),
        );

        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('required', 'El campo %s es Obligatorio');$this->form_validation->set_message('trim', 'Caracteres Invalidos');$this->form_validation->set_message('numeric', 'El campo %s debe ser numerico');$this->form_validation->set_message('is_unique', 'Esta identificacion ya esta registrada');
        return $this->form_validation->run();
    }

    /*Funcion encargada de validar todosl los campos que son ingresados mediante los formularios de ingreso o edicion,
 * considerando unas reglas predefinidas para cada campo.
 */
    public function validar_actualizar() {
        $this->load->library('form_validation');
        $config = array(
            array('field' => 'primer_nombre','label' => 'Primer Nombre','rules' => 'trim|required|xss_clean'),
            array('field' => 'segundo_nombre','label' => 'Segundo Nombre','rules' => 'trim|xss_clean'),
            array('field' => 'primer_apellido','label' => 'Primer Apellido','rules' => 'trim|required|xss_clean'),
            array('field' => 'segundo_apellido','label' => 'Segundo Apellido','rules' => 'trim|xss_clean'),
            array('field' => 'tipo_identificacion','label' => 'Tipo de Indentificacion','rules' => 'trim|required|xss_clean'),
            array('field' => 'identificacion','label' => 'Numero de Identificacion','rules' => 'trim|required|xss_clean|numeric'),
            array('field' => 'numero_tarjeta','label' => 'Numero de Tarjeta Profecional','rules' => 'trim|required|xss_clean|numeric'),
            array('field' => 'especialidad','label' => 'Especialidad','rules' => 'trim|required|xss_clean'),
            array('field' => 'consultorio','label' => 'Consultorio','rules' => 'trim|required|xss_clean|numeric'),
            array('field' => 'programa_salud','label' => 'Programa Salud','rules' => 'callback_isChecked'),
        );

        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('required', 'El campo %s es Obligatorio');$this->form_validation->set_message('trim', 'Caracteres Invalidos');$this->form_validation->set_message('numeric', 'El campo %s debe ser numerico');
    
        return $this->form_validation->run();
    }
    /*Funcion que valida si un campo tiplo check box en el formulario fue o no checkeado*/
    function isChecked($str=NULL){
        
        if(!isset($_POST['opcion'])){
            $this->form_validation->set_message('isChecked', 'Debe seleccionar al menos una opcion para %s');
            return FALSE;
        }
        else{
            return TRUE;
        }
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