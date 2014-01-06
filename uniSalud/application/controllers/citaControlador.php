<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class citaControlador extends CI_Controller {

    /*Constructor de la clase*/
    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('citaModelo');
    }
    /*Funcion principal de la clase la cual es invocada en cuanto se hace el llamado al controlador*/
    public function index() {
        $this->set_session('mensaje', NULL);
        $this->citasEstudiante();
    }
    /*Carga  la vista para realizar la reserva de una cita por parte de un estudiante*/
    public function citasEstudiante() {
        $session=  $this->get_session();
        if($session['id_rol']==3){
            if(isset($session['id_estudiante']) && $session['id_estudiante']!=NULL){
                $id=$session['id_estudiante'];
            }else{
                $id=$this->input->POST('id_estudiante');
                $this->set_session('id_estudiante',$id);
            }
            $data['header'] = 'includes/header';
            $data['menu'] = 'personal/menu';
            $data['topcontent'] = 'estandar/topcontent';
            $data['content'] = 'personal/contentCita';
            $data['footerMenu'] = 'personal/footerMenu';
            $data['title'] = "Citas Estudiante";
        }
        else{
            $id=$session['id_persona'];
            //Definicion de la interface
            $data['header'] = 'includes/header';
            $data['menu'] = 'estudiante/menu';
            $data['topcontent'] = 'estandar/topcontent';
            $data['content'] = 'estudiante/contentCitas';
            $data['footerMenu'] = 'estudiante/footerMenu';
            $data['title'] = "Mis Citas";
        }
        $citas = $this->citaModelo->obtenerCitas($id);
        if ($citas != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();
            //numero de items por pagina
            $opciones['per_page'] = 5;
            //linck de la paginacion
            $opciones['base_url'] = base_url() . '/citaControlador/misCitas/';
            //numero total de tuplas en la base de datos
            $opciones['total_rows'] = $citas->num_rows();
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
            $citas = $this->citaModelo->obtenerCitas($id,$opciones['per_page'], $this->uri->segment(3));
            //carga de datos del resultado de la consulta
            $data['citas'] = $citas;
            //creacion de los linck de la paginacion
            $data['paginacion'] = $this->pagination->create_links();
            //FIN_PAGINACION...
        } else {
            $data['citas'] = NULL;
        }
        $this->load->view('plantilla', $data);
    }
    /*Busca y carga los datos necesarios para cargar el formulario que permite hacer la reserva de una cita*/
    public function buscarEstudiante() {
        $this->set_session('mensaje', NULL);
        $id = 0;
        $user = $this->get_session();
        if ($user['id_rol'] == 3) {
            $id = $_POST['id_estudiante'];
        }
        if ($user['id_rol'] == 1) {
            $this->load->model('usuarioModelo');

            $id = $this->usuarioModelo->getId($user['id_usuario']);
        }


        $data['estudiante'] = $this->estudianteModelo->buscarEstudiante($id);
        $data['programa_est'] = $this->estudianteModelo->programaEstudiante($data['estudiante']->id_programa);
        $data['programas'] = $this->programaSaludModelo->obtenerProgramas();
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/reservaCita';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Reservar Cita";
        $this->load->view('plantilla', $data);
    }
    /*Funcion que obtiene de forma dinamica el personal de salud al que esta asociado el programa que se seleccione
     *  en el formulario correpondiente a reservar cita
     */
    public function obtenerPersonalSalud() {
        $idPrograma = $this->input->post("id", true);
        $personal = $this->personalSaludModelo->buscarPersonalSaludPrograma($idPrograma);
        if ($personal != FALSE) {
            echo '<option value="">Seleccione una opcion </option>';
        } else {
            echo '<option value="">No Hay Personal Disponible</option>';
        }
        foreach ($personal->result_array() as $row) {
            echo '<option value="' . $row['id_personalsalud'] . '">' . $row['primer_nombre'] . ' ' . $row['primer_apellido'] . '</option>';
        }
    }
