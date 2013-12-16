<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class citaControlador extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function index() {
        $this->session->set_userdata('mensaje', NULL);
    }
    
    public function citasEstudiante(){
        $data['header'] = 'includes/header';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'estudiante/contentCitas';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Citas";
        $this->load->view('plantilla', $data);
    }

    public function buscarEstudiante() {
        $this->session->set_userdata('mensaje', NULL);
        $id=0;
        $user = $this->session->all_userdata();
        if($user['id_rol']==3){
          $id = $_POST['id_estudiante'];
        }
        if($user['id_rol']==1){
            $this->load->model('usuarioModelo');
            
            $id =$this->usuarioModelo->getId($user['id_usuario']);
            
        }
        
        
        $data['estudiante'] = $this->estudianteModelo->buscarEstudiante($id);
        $data['programa_est']=$this->estudianteModelo->programaEstudiante($data['estudiante']->id_programa);
        $data['programas'] = $this->programaSaludModelo->obtenerProgramas();
        $data['header'] = 'includes/header';
        $data['menu'] = 'personal/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'personal/reservaCita';
        $data['footerMenu'] = 'personal/footerMenu';
        $data['title'] = "Reservar Cita";
        $this->load->view('plantilla', $data);
    }

    public function obtenerPersonalSalud() {
        $idPrograma = $this->input->post("id", true);
        $personal = $this->personalSaludModelo->buscarPersonalSaludPrograma($idPrograma);
        echo '<option value="">Seleccione una opcion </option>';
        foreach ($personal->result_array() as $row) {
            echo '<option value="' . $row['id_personalsalud'] . '">' . $row['primer_nombre'] . ' ' . $row['primer_apellido'] . '</option>';
        }
    }

    public function obtenerFechas() {
        $idPersonal = $this->input->post("id", true);
        $this->session->set_userdata('idPersonal', $idPersonal);
        $diasDisp = $this->personalSaludModelo->obtenerDiasDisp($idPersonal);
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
                    if ($dia > 21) {
                        $anio = $anio + 1;
                        $mes = 1;
                        $dia = 1;
                    }
                }
                echo '<option value="' . $anio . '-' . $mes . '-' .  $dia. '">' . $dia . '/' . $mes . '/' . $anio . '</option>';
            }
        }
    }
    public function obtenerHoras(){
        $fecha = $this->input->post("id", true);
        $session=$this->session->all_userdata();
        $idPersonal=$session['idPersonal'];
        $i = strtotime($fecha);
        $diaNum= jddayofweek(cal_to_jd(CAL_GREGORIAN, date("m",$i),date("d",$i), date("Y",$i)) , 0 );
        $diaLet=  $this->diaEnLetras($diaNum);
        $horarioDia=$this->personalSaludModelo->obtenerHorarioDia($diaLet,$idPersonal);
        $horarioCitas=$this->personalSaludModelo->obtenerCitas($idPersonal,$fecha);
        echo '<option value="">Seleccione una opcion </option>';
            foreach ($horarioDia->result() as $disp){
            $horaini=$disp->hora_inicial;
            $horaAux=(int)($horaini[0].$horaini[1]);
            $minAux=(int)($horaini[3].$horaini[4]);
            $horafin=$disp->hora_final;
            $horaF=(int)($horafin[0].$horafin[1]);
            $minF=(int)($horafin[3].$horafin[4]);            
            while($horaAux<$horaF){
                $ban=false;
                if($horarioCitas!=FALSE){
                    foreach ($horarioCitas->result() as $ocup){
                        $horacita=$ocup->hora_inicio;
                        $horaO=(int)($horacita[0].$horacita[1]);
                        $minO=(int)($horacita[3].$horacita[4]);
                        if($horaO==$horaAux && $minO==$minAux){
                            $ban=true;
                            break;
                        }
                    }
                }
                if($ban==false){
                    if($minAux<10){
                        $min="0".$minAux;
                    }else{
                        $min=$minAux;
                    }
                    echo '<option value="' . $horaAux . ':' . $min . ':00'.'">' . $horaAux . ':' . $min . ':00' . '</option>';
                }
                $minAux=$minAux+20;
                if($minAux>60){
                        if($minAux==60){
                            $horaAux++;
                            $minAux=0;
                        }else{
                            $horaAux++;
                            $minAux=$minAux-60;
                        }
                    }
                
            }
        }
    }
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
    
    public function reservar_Cita(){
        $data['programas'] = $this->programaSaludModelo->obtenerProgramas();
        $data['estudiante'] = $this->estudianteModelo->buscarEstudiante($_POST['id_estudiante']);
        $data['programa_est']=$this->estudianteModelo->programaEstudiante($data['estudiante']->id_programa);
        $this->load->model('citaModelo');
            if($_POST){
                $data['header'] = 'includes/header';
                $data['menu'] = 'estandar/menu';
                //$data['topcontent'] = 'estandar/topcontentRegistrarse';
                $data['topcontent']='estandar/topcontent';
                $data['content'] = 'personal/reservaCita';
                $data['footerMenu'] = 'estandar/footerMenu';
                if($this->validar()==FALSE){
                    $data['errores'] = validation_errors();
                }else{
                    $data['header'] = 'includes/header';
                $data['menu'] = 'estandar/menu';
                //$data['topcontent'] = 'estandar/topcontentRegistrarse';
                $data['topcontent']='estandar/topcontent';
                $data['content'] = 'personal/contentEstudiantes';
                $data['footerMenu'] = 'estandar/footerMenu';
                    $hora=explode(':',$_POST['hora']);
                    if($hora[1]+20<60){
                       $hora[1]=$hora[1]+20;

                   }else{
                        if($hora[1]+20==60){
                            $hora[0]++;
                            $hora[1]='00';
                        }else{
                            $hora[0]++;
                            $hora[1]=$hora[1]+20-60;
                        }
                    }
                    $hora_fin=implode(':',$hora);
                    $data['reserva']=array(
                       'id_estudiante'=>$_POST['id_estudiante'],
                       'id_programasalud'=>$_POST['programa'],
                       'id_personalsalud'=>$_POST['personal'],
                       'dia'=>$_POST['fecha'],
                       'hora_inicio'=>$_POST['hora'],
                       'hora_fin'=>$hora_fin,
                       'estado'=>2,//estados de la cita 1=>activado,2=>reservado,3=>atendido,4=>cancelado
                       'observaciones'=>$_POST['observacion'],

                    );
                    $id = $this->citaModelo->ingresarReservaCita($data['reserva']);
                    $user = $this->session->all_userdata();
                    if($user['id_rol']==3){
                      redirect(base_url()."estudianteControlador");
                    }
                    if($user['id_rol']==1){
                        redirect(base_url()."citaControlador/citasEstudiante");

                    }
                    
                }
                 $this->load->view('plantilla',$data);   
            }
            
    }
    
    public function validar(){
        
        $config = array(
                array(
                    'field' => 'id_estudiante',
                    'label' => 'identficador estudiante',
                    'rules' => 'trim|callback_tieneCita'
                ),
                
                array(
                    'field' => 'programa',
                    'label' => 'Programa',
                    'rules' => 'trim|callback_isSelected'
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
    
    function isSelected($str=NULL){
        if($str==NULL){
            $this->form_validation->set_message('isSelected', 'Debe seleccionar una opcion para %s');
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
    function tieneCita($str=NULL){
        $this->load->model('citaModelo');   
        $est = $this->input->post('id_estudiante', true);
        $id = $this->citaModelo->tieneCita($est);
        if($id){
            $this->form_validation->set_message('tieneCita', 'Ya tiene una cita programada');
            return FALSE;
            
        }else{
            
            return TRUE;
        }
    }

}

?>
