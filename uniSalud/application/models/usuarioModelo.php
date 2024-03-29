<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usuarioModelo extends CI_Model {

    //constructor de la clase
    function __construct() {
        parent::__construct();
    }
    
    //ingresa una tupla en la tabla usuario y posee
    function registrar($data) {
        $this->db->insert('usuario', $data);
        $this->db->select('id_usuario')->from('usuario')->where('email',$data['email']);
        $this->db->limit(1);     
        $query=$this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){
                $id_usu= $row->id_usuario;
            }
        }
        $insert='INSERT INTO POSEE (ID_USUARIO,ID_ROL)VALUES ('.$id_usu.', 1)';
        $this->db->query($insert);
        
    }

    //verifica el inicio de sesion
    public function login($str1, $str2) {
        $email = mysql_real_escape_string($str1);
        $contrasena = mysql_real_escape_string($str2);
        $where = array(
            'email' => $email,
            'contrasena' => $contrasena
        );
        $this->db->select()->from('usuario')->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0) { 
            return $query->first_row('array');
        } else {
            return FALSE;
        }
    }
    
    public function Existe($e){
        $email = mysql_real_escape_string($e);
        $where = array(
            'email' => $email,
        );
        $this->db->select()->from('usuario')->where($where);
        $query = $this->db->get();
        if ($query->num_rows() > 0) { 
            return FALSE;
        } else {
            return TRUE;
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
    function getId($str){
        $this->db->select('id_persona')->from('usuario')->where('id_usuario',$str);
        $this->db->limit(1);     
        $query=$this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row){
               return $row->id_persona;
            }
        }else{
            
            return FALSE;
        }
    }
}