/*Funcion que obtiene de forma dinamica las fechas en las cuales el personal de salud elegido
 * tiene asignado su horario de atencion, esto solo los proximos 8 dias a partir de la fecha.
 */
    public function obtenerFechas() {
        $idPersonal = $this->input->post("id", true);
        $this->set_session('idPersonal', $idPersonal);
        $diasDisp = $this->personalSaludModelo->obtenerDiasDisp($idPersonal);
        if ($diasDisp != FALSE) {
            $diaSemNum = date('N', $timestamp = time());
            $dia = date('j', $timestamp = time());
            $mes = date('n', $timestamp = time());
            $anio = date('Y', $timestamp = time());
            echo '<option value="">Seleccione una opcion </option>';
            for ($i = 0; $i < 8; $i++) {
                $diaSemNum++;
                $dia++;
                if ($diaSemNum >= 8) {
                    $diaSemNum = 1;
                }
                $ban = false;
                foreach ($diasDisp->result() as $diaD):
                    if ($diaSemNum == $this->diaEnNumeros($diaD->dia)) {
                        $ban = true;
                        break;
                    }
                endforeach;
                if ($ban) {
                    if ($mes == 1 || $mes == 3 || $mes == 5 || $mes == 7 || $mes == 8 || $mes == 10) {
                        if ($dia > 31) {
                            $mes = $mes + 1;
                            $dia = 1;
                        }
                    }
                    if ($mes == 4 || $mes == 6 || $mes == 9 || $mes == 11) {
                        if ($dia > 30) {
                            $mes = $mes + 1;
                            $dia = 1;
                        }
                    }
                    if ($mes == 2) {
                        if ($dia > 28 && date('L', $timestamp = time()) == 0) {
                            $mes = $mes + 1;
                            $dia = 1;
                        }
                    }
                    if ($mes == 12) {
                        if ($dia > 31) {
                            $anio = $anio + 1;
                            $mes = 1;
                            $dia = 1;
                        }
                    }
                    echo '<option value="' . $anio . '-' . $mes . '-' . $dia . '">' . $dia . '/' . $mes . '/' . $anio . '</option>';
                }
            }
        } else {
            echo '<option value="">No Tiene Agenda Programada</option>';
        }
    }
    /*Funcion que obtiene dinamicamente las horas en las cuales el personal de salud seleccionado,
     * en la fecha seleccionada, tiene disponibilidad para atender una cita 
     */
    public function obtenerHoras() {
        $fecha = $this->input->post("id", true);
        $session = $this->get_session();
        $idPersonal = $session['idPersonal'];
        $i = strtotime($fecha);
        $diaNum = jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m", $i), date("d", $i), date("Y", $i)), 0);
        $diaLet = $this->diaEnLetras($diaNum);
        $horarioDia = $this->personalSaludModelo->obtenerHorarioDia($diaLet, $idPersonal);
        $horarioCitas = $this->personalSaludModelo->obtenerCitas($idPersonal, $fecha);
        $horas = '';
        foreach ($horarioDia->result() as $disp) {
            $horaini = $disp->hora_inicial;
            $horaAux = (int) ($horaini[0] . $horaini[1]);
            $minAux = (int) ($horaini[3] . $horaini[4]);
            $horafin = $disp->hora_final;
            $horaF = (int) ($horafin[0] . $horafin[1]);
            $minF = (int) ($horafin[3] . $horafin[4]);
            while ($horaAux <= $horaF) {
                $ban = false;
                if ($horarioCitas != FALSE) {
                    foreach ($horarioCitas->result() as $ocup) {
                        $horacita = $ocup->hora_inicio;
                        $horaO = (int) ($horacita[0] . $horacita[1]);
                        $minO = (int) ($horacita[3] . $horacita[4]);
                        if ($horaO == $horaAux && $minO == $minAux) {
                            $ban = true;
                            break;
                        }
                    }
                }
                if ($ban == false) {
                    if ($minAux < 10) {
                        $min = "0" . $minAux;
                    } else {
                        $min = $minAux;
                    }
                    if ($horaAux < $horaF || ($horaAux == $horaF && $minAux < $minF))
                        $horas = $horas . '<option value="' . $horaAux . ':' . $min . ':00' . '">' . $horaAux . ':' . $min . ':00' . '</option>';
                }
                $minAux = $minAux + 20;
                if ($minAux >= 60) {
                    if ($minAux == 60) {
                        $horaAux++;
                        $minAux = 0;
                    } else {
                        $horaAux++;
                        $minAux = $minAux - 60;
                    }
                }
            }
        }
        if (strcmp($horas, "") != 0) {
            echo '<option value="">Seleccione una opcion </option>';
            echo $horas;
        } else {
            echo '<option value="">La Agenda esta llena para esta fecha</option>';
        }
    }
