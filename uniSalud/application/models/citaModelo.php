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
    
    function obtenerCitas($limite=NULL,$inicio=NULL,$id=NULL){
        if($limite!=NULL){
            $this->db->limit($limite,$inicio);
        }
        if($id!=NULL){
            $this->db->where('cita.id_estudiante',$id);
        }
        $this->db->select('cita.id_estudiante,cita.id_programasalud,cita.id_personalsalud,cita.hora_inicio,cita.hora_fin,cita.estado,cita.dia, estudiante.primer_nombre AS pnestudiante,estudiante.primer_apellido AS paestudiante, estudiante.identificacion AS idestudiante, personalsalud.primer_nombre AS pnpersonal, personalsalud.primer_apellido AS papersonal, personalsalud.identificacion AS idpersonal,programasalud.tipo_servicio AS tipo_servicio, programasalud.actividad AS actividad ');
        $this->db->from('cita');
        $this->db->join('estudiante','cita.id_estudiante=estudiante.id_estudiante');
        $this->db->join('personalsalud','cita.id_personalsalud=personalsalud.id_personalsalud');
        $this->db->join('programasalud','cita.id_programasalud=programasalud.id_programasalud');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
    }
    function activarCita($id_cita){
        $id_estudiante=$id_cita[0];
        $id_personalsalud=$id_cita[1];
        $id_programasalud=$id_cita[2];
        $this->db->limit(1);
        $this->db->where('id_estudiante', $id_estudiante);
        $this->db->where('id_personalsalud', $id_personalsalud);
        $this->db->where('id_programasalud', $id_programasalud);
        return $this->db->update('cita','estado = 1');
    }
    
    function cancelarCita($id_cita){
        $id_estudiante=$id_cita[0];
        $id_personalsalud=$id_cita[1];
        $id_programasalud=$id_cita[2];
        $this->db->limit(1);
        $this->db->where('id_estudiante', $id_estudiante);
        $this->db->where('id_personalsalud', $id_personalsalud);
        $this->db->where('id_programasalud', $id_programasalud);
        return $this->db->delete('cita');
    }
}
?>
