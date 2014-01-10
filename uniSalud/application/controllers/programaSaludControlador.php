<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class programaSaludControlador extends CI_Controller {

    /*Constructor de la clase*/
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    /*Funcion Principal del controlador*/
    public function index(){
        $this->set_session('mensaje', NULL);
        $this->mostrarProgramas();
    }
    
    /*Funcion Encargada de cargar la tabla donde se muestran los programas de salud con su respectiva paginacion y posibles acciones*/
    public function mostrarProgramas() {
        //Definicion de la interface
        $this->load->library('pagination');
        $data['header'] = 'includes/header';$data['menu'] = 'personal/menu'; $data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentProgramaSalud';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Programas de Salud";$this->load->model('programaSaludModelo');
        $programas = $this->programaSaludModelo->obtenerProgramas();
        if ($programas != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();
            //numero de items por pagina
            $opciones['per_page'] = 5;
            //linck de la paginacion
            $opciones['base_url'] = base_url() . '/programaSaludControlador/mostrarProgramas/'; $opciones['total_rows'] = $programas->num_rows();$opciones['uri_segment'] = 3; $opciones['num_links'] = 2;$opciones['first_link'] = 'Primero'; $opciones['last_link'] = 'Ultimo'; $opciones['full_tag_open'] = '<h3>'; $opciones['full_tag_close'] = '</h3>';
            //inicializacion de la paginacion
            $this->pagination->initialize($opciones);
            //consulta a la base de datos segun paginacion
            $programas = $this->programaSaludModelo->obtenerProgramas($opciones['per_page'], $this->uri->segment(3));
            //carga de datos del resultado de la consulta
            $data['programas'] = $programas;
            //creacion de los linck de la paginacion
            $data['paginacion'] = $this->pagination->create_links();
            //FIN_PAGINACION...
        } else {
            $data['programas'] = NULL;
        }
        $this->load->view('plantilla', $data);
    }
    
/*Funcion que se encarga de cargar los datos necesarios para cargar el formulario de registro de un programa de salud*/
    public function agregarProgramaSalud() {
        //definicion de la interface...
        $this->set_session('mensaje', NULL);
        $data['header'] = 'includes/header';$data['menu'] = 'personal/menu'; $data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentRegistrarPrograma'; $data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Agregar Programa";

        $this->load->view('plantilla', $data);
    }

    /*Funcion que obtiene y valida los datos obtenidos del formulario por medio del metodo
     * POST, seguido a esto se vale del modelo para ingresar los datos respectivos en la Base de Datos
     */
    public function aniadirDatos() {

        $this->load->model('programaSaludModelo');
        $this->load->library('form_validation');
        if ($_POST) {
            if ($this->validar() == FALSE) {
                $data['header'] = 'includes/header'; $data['menu'] = 'personal/menu'; $data['topcontent'] = 'estandar/topcontent'; $data['content'] = 'personal/contentRegistrarPrograma'; $data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Agregar Programa";
                $this->load->view('plantilla', $data);
            } else {
                $programa['costo'] = $_POST['costo'];
                $programa['tipo_servicio'] = $_POST['tipo_servicio'];
                $programa['actividad'] = $_POST['actividad'];
                $id = $this->programaSaludModelo->ingresarProgramaSalud($programa);
                if ($id) {
                    $this->set_session('mensaje', 'Programa Ingresado Con Exito');
                    $this->set_session('exito', TRUE);
                } else {
                    $this->set_session('mensaje', 'Fallo al Ingresar el Programa');
                    $this->set_session('exito', FALSE);
                }
                redirect('programaSaludControlador/mostrarProgramas');
            }
        }
    }

    /*Funcion que carga segun el item seleccionado en la interfaz de usuario, los
     * datos correspondientes al mismo, en un formulario donde se podran editar
     */
    public function actualizarProgramaSalud() {
        $this->set_session('mensaje', NULL);
        $this->load->model('programaSaludModelo');

        $id = $_POST['id_programasalud'];
        $data['programa'] = $this->programaSaludModelo->buscarPrograma($id);
        $data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/editarProgramaSalud'; $data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Editar Programa";
        $this->load->view('plantilla', $data);
    }

    /*Funcion que obtiene y valida los datos obtenidos del formulario por medio del metodo
     * POST, seguido a esto se vale del modelo para editar los datos respectivos en la Base de Datos
     */
    public function editarProgramaSalud() {
        $this->load->model('programaSaludModelo');

        if ($_POST) {
            if ($this->validar() == FALSE) {
                $id = $_POST['id_programasalud'];
                $data['programa'] = $this->programaSaludModelo->buscarPrograma($id);
                $data['header'] = 'includes/header'; $data['menu'] = 'personal/menu'; $data['topcontent'] = 'estandar/topcontent'; $data['content'] = 'personal/editarProgramaSalud'; $data['footerMenu'] = 'personal/footerMenu'; $data['title'] = "Editar Programa";
                $this->load->view('plantilla', $data);
            } else {
                $datos['costo'] = $_POST['costo'];
                $datos['tipo_servicio'] = $_POST['tipo_servicio'];
                $datos['actividad'] = $_POST['actividad'];
                $datos['id_programasalud'] = $_POST['id_programasalud'];
                $respuesta = $this->programaSaludModelo->editarProgramaSalud($datos);
                if ($respuesta) {
                    $this->set_session('mensaje', 'Programa Actualizado Con Exito');
                    $this->set_session('exito', TRUE);
                } else {
                    $this->set_session('mensaje', 'Fallo al Actualizar el Programa');
                    $this->set_session('exito', FALSE);
                }
                redirect('programaSaludControlador/mostrarProgramas');
            }
        }
    }

    /*Funcion que despues de confirmar la eliminacion de una tupla, realiza el eliminado de la misma en la base
 * de datos valiendose del modelo.
 */
    public function eliminarProgramaSalud() {
        $this->set_session('mensaje', NULL);
        $this->load->model('programaSaludModelo');
        //$id = $_POST['id_programasalud'];
        $id=$this->uri->segment(3);
        $respuesta = $this->programaSaludModelo->eliminarProgramaSalud($id);
        if ($respuesta) {
            $this->set_session('mensaje', 'Programa Eliminado Con Exito'); $this->set_session('exito', TRUE);
        } else {
            $this->set_session('mensaje', 'Fallo al Eliminar el Programa'); $this->set_session('exito', FALSE);
        }
        redirect('programaSaludControlador/mostrarProgramas');
    }
    
    /*Funcion que filtra y carga las tuplas que se muestran en la interfaz de usuario, segun uno o varios criterios de busqueda */
    public function buscarProgramaSalud(){
        $this->load->library('pagination');
        $data['header'] = 'includes/header';  $data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentProgramaSalud';$data['footerMenu'] = 'personal/footerMenu'; $data['title'] = "Programas de Salud";
        if(isset($_POST['tipo_servicio'])&& isset($_POST['actividad']) && isset($_POST['costo'])){
            $filtro['tipo_servicio']=$_POST['tipo_servicio'];
            $filtro['actividad']=$_POST['actividad'];
            $filtro['costo']=$_POST['costo'];
            $this->set_session('filtro',$filtro);
        }else{
               $session=$this->session->all_userdata();
               $filtro=$session['filtro'];
        }
        $respuesta = $this->programaSaludModelo->buscarFiltradoProgramaSalud($filtro);
        if ($respuesta != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();
            $opciones['per_page'] = 5; $opciones['base_url'] = base_url() . 'programaSaludControlador/buscarProgramaSalud/'; $opciones['total_rows'] = $respuesta->num_rows();$opciones['uri_segment'] = 3;$opciones['num_links'] = 2; $opciones['first_link'] = 'Primero'; $opciones['last_link'] = 'Ultimo';$opciones['full_tag_open'] = '<h3>';$opciones['full_tag_close'] = '</h3>';
            //inicializacion de la paginacion
            $this->pagination->initialize($opciones);
            //consulta a la base de datos segun paginacion
            $respuesta = $this->programaSaludModelo->buscarFiltradoProgramaSalud($filtro,$opciones['per_page'], $this->uri->segment(3));
            //carga de datos del resultado de la consulta
            $data['programas'] = $respuesta;
            //creacion de los linck de la paginacion
            $data['paginacion'] = $this->pagination->create_links();
            //FIN_PAGINACION...
            } else {
                $data['programas'] = NULL;
            }
        $this->load->view('plantilla', $data);
}

/*Funcion encargada de validar todosl los campos que son ingresados mediante los formularios de ingreso o edicion,
 * considerando unas reglas predefinidas para cada campo.
 */
    public function validar() {
        $this->load->library('form_validation');
        $config = array(
            array('field' => 'costo','label' => 'Costo','rules' => 'trim|required|numeric|xss_clean'),
            array('field' => 'tipo_servicio','label' => 'Tipo De Servicio','rules' => 'trim|required|xss_clean'),
            array('field' => 'actividad','label' => 'Actividad','rules' => 'trim|required|xss_clean')
        );

        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('required', 'El campo %s es Obligatorio'); $this->form_validation->set_message('trim', 'Caracteres Invalidos'); $this->form_validation->set_message('numeric', 'El campo %s debe ser numerico');
        return $this->form_validation->run();
    }
    
    public function cargarprogramasalud(){
        $programas = $this->programaSaludModelo->obtenerProgramas();
        foreach ($programas->result_array() as $row) {
             echo  '<option value="'.$row['id_programasalud'].'">'.$row['tipo_servicio'].'</option>';
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