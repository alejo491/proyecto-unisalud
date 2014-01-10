<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class agendaControlador extends CI_Controller {
    //constructor de la clase
    function __construct() {
        parent::__construct();
        $this->load->database();
    }
    //funcion principal del controlador
    public function index(){
        //configurando la variable de sesion que almacena los mensajes
        $this->set_session('mensaje',NULL);
        //llamado a la funcion que se encarga de cargar los datos del personal de salud
        $this->buscarDatos();
    }
    //funcion utilizada para cargar los datos del personal de salud y su respectivo horario de atencion
    function buscarDatos(){
        //Obtener el identificador del personal de salud segun sea el caso
        if(isset($_POST['id_personalsalud'])){
            $id = $_POST['id_personalsalud'];
            $this->set_session('id_personalsalud',$id);
        }else{
            $session=$this->get_session();
            $id=$session['id_personalsalud'];
        }
        
        //Se obtiene la informacion mediante el modelo del personal de salud
        $data['personal'] = $this->personalSaludModelo->buscarPersonal($id);
        //configuracion de la interfaz de usuario que se mostrara en cuanto se carguen los datos
        $data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentHorarioAtencion';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Horario de Atencion";
        //Se obtiene la informacion del horario de antecion que actualmente tiene el personal mediante el modelo
        $agenda= $this->agendaModelo->obtenerAgenda($id);
        //se comprueba que se obtubieron resultados
        if ($agenda != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array(); $opciones['per_page'] = 5;$opciones['base_url'] = base_url() . '/agendaControlador/buscarDatos';$opciones['total_rows'] = $agenda->num_rows();$opciones['uri_segment'] = 3;$opciones['num_links'] = 2;$opciones['first_link'] = 'Primero';$opciones['last_link'] = 'Ultimo';$opciones['full_tag_open'] = '<h3>';$opciones['full_tag_close'] = '</h3>';
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
        //se carga la vista pertinente y se le envian las variables necesarias
        $this->load->view('plantilla', $data);
    }
    //funcion que se encarga de configurar la vista para registrar un horario de atencion
    public function agregarHorarioAtencion() {
        //definicion de la interfaz de usuario
        $this->set_session('mensaje', NULL);
        $data['id_personalsalud']=$_POST['id_personalsalud'];$data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentRegistrarHorarioAtencion';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Agregar Horario de Atencion";
        //se carga la vista pertinente y se le envian las variables necesarias
        $this->load->view('plantilla', $data);
    }
    //funcion que hace el llamado respectivo al modelo con el fin de que se registren los datos en la bd obtenidos en el formaulario
    public function aniadirDatos() {
        //se comprueba si se obtubieron datos desde el formulario
        if ($_POST) {
            //se corren las validaciones de los campos del formulario
            if ($this->validar() == FALSE) {
                //en el caso de que la validacion falle se configura nuevamente la vista para ser mostrada
                $data['id_personalsalud']=$_POST['id_personalsalud'];$data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent'; $data['content'] = 'personal/contentRegistrarHorarioAtencion';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Horario de Atencion";
                //se carga la vista pertinente y se le envian las variables necesarias
                $this->load->view('plantilla', $data);
            } else {
                //si son validos los campos, se procede a recuperar su contenido mendiante POST
                $horario['id_personalsalud'] = $_POST['id_personalsalud'];$horario['hora_inicial'] =$_POST['hora_i'].':'.$_POST['min_i'].':00'; $horario['hora_final'] =$_POST['hora_f'].':'.$_POST['min_f'].':00';$horario['dia'] = $_POST['dia'];  
                //se hace el llamado al modelo para ingresar los datos a la bd
                $id = $this->agendaModelo->ingresarHorarioAgenda($horario);
                //se comprueba si tubo o no exito el ingreso y se cargan los mensajes pertinentes
                if ($id) {
                    $this->set_session('mensaje', 'Horario Ingresado Con Exito'); $this->set_session('exito', TRUE);
                } else {
                    $this->set_session('mensaje', 'Fallo al Ingresar el Horario'); $this->set_session('exito', FALSE);
                }
                //$this->buscarDatos();
                redirect('agendaControlador/buscarDatos');
            }
        }
    }
    
    //Funcion que carga el horario de antencion de un personal de salud
    public function buscarHorarioPersonal() {
        //se coloca el mensaje de accion como vacio
        $this->session->set_userdata('mensaje', NULL);
        //se recibe el identificador de la agenda por medio de POST
        $id = $_POST['id_agenda'];
        //se consulta mediante el modelo  el horario q corresponde al identificador
        $data['horario']=$this->agendaModelo->obtenerHorarioAtencion($id);
        //declaracion de variables usadas como auxiliares
        $str='';
        $i=0;
        //se rrecorre la consulta y se guardan uno a uno los valores del horario
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
        //configuracion de la interfaz de usuario
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/editarHorarioAtencion';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Editar Horario de Atencion";
        //se carga la vista pertinente y se le envian las variables necesarias
        $this->load->view('plantilla', $data);
    }
//funcion que obtiene los datos del horario desde un formulario, los valida y edita los datos en la base de datos a travez del modelo 
    public function editarHorarioAtencion() {
        if ($_POST) {
            if ($this->validar() == FALSE) {
                $data['id_personalsalud']=$_POST['id_personalsalud'];$data['header'] = 'includes/header';$data['menu'] = 'personal/menu';$data['topcontent'] = 'estandar/topcontent';$data['content'] = 'personal/contentRegistrarHorarioAtencion';$data['footerMenu'] = 'personal/footerMenu';$data['title'] = "Agregar Horario Atencion";
                //se carga la vista pertinente y se le envian las variables necesarias
                $this->load->view('plantilla', $data);
            } else {
                $data['id_agenda'] = $_POST['id_agenda'];$data['id_personalsalud'] = $_POST['id_personalsalud'];$data['hora_inicial'] =$_POST['hora_i'].':'.$_POST['min_i'].':'.$_POST['seg_i'];$data['hora_final'] =$_POST['hora_f'].':'.$_POST['min_f'].':'.$_POST['seg_f'];$data['dia'] = $_POST['dia'];       
                $respuesta = $this->agendaModelo->actualizarHorarioAtencion($data);
                if ($respuesta) {
                    $this->session->set_userdata('mensaje', 'Horario Actualizado Con Exito');$this->session->set_userdata('exito', TRUE);
                } else {
                    $this->session->set_userdata('mensaje', 'Fallo al Actualizar el Horario');$this->session->set_userdata('exito', FALSE);
                }
                redirect('agendaControlador/buscarDatos');
            }
        }
    }
/*Funcion que despues de confirmar la eliminacion de una tupla, realiza el eliminado de la misma en la base
 * de datos valiendose del modelo.
 */
    public function eliminarHorarioAtencion() {
        $this->session->set_userdata('mensaje', NULL);
        $id = $this->uri->segment(3);
        
            $respuesta = $this->agendaModelo->eliminarHorario($id);
            if ($respuesta) {
                $this->session->set_userdata('mensaje', 'Horario Eliminado Con Exito');$this->session->set_userdata('exito', TRUE);
            } else {
                $this->session->set_userdata('mensaje', 'Fallo al Eliminar el Horario');$this->session->set_userdata('exito', FALSE);
            }
        redirect('AgendaControlador/buscarDatos');
    }
/*Funcion encargada de validar todosl los campos que son ingresados mediante el formulario,
 * en este caso el formulario del horario de antencion y su respectiva edicion
 */
    public function validar() {
        $this->load->library('form_validation');
        $config = array(
            array('field' => 'dia','label' => 'Dia','rules' => 'trim|required|xss_clean'),
            array('field' => 'hora_i','label' => 'Hora Inicial','rules' => 'trim|xss_clean|required'),
            array('field' => 'hora_f','label' => 'Hora Final','rules' => 'trim|required|xss_clean')
        );
        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('required', 'El campo %s es Obligatorio');$this->form_validation->set_message('trim', 'Caracteres Invalidos');
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