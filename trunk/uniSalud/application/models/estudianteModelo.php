<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class estudianteModelo extends CI_Model {

    //constructor de la clase
    function __construct() {
        parent::__construct();
    }
    
    //registra un estudiante en la tabla estudiante 
    function registrar($data) {
        $this->db->insert('estudiante', $data);
        $this->db->select('id_estudiante')->from('estudiante')->where('identificacion',$data['identificacion']);
        $this->db->limit(1);     
        $query=$this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){
                return $row->id_estudiante;
            }
        }
        else{
            return FALSE;
        }
    }

    //verifica el inicio de sesion para un estudiante
    public function login($str1, $str2) {
        $email = mysql_real_escape_string($str1);
        $contrasena = mysql_real_escape_string($str2);
        $where = array(
            'email' => $email,
            'contrasena' => $contrasena
        );
        $this->db->select()->from('estudiante')->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
           
            return $query->first_row('array');
        } else {
            return FALSE;
        }
    }
    
    //obtiene el rol que tiene dentro del sistema
    function getRol($str) {
        $id_usuario =  mysql_real_escape_string($str);
        $this->db->limit(1);
        $this->db->where('id_usuario', $id_usuario);
        $data = $this->db->get('posee');
        if ($data->num_rows() > 0) {
            return $data->first_row('array');
        } else {
            return FALSE;
        }
    }
    
    //obtiene las facultades que se encuentran en la tabla facultad
      function cargarFacultad() {

        $sql = "SELECT id_facultad, nombre_facultad FROM facultad ORDER BY nombre_facultad";
        $query = $this->db->query($sql);
        $facultades = array();
        if ($query->num_rows() > 0) {
            
            
            return $query;
        }
        
        
    }
    
    function cargarProgramas($id) {

        $sql = "SELECT id_programa, nombre_programa FROM programa WHERE id_facultad=$id ORDER BY nombre_programa";
        $query = $this->db->query($sql);
        $facultades = array();
        if ($query->num_rows() > 0) {
            
            return $query;
        }
        
    }
    
    //obtiene el nombre de un programa segun su id en la tabla programa
    function programaEstudiante($str){
       
        $this->db->select('nombre_programa')->from('programa')->where('id_programa',$str);
        $this->db->limit(1);     
        $query=$this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){
                return $row->nombre_programa;
            }
        }
        else{
            return FALSE;
        }
        
    }
    
    //obtiene la lista de estudiante que existen actualmente en la tabla estudiante
    function obtenerEstudiantes($limite=NULL,$inicio=NULL){
        if($limite!=NULL){
            $this->db->limit($limite,$inicio);
        }
        $this->db->select('id_estudiante,primer_nombre,primer_apellido,identificacion,tipo_identificacion,genero,fecha_nacimiento');
        $this->db->from('estudiante');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
    }
    /*
    function ingresarProgramaSalud($programa){
        return $this->db->insert('programasalud',$programa);
    }*/
    
    //obtiene los datos de un estudiante especifico de la tabla estudiante
    function buscarEstudiante($id){
        $this->db->limit(1);
        $this->db->select('id_estudiante,id_programa,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,identificacion,tipo_identificacion,genero,fecha_nacimiento');
        $this->db->where('id_estudiante',$id);
        $this->db->from('estudiante');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta->row();
        }
        else{
            return FALSE;
        }
    }
    /*function editarProgramaSalud($datos){
        $this->db->where('id_programasalud', $datos['id_programasalud']);
        return $this->db->update('programasalud', $datos);
    }
    function eliminarProgramaSalud($id){
        $this->db->where('id_programasalud', $id);
        $this->db->limit(1);
        return $this->db->delete('programasalud');
    }*/
    
    //busca mediente un filstro una lista de estudiantes que cumplan dicho filtro en la tabla estudiante
    function buscarFiltradoEstudiante($filtro,$limite=NULL,$inicio=NULL ){
        if($limite!=NULL){
            $this->db->limit($limite,$inicio);
        }
        if(strcmp($filtro['id_estudiante'], '')!=0){
            $this->db->like('id_estudiante',$filtro['id_estudiante']);
        }
        if(strcmp($filtro['primer_nombre'], '')!=0){
            $this->db->like('primer_nombre',$filtro['primer_nombre']);
        }
        if(strcmp($filtro['primer_apellido'], '')!=0){
            $this->db->like('primer_apellido',$filtro['primer_apellido']);
        }
        if(strcmp($filtro['identificacion'], '')!=0){
            $this->db->like('identificacion',$filtro['identificacion']);
        }
        $this->db->select('id_estudiante,primer_nombre,primer_apellido,identificacion');
        $this->db->from('estudiante');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
    }

}