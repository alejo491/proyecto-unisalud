<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class agendaModelo extends CI_Model {

    function __construct() {
        parent::__construct();
    }
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
    function ingresarHorarioAgenda($horario){
        return $this->db->insert('horarioatencion',$horario);
    }
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
    function actualizarHorarioAtencion($data){
        $this->db->where('id_agenda', $data['id_agenda']);
        return $this->db->update('horarioatencion', $data);
    }
    function eliminarHorario($id){
        $this->db->where('id_agenda', $id);
        $this->db->limit(1);
        return $this->db->delete('horarioatencion');
    }
}
?>