/*Obtiene los dias en cadena de su correspodiente en numeros del 1 al 7 siendo 1 el lunes*/
    public function diaEnNumeros($dia) {
        $diaN = 0;
        switch ($dia) {
            case "lunes":
                $diaN = 1;
                break;
            case "martes":
                $diaN = 2;
                break;
            case "miercoles":
                $diaN = 3;
                break;
            case "jueves":
                $diaN = 4;
                break;
            case "viernes":
                $diaN = 5;
                break;
            case "sabado":
                $diaN = 6;
                break;
        }
        return $diaN;
    }
/*obtiene en una cadena el dia que corresponda al numero de la semana del 1 al 7 siendo 1 lunes */
    public function diaEnLetras($dia) {
        $diaL = 0;
        switch ($dia) {
            case 1:
                $diaL = "lunes";
                break;
            case 2:
                $diaL = "martes";
                break;
            case 3:
                $diaL = "miercoles";
                break;
            case 4:
                $diaL = "jueves";
                break;
            case 5:
                $diaL = "viernes";
                break;
            case 6:
                $diaL = "sabado";
                break;
        }
        return $diaL;
    }
/*Funcion que obtiene y valida los datos ingresados por el usuario en el 
 * formulario correspondiente a reservar cita, y procede que valiendose del modelo
 * a ingresar dichos datos a la base de datos
 */
    public function reservar_Cita() {
        $data['programas'] = $this->programaSaludModelo->obtenerProgramas();
        $data['estudiante'] = $this->estudianteModelo->buscarEstudiante($_POST['id_estudiante']);
        $data['programa_est'] = $this->estudianteModelo->programaEstudiante($data['estudiante']->id_programa);
        $this->load->model('citaModelo');
        if ($_POST) {
            $data['header'] = 'includes/header';
            $data['menu'] = 'estandar/menu';
            //$data['topcontent'] = 'estandar/topcontentRegistrarse';
            $data['topcontent'] = 'estandar/topcontent';
            $data['content'] = 'personal/reservaCita';
            $data['footerMenu'] = 'estandar/footerMenu';
            if ($this->validar() == FALSE) {
                $data['errores'] = validation_errors();
            } else {
                $data['header'] = 'includes/header';
                $data['menu'] = 'estandar/menu';
                //$data['topcontent'] = 'estandar/topcontentRegistrarse';
                $data['topcontent'] = 'estandar/topcontent';
                $data['content'] = 'personal/contentEstudiantes';
                $data['footerMenu'] = 'estandar/footerMenu';
                $hora = explode(':', $_POST['hora']);
                if ($hora[1] + 20 < 60) {
                    $hora[1] = $hora[1] + 20;
                } else {
                    if ($hora[1] + 20 == 60) {
                        $hora[0]++;
                        $hora[1] = '00';
                    } else {
                        $hora[0]++;
                        $hora[1] = $hora[1] + 20 - 60;
                    }
                }
                $hora_fin = implode(':', $hora);
                $data['reserva'] = array(
                    'id_estudiante' => $_POST['id_estudiante'],
                    'id_programasalud' => $_POST['programa'],
                    'id_personalsalud' => $_POST['personal'],
                    'dia' => $_POST['fecha'],
                    'hora_inicio' => $_POST['hora'],
                    'hora_fin' => $hora_fin,
                    'estado' => 2, //estados de la cita 1=>activado,2=>reservado,3=>atendido,4=>cancelado
                    'observaciones' => $_POST['observacion'],
                );
                $id = $this->citaModelo->ingresarReservaCita($data['reserva']);
                $user = $this->get_session();
                if ($id) {
                    $this->set_session('mensaje', 'Cita Reservada Con Exito');
                    $this->set_session('exito', TRUE);
                } else {
                    $this->set_session('mensaje', 'Fallo al Reservar la Cita');
                    $this->set_session('exito', FALSE);
                }
                if ($user['id_rol'] == 3) {
                    redirect(base_url() . "estudianteControlador/mostrarEstudiantes");
                }
                if ($user['id_rol'] == 1) {
                    redirect(base_url() . "citaControlador/citasEstudiante");
                }
            }
            $this->load->view('plantilla', $data);
        }
    }
