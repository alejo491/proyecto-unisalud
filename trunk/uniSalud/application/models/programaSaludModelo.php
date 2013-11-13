<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class programaSaludModelo extends CI_Model {
    
        function __construct() {
        parent::__construct();
    }
     function obtenerProgramas($limite=NULL,$inicio=NULL){
        if($limite!=NULL){
            $this->db->limit($limite,$inicio);
        }
        $this->db->select('id_programasalud,costo,tipo_servicio,actividad');
        $this->db->from('programasalud');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
    }
    function ingresarProgramaSalud($programa){
        return $this->db->insert('programasalud',$programa);
    }
    function buscarPrograma($id){
        $this->db->limit(1);
        $this->db->select('id_programasalud,costo,tipo_servicio,actividad');
        $this->db->where('id_programasalud',$id);
        $this->db->from('programasalud');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta->row();
        }
        else{
            return FALSE;
        }
    }
    function editarProgramaSalud($datos){
        $this->db->where('id_programasalud', $datos['id_programasalud']);
        return $this->db->update('programasalud', $datos);
    }
    function eliminarProgramaSalud($id){
        $this->db->where('id_programasalud', $id);
        $this->db->limit(1);
        return $this->db->delete('programasalud');
    }
}
?>
