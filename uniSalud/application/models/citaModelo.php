<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class citaModelo extends CI_Model {
    
    //constructor de la clase
    function __construct() {
        parent::__construct();
    }
    
    //ingresa una cita a la base de datos
    function ingresarReservaCita($info_reserva){
        return $this->db->insert('cita',$info_reserva);
    }
    
    //verifica si el estudiante tiene cita con un personal de salud especifico
    function tieneCita($id,$id2){
        
        $where=array(
         'id_estudiante'=>$id,
         'id_personalsalud'=>$id2
                );
        $this->db->limit(1);
        $this->db->select('id_estudiante');
        $this->db->where($where);
        $this->db->from('cita');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta->row();
        }
        else{
            return FALSE;
        }
    }
    
    function verificarActividad($actividad){
        
        $sql = "SELECT * FROM CITA NATURAL JOIN PROGRAMASALUD WHERE ESTADO <>3 AND ESTADO <>4 AND ACTIVIDAD = '".$actividad."'";
        $query = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            
            return TRUE;
        }
        else{
            return FALSE;
        }
        
    }
    //obtiene los programas en los cuales el estudiante ha reservado una cita
    function obtenerProgramas($idEst){
        $this->db->select('id_programasalud');
        $this->db->where('id_estudiante',$idEst);
        $this->db->from('cita');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
    }
}
?>
