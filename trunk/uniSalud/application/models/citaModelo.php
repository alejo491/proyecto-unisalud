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
    
    function obtenerCitas($id=NULL,$limite=NULL,$inicio=NULL){
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
    
    function estudiantesPorPrograma($tipo_servicio){
        $this->db->select('COUNT( identificacion ) as numero , nombre_programa');
        $this->db->from('estudiante');
        $this->db->join('cita','estudiante.id_estudiante=cita.id_estudiante');
        $this->db->join('programa','estudiante.id_programa=programa.id_programa');
        $this->db->join('programasalud','cita.id_programasalud=programasalud.id_programasalud');
        $this->db->where('tipo_servicio', $tipo_servicio);
        $this->db->group_by('programa.id_programa');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
        
    }
    function estudiantesPorFacultad($tipo_servicio){
        $this->db->select('COUNT( identificacion ) as numero , nombre_facultad');
        $this->db->from('estudiante');
        
        $this->db->join('cita','estudiante.id_estudiante=cita.id_estudiante');
        $this->db->join('programa','estudiante.id_programa=programa.id_programa');
        $this->db->join('programasalud','cita.id_programasalud=programasalud.id_programasalud');
        $this->db->join('facultad','programa.id_facultad=facultad.id_facultad');
        $this->db->where('tipo_servicio', $tipo_servicio);
        $this->db->group_by('facultad.id_facultad');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }   
    }
    function servicioMasSolicitado(){
        $sql = "SELECT tipo_servicio FROM ( SELECT * FROM ( SELECT COUNT( id_estudiante ) AS numero1, tipo_servicio FROM cita NATURAL JOIN programasalud GROUP BY id_programasalud ) AS t ) AS x WHERE numero1 = ( SELECT MAX( numero ) AS numero2 FROM ( SELECT COUNT( id_estudiante ) AS numero FROM cita NATURAL JOIN programasalud GROUP BY id_programasalud ) AS tabla ) ";
        $query = $this->db->query($sql);
        
        if ($query->num_rows() > 0) {
            
            return $query;
        }
        else{
            return FALSE;
        } 
    }
    function estudiantesPorFecha($dia,$medico){
        $this->db->select('identificacion,primer_nombre,primer_apellido,hora_inicio,observaciones');
        $this->db->from('cita');
        $this->db->join('estudiante','estudiante.id_estudiante=cita.id_estudiante');
        $where=array(
            'dia'=>$dia,
            'estado'=>0,
            'id_personalsalud'=>$medico
        );
        $this->db->where($where);
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
