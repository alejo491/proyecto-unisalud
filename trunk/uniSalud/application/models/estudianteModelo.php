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
   

}