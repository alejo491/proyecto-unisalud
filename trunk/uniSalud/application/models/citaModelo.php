<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class citaModelo extends CI_Model {
    function __construct() {
        parent::__construct();
    }
    function ingresarReservaCita($info_reserva){
        return $this->db->insert('cita',$info_reserva);
    }
    
    function tieneCita($id){
        
        $this->db->limit(1);
        $this->db->select('id_estudiante');
        $this->db->where('id_estudiante',$id);
        $this->db->from('cita');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta->row();
        }
        else{
            return FALSE;
        }
    }
}
?>
