<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class estudianteModelo extends CI_Model {

    function __construct() {
        parent::__construct();
    }
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

    //
    //
    //
    //Copiado desde programaSaludModelo
    //
    //
    ///*
    
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
    function ingresarProgramaSalud($programa){
        return $this->db->insert('programasalud',$programa);
    }
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
    function editarProgramaSalud($datos){
        $this->db->where('id_programasalud', $datos['id_programasalud']);
        return $this->db->update('programasalud', $datos);
    }
    function eliminarProgramaSalud($id){
        $this->db->where('id_programasalud', $id);
        $this->db->limit(1);
        return $this->db->delete('programasalud');
    }
    function buscarFiltradoProgramaSalud($filtro,$limite=NULL,$inicio=NULL ){
        if($limite!=NULL){
            $this->db->limit($limite,$inicio);
        }
        if(strcmp($filtro['tipo_servicio'], '')!=0){
            $this->db->like('tipo_servicio',$filtro['tipo_servicio']);
        }
        if(strcmp($filtro['actividad'], '')!=0){
            $this->db->like('actividad',$filtro['actividad']);
        }
        if(strcmp($filtro['costo'], '')!=0){
            $this->db->like('costo',$filtro['costo']);
        }
        $this->db->select('id_programasalud,costo,tipo_servicio,actividad');
        $this->db->from('programasalud');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
    }

}