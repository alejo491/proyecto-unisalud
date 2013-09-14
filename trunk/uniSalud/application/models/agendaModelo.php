<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class agendaModelo extends CI_Model {
    
        function __construct() {
        parent::__construct();
    }
    function getMedico($id_medico){
        $data = array();
        $this->db->select('id_medico, numero_tarjeta, identificacion, nombre_medico');
        $this->db->from('medico');
        $this->db->where('id_medico', $id_medico);
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