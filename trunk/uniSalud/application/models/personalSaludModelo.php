<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class personalSaludModelo extends CI_Model {
    
        function __construct() {
        parent::__construct();
    }
     function obtenerPersonalSalud($limite=NULL,$inicio=NULL){
        if($limite!=NULL){
            $this->db->limit($limite,$inicio);
        }
        $this->db->select('id_personalsalud,id_consultorio,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,identificacion,tipo_identificacion,numero_tarjeta,especialidad');
        $this->db->from('personalsalud');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
    }
    function ingresarPersonalSalud($personal){
        return $this->db->insert('personalsalud',$personal);
    }
    function buscarPersonal($id){
        $this->db->limit(1);
        $this->db->select('id_personalsalud,id_consultorio,primer_nombre,segundo_nombre,primer_apellido,segundo_apellido,identificacion,tipo_identificacion,numero_tarjeta,especialidad');
        $this->db->where('id_personalsalud',$id);
        $this->db->from('personalsalud');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta->row();
        }
        else{
            return FALSE;
        }
    }
    function editarPersonalSalud($datos){
        $this->db->where('id_personalsalud', $datos['id_personalsalud']);
        return $this->db->update('personalsalud', $datos);
    }
    function eliminarPersonalSalud($id){
        $this->db->where('id_personalsalud', $id);
        $this->db->limit(1);
        return $this->db->delete('personalsalud');
    }
}
?>
