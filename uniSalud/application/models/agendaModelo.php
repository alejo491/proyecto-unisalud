<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class agendaModelo extends CI_Model {

    //constructor de la funcion
    function __construct() {
        parent::__construct();
    }
    
    //obtener un horario de atencion
    public function getHoras($idPersonal,$idAgenda){
        $this->db->limit(1);
        $this->db->where('id_agenda', $idAgenda);
        $this->db->where('id_personalsalud', $idPersonal);
        $data = $this->db->get('horarioatencion');
        if ($data->num_rows() > 0) {
            return $data->first_row('array');
        } else {
            return FALSE;
        }
    }
    
    //obtener la agenda del personal de salud
    public function obtenerAgenda($id,$limite=NULL,$inicio=NULL){
        if($limite!=NULL){
            $this->db->limit($limite,$inicio);
        }
        $this->db->select('id_agenda,id_personalsalud,dia,hora_inicial,hora_final');
        $this->db->where('id_personalsalud',$id);
        $this->db->from('horarioatencion');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
    }
    
    //ingresar un horario a la tabla horario de atencion en la base de datos
    function ingresarHorarioAgenda($horario){
        return $this->db->insert('horarioatencion',$horario);
    }
    
    //Obtener un horario de la tabla horario de atencion de la base de datos
    function obtenerHorarioAtencion($id){
        $this->db->limit(1);
        $this->db->select('id_agenda,id_personalsalud,dia,hora_inicial,hora_final');
        $this->db->where('id_agenda',$id);
        $this->db->from('horarioatencion');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta->row();
        }
        else{
            return FALSE;
        }
    }
    
    //editar el horario en la tabla horario de atencion de la base de datos
    function actualizarHorarioAtencion($data){
        $this->db->where('id_agenda', $data['id_agenda']);
        return $this->db->update('horarioatencion', $data);
    }
    
    //eliminar un horario en la tabla horario de atencion de la base de datos
    function eliminarHorario($id){
        $this->db->where('id_agenda', $id);
        $this->db->limit(1);
        return $this->db->delete('horarioatencion');
    }
}
?>