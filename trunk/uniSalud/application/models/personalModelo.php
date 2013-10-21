<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class personalModelo extends CI_Model {
    // cambiar a personalModelo
    
        function __construct() {
        parent::__construct();
    }
    function getMedico($id_medico){
        $data = array();
        $this->db->select('id_personalsalud,id_consultorio, numero_tarjeta, identificacion, primer_nombre,primer_apellido,especialidad');
        $this->db->from('personalsalud');
        $this->db->where('id_personalsalud', $id_medico);
        $this->db->limit(1);
        $consulta = $this->db->get();
        if ($consulta->num_rows() > 0) {
            $data = $consulta->row();
        }
        $consulta->free_result();
        return $data;
    }
}
?>