/*Funcion que realiza la validacion respectiva del formulario de reserva de cita*/
    public function validar() {

        $config = array(
            array(
                'field' => 'id_estudiante',
                'label' => 'identficador estudiante',
                'rules' => 'trim|callback_tieneCita'
            ),
            array(
                'field' => 'programa',
                'label' => 'Programa',
                'rules' => 'trim|callback_isSelected|callback_igualActividad'
            ),
            array(
                'field' => 'personal',
                'label' => 'Personal',
                'rules' => 'trim|callback_isSelected'
            ),
            array(
                'field' => 'fecha',
                'label' => 'Fecha',
                'rules' => 'trim|callback_isSelected'
            ),
            array(
                'field' => 'hora',
                'label' => 'Hora',
                'rules' => 'trim|callback_isSelected'
            ),
            array(
                'field' => 'observacion',
                'label' => 'Observacion',
                'rules' => 'trim|required|is_unique[estudiante.identificacion]'
            ),
        );
        $this->load->library('form_validation');
        $this->form_validation->set_rules($config);
        $this->form_validation->set_message('required', 'El campo %s es requerido');



        $this->form_validation->set_message('trim', 'Caracteres Invalidos');

        return $this->form_validation->run();
    }
/*Funcion que comprueba si un item fue o no seleccionado desde un combobox*/
    function isSelected($str = NULL) {
        if ($str == NULL) {
            $this->form_validation->set_message('isSelected', 'Debe seleccionar una opcion para %s');
            return FALSE;
        } else {
            return TRUE;
        }
    }
/*Funcion que comprueba si el estudiante tiene o no una cita ya reservada con el mismo personal de salud*/
    function tieneCita($str = NULL) {
        $this->load->model('citaModelo');
        $est = $this->input->post('id_estudiante', true);
        $med = $this->input->post('personal', true);
        $id = $this->citaModelo->tieneCita($est, $med);
        if ($id) {
            $this->form_validation->set_message('tieneCita', 'Ya tiene una cita programada');
            return FALSE;
        } else {

            return TRUE;
        }
    }

