<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class usuariosModel extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    

    function registrar($data) {
        $id = $this->db->insert('usuario', $data);
        return $id;
    }

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

   

}