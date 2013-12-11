<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class estandarControlador extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->model('estudianteModelo');
        $this->load->library('grocery_CRUD');
    }
    public function index(){
        $data['header'] = 'includes/headerHome';
        $data['menu'] = 'estandar/menu';
        $data['topcontent'] = 'estandar/topcontent';
        $data['content'] = 'estandar/contentHome';
        $data['footerMenu'] = 'estandar/footerMenu';
        $data['facultades']=$this->estudianteModelo->CargarFacultad();
        $this->load->view('plantilla',$data);
    }
    public function registrarse(){
        
        //controlar registrarse segun el rol
        $data['header'] = 'includes/header';
        
        //$data['topcontent'] = 'estandar/topcontentRegistrarse';
        $data['topcontent']='estandar/topcontent';
        $data['content'] = 'estandar/registrar_usuario';
        $data['footerMenu'] = 'estandar/footerMenu';
        $data['facultades']=$this->estudianteModelo->CargarFacultad();
        $this->load->view('plantilla',$data);
    }
    
    public function cancelar() {
        $user = $this->session->all_userdata();
        if(isset($user['id_usuario'])){
        redirect(base_url()."estudianteControlador");
        }else{
            
            redirect(base_url());
        }
    }
    public function registrar(){
        $user = $this->session->all_userdata();
        
        $this->load->model('usuarioModelo');   
        $this->load->model('estudianteModelo'); 
        $data['facultades']=$this->estudianteModelo->CargarFacultad();
        if ($_POST) {
                $data['header'] = 'includes/header';
                $data['menu'] = 'estandar/menu';
                //$data['topcontent'] = 'estandar/topcontentRegistrarse';
                $data['topcontent']='estandar/topcontent';
                $data['content'] = 'estandar/registrar_usuario';
                $data['footerMenu'] = 'estandar/footerMenu';
            if ($this->validar()==FALSE) {
                $data['errores'] = validation_errors();
            } else {
                    $data['header'] = 'includes/header';
                    $data['topcontent'] = 'estandar/topcontent';
                    $data['content'] = 'estandar/contentHome';
                    $data['footerMenu'] = 'estandar/footerMenu';
                    $data['estudiante'] = array(
                        'id_estudiante' => $_POST['codigoEstudiante'],
                        'id_programa' => $_POST['programa'],

                        'tipo_identificacion' => $_POST['tipoId'],
                        'identificacion' => $_POST['numId'],
                        'primer_nombre' => $_POST['primerNombre'],
                        'segundo_nombre' => $_POST['segundoNombre'],
                        'primer_apellido' => $_POST['primerApellido'],
                        'segundo_apellido' => $_POST['segundoApellido'],
                        'genero' => $_POST['genero'],
                        'fecha_nacimiento' =>$_POST['fecha_nac']
                    );
                  $id = $this->estudianteModelo->registrar($data['estudiante']);
                 
                
                
                if ($id!=FALSE) {
                    $data['usuario'] = array(
                         'id_persona'=>$id,
                         'email' => $_POST['email'],
                         'contrasena' => sha1($_POST['contrasena'])
                     );
                      $this->usuarioModelo->registrar($data['usuario']);
                      
                   
                    if (!isset($user['id_usuario'])) {
                    
                    
                        $usuarioActual = $this->usuarioModelo->login($_POST['email'], sha1($_POST['contrasena']));
                        $this->session->set_userdata('id_usuario', $usuarioActual['id_usuario']);
                        $this->session->set_userdata('email', $usuarioActual['email']);
                        $id_rol=$this->usuarioModelo->getRol($usuarioActual['id_usuario']);
                        $this->session->set_userdata('id_rol',$id_rol['id_rol']);
                        
                    }
                }
            }
            
            
                if($user['id_rol']==3){
                    redirect(base_url()."estudianteControlador"); 
                }else{
                
                    redirect(base_url()); 
                }
            
        }
    }
    public function validar(){
        $config = array(
                array(
                    'field' => 'codigoEstudiante',
                    'label' => 'Codigo Estudiante',
                    'rules' => 'trim|required|is_unique[estudiante.id_estudiante]'
                ),
                array(
                    'field' => 'primerNombre',
                    'label' => 'Primer Nombre',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'segundoNombre',
                    'label' => 'Segundo Nombre',
                    'rules' => 'trim'
                ),
                array(
                    'field' => 'primerApellido',
                    'label' => 'Primer Apellido',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'segundoApellido',
                    'label' => 'Segundo Apellido',
                    'rules' => 'trim|'
                ),
                array(
                    'field' => 'facultad',
                    'label' => 'Facultad',
                    'rules' => 'trim|callback_isSelected'
                ),
                array(
                    'field' => 'genero',
                    'label' => 'Genero',
                    'rules' => 'trim|'
                ),
                array(
                    'field' => 'programa',
                    'label' => 'Programa',
                    'rules' => 'trim|callback_isSelected'
                ),
                array(
                    'field' => 'fecha_nac',
                    'label' => 'Fecha de Nacimiento',
                    'rules' => 'trim|required'
                ),
                array(
                    'field' => 'tipoId',
                    'label' => 'tipo de Identificacion',
                    'rules' => 'trim|'
                ),
                array(
                    'field' => 'numId',
                    'label' => 'numero de Identificacion',
                    'rules' => 'trim|required|is_unique[estudiante.identificacion]'
                ),
                array(
                    'field' => 'email',
                    'label' => 'E-mail',
                    'rules' => 'trim|required|is_unique[usuario.email]|valid_email'
                ),
                array(
                    'field' => 'contrasena',
                    'label' => 'Contraseña',
                    'rules' => 'trim|required|min_length[6],callback_validarPass'
                ),
                array(
                    'field' => 'CContrasena',
                    'label' => 'Confirmar Contraseña',
                    'rules' => 'trim|required|matches[contrasena]'
                )
            );
            $this->load->library('form_validation');
            $this->form_validation->set_rules($config);
            $this->form_validation->set_message('required', 'El campo %s es requerido');
            $this->form_validation->set_message('is_unique', 'Este %s ya esta registrado');
            $this->form_validation->set_message('matches', 'El campo %s no coincide');
            $this->form_validation->set_message('valid_email', 'El campo %s no corresponde a un Email');
            $this->form_validation->set_message('trim', 'Caracteres Invalidos');
            $this->form_validation->set_message('min_length', 'El campo %s debe tener al menos 6 caracteres');
            return $this->form_validation->run();
    }
    public function cargarprograma(){
        $id=$this->input->post("id",true);
        $datos=$this->estudianteModelo->cargarProgramas($id);
        echo '<option value="">Seleccione un programa</option>';
        foreach ($datos->result_array() as $row) {
             echo  '<option value="'.$row['id_programa'].'">'.$row['nombre_programa'].'</option>';
        }
    }
    function validarPass($str){
        $banMin=FALSE;
        $banMay=FALSE;
        $banEsp=FALSE;
        $banNum=FALSE;
        for($i=0; $i<strlen($str);$i++){
            if(ord($str[$i])>=33 && ord($str[$i])<=47){
                $banEsp=TRUE;
            }
            if(ord($str[$i])>=65 && ord($str[$i])<=90){
                $banMay=TRUE;
            }
            if(ord($str[$i])>=97 && ord($str[$i])<=122){
                $banMin=TRUE;
            }
            if(ord($str[$i])>=48 && ord($str[$i])<=57){
                $banNum=TRUE;
            }
        }
        if($banEsp==TRUE && $banMay==TRUE && $banMin==TRUE && $banNum==TRUE){
            return TRUE;
        }
        else{
            $this->form_validation->set_message('validarPass', 'Su contraseña debe contener caracteres: Mayuscula, Minuscula,Numero y Especial');
            return FALSE;
        }
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
}
?>