/*Funcion que valida el hecho de que no se puede tener a la vez dos citas que correspondan a programas con actividades similares*/
    function igualActividad($str = NULL) {
        $idEst = $this->input->post('id_estudiante', true);
        $progCita = $this->citaModelo->obtenerProgramas($idEst);
        $progEleg = $this->input->post('programa', true);
        $ban = false;
        if ($progCita != false) {
            $actEleg = $this->programaSaludModelo->obtenerActividad($progEleg);
            foreach ($progCita->result() as $prog):
                $actCita = $this->programaSaludModelo->obtenerActividad($prog->id_programasalud);
                if (strcmp($actEleg->actividad, $actCita->actividad) == 0) {
                    $ban = true;
                }
            endforeach;
        }
        if ($ban) {
            $this->form_validation->set_message('igualActividad', 'Ya tiene cita en esta actividad');
            return FALSE;
        } else {
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
    
    public function mostrarCitas(){
    
        //Definicion de la interface
        $this->load->library('pagination');
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/contentCita';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Citas Programadas";
        $citas = $this->citaModelo->obtenerCitas();
        if ($citas != FALSE) {
            //CONFIGURACION DE LA PAGINACION...
            $opciones = array();
            //numero de items por pagina
            $opciones['per_page'] = 5;
            //linck de la paginacion
            $opciones['base_url'] = base_url() . '/citaControlador/mostrarCitas/';
            //numero total de tuplas en la base de datos
            $opciones['total_rows'] = $citas->num_rows();
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
            $citas = $this->citaModelo->obtenerCitas($opciones['per_page'], $this->uri->segment(3));
            //carga de datos del resultado de la consulta
            $data['citas'] = $citas;
            //creacion de los linck de la paginacion
            $data['paginacion'] = $this->pagination->create_links();
            //FIN_PAGINACION...
        } else {
            $data['citas'] = NULL;
        }
        $this->load->view('plantilla', $data);
    }
    public function activarCita(){
        $id_cita = explode(':', $this->uri->segment(3));
        $respuesta=  $this->citaModelo->activarCita($id_cita);
         if ($respuesta) {
                $this->set_session('mensaje', 'Cita Activada Con Exito');
                $this->set_session('exito', TRUE);
            } else {
                $this->set_session('mensaje', 'Fallo al Activar la Cita');
                $this->set_session('exito', FALSE);
            }
            redirect('citaControlador/citasEstudiante');
    }
    public function cancelarCita(){
        $id_cita = explode(':', $this->uri->segment(3));
        $respuesta=  $this->citaModelo->cancelarCita($id_cita);
         if ($respuesta) {
                $this->set_session('mensaje', 'Cita Cancelada Con Exito');
                $this->set_session('exito', TRUE);
            } else {
                $this->set_session('mensaje', 'Fallo al Cancelar la Cita');
                $this->set_session('exito', FALSE);
            }
            redirect('citaControlador/citasEstudiante');
    }
    
    function reporteEstudiantesPrograma(){
        $this->set_session('mensaje', NULL);
        $data['header'] = 'includes/header';
            $data['menu'] = 'personal/menu';
            $data['topcontent'] = 'estandar/topcontent';
            $data['content'] = 'personal/generarReportes';
            $data['footerMenu'] = 'personal/footerMenu';
            $data['title'] = "Reportes";
            $data['programas'] = $this->programaSaludModelo->obtenerProgramas();
            $data['personal']=$this->personalSaludModelo->obtenerPersonalSalud();
            
        if($this->validar_reporte_programa()==FALSE){
            $data['errores'] = validation_errors();
            
        }else{
            $this->set_session('mensaje', NULL);
            $data['header'] = 'includes/header';
            $data['menu'] = 'personal/menu';
            $data['topcontent'] = 'estandar/topcontent';
            $data['content'] = 'personal/contentReportes';
            $data['titulo_reporte']='Numero de estudiantes que usan el servicio <br /> '.$_POST['programa'].',clasificados por programa';
            $data['tipo_reporte']='1';
            $data['enlace']=  site_url('reporteControlador/reporteEstudiantesProgramaPDF/'.$_POST['programa']);
            $this->set_session('titulo_reporte', $data['titulo_reporte']);
            $data['reporte']=$this->citaModelo->estudiantesPorPrograma($_POST['programa']);
            $data['footerMenu'] = 'personal/footerMenu';
            $data['title'] = "Reportes";
            
        }
        $this->load->view('plantilla', $data);
    }
    
    function reporteEstudiantesPorFecha(){
        $this->set_session('mensaje', NULL);
        $data['header'] = 'includes/header';
            $data['menu'] = 'personal/menu';
            $data['topcontent'] = 'estandar/topcontent';
            $data['content'] = 'personal/generarReportes';
            $data['footerMenu'] = 'personal/footerMenu';
            $data['title'] = "Reportes";
            $data['programas'] = $this->programaSaludModelo->obtenerProgramas();
            $data['personal']=$this->personalSaludModelo->obtenerPersonalSalud();
            
        if($this->validar_reporte_medico()==FALSE){
            $data['errores'] = validation_errors();
            
        }else{
            $this->set_session('mensaje', NULL);
            $data['header'] = 'includes/header';
            $data['menu'] = 'personal/menu';
            $data['topcontent'] = 'estandar/topcontent';
            $data['content'] = 'personal/contentReportes';
            $personal=$this->personalSaludModelo->buscarPersonal($_POST['personal']);
            $data['titulo_reporte']='Lista estudiantes por atender <br /><br />'.$personal->primer_nombre.' '.$personal->primer_apellido.' <br /><br />'.$_POST['fecha_nac'];
            $data['tipo_reporte']='2';
            $data['reporte']=$this->citaModelo->estudiantesPorFecha($_POST['fecha_nac'],$_POST['personal']);
            $data['enlace']=  site_url('reporteControlador/reporteEstudiantesPorFechaPDF/'.$_POST['fecha_nac'].'/'.$_POST['personal']);
            $this->set_session('titulo_reporte', $data['titulo_reporte']);
            $data['footerMenu'] = 'personal/footerMenu';
            $data['title'] = "Reportes";
            
        }
        $this->load->view('plantilla', $data);
    }
    
    function reporteEstudiantesFacultad(){
        $this->set_session('mensaje', NULL);
        $data['header'] = 'includes/header';
            $data['menu'] = 'personal/menu';
            $data['topcontent'] = 'estandar/topcontent';
            $data['content'] = 'personal/generarReportes';
            $data['footerMenu'] = 'personal/footerMenu';
            $data['title'] = "Reportes";
            $data['programas'] = $this->programaSaludModelo->obtenerProgramas();
            $data['personal']=$this->personalSaludModelo->obtenerPersonalSalud();
            
        if($this->validar_reporte_facultad()==FALSE){
            $data['errores'] = validation_errors();
            
        }else{
            $this->set_session('mensaje', NULL);
            $data['header'] = 'includes/header';
            $data['menu'] = 'personal/menu';
            $data['topcontent'] = 'estandar/topcontent';
            $data['content'] = 'personal/contentReportes';
            $data['titulo_reporte']='Numero de estudiantes que usan el servicio<br /> '.$_POST['programa1'].', clasificados por facultad';
            $data['tipo_reporte']='3';
            $data['enlace']=  site_url('reporteControlador/reporteEstudiantesFacultadPDF/'.$_POST['programa1']);
            $this->set_session('titulo_reporte', $data['titulo_reporte']);
            $data['reporte']=$this->citaModelo->estudiantesPorFacultad($_POST['programa1']);
            $data['footerMenu'] = 'personal/footerMenu';
            $data['title'] = "Reportes";
            
        }
        $this->load->view('plantilla', $data);
    }
    
    function reporteServicioMasSolicitado(){
        
            $this->set_session('mensaje', NULL);
            $data['header'] = 'includes/header';
            $data['menu'] = 'personal/menu';
            $data['topcontent'] = 'estandar/topcontent';
            $data['content'] = 'personal/contentReportes';
            $data['titulo_reporte']='Servicio mas solicitado';
            $data['tipo_reporte']='4';
            $data['reporte']=$this->citaModelo->servicioMasSolicitado();
            $data['footerMenu'] = 'personal/footerMenu';
            $data['title'] = "Reportes";
            
        
            
        
        $this->load->view('plantilla', $data);
    }
    
    
    function validar_reporte_programa(){
        $config = array(
            
            array(
                'field' => 'programa',
                'label' => 'Programa',
                'rules' => 'trim|callback_isSelected'
            )
        );
        $this->load->library('form_validation');
        $this->form_validation->set_rules($config);
        



        $this->form_validation->set_message('trim', 'Caracteres Invalidos');

        return $this->form_validation->run();
    }
    
    function validar_reporte_facultad(){
        $config = array(
            
            array(
                'field' => 'programa1',
                'label' => 'Programa',
                'rules' => 'trim|callback_isSelected'
            )
        );
        $this->load->library('form_validation');
        $this->form_validation->set_rules($config);
        



        $this->form_validation->set_message('trim', 'Caracteres Invalidos');

        return $this->form_validation->run();
    }
    
    function validar_reporte_medico(){
        
        $config = array(
            
            array(
                'field' => 'personal',
                'label' => 'Personal',
                'rules' => 'trim|callback_isSelected'
            ),
            array('field' => 'fecha_nac',
                'label' => 'Fecha',
                'rules' => 'trim|required')
        );
        $this->load->library('form_validation');
        $this->form_validation->set_rules($config);
        



        $this->form_validation->set_message('trim', 'Caracteres Invalidos');
        $this->form_validation->set_message('required', 'El campo %s es requerido');
        return $this->form_validation->run();
    }
}


?>
