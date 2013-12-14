<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class consultorioModelo extends CI_Model {
    
        function __construct() {
        parent::__construct();
    }
    function obtenerConsultorios($limite=NULL,$inicio=NULL){
        if($limite!=NULL){
            $this->db->limit($limite,$inicio);
        }
        $this->db->select('id_consultorio,numero_consultorio,descripcion');
        $this->db->from('consultorio');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
    }
    function ingresarConsultorio($consultorio){
        return $this->db->insert('consultorio',$consultorio);
    }
    function buscarConsultorio($id){
        $this->db->limit(1);
        $this->db->select('id_consultorio,numero_consultorio,descripcion');
        $this->db->where('id_consultorio',$id);
        $this->db->from('consultorio');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta->row();
        }
        else{
            return FALSE;
        }
    }
    function editarConsultorio($data){
        $this->db->where('id_consultorio', $data['id_consultorio']);
        return $this->db->update('consultorio', $data);
    }
    function eliminarConsultorio($id){
        $this->db->where('id_consultorio', $id);
        $this->db->limit(1);
        
        return $this->db->delete('consultorio');
        
    }
    
    function validar_e($id){
        $this->db->limit(1);
        $this->db->select('id_consultorio');
        $this->db->where('id_consultorio',$id);
        $this->db->from('personalsalud');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return FALSE;
        }
        else{
            return TRUE;
        }
        
    }
    function buscarFiltradoConsultorio($filtro,$limite=NULL,$inicio=NULL ){
        if($limite!=NULL){
            $this->db->limit($limite,$inicio);
        }
        if(strcmp($filtro['numero_consultorio'], '')!=0){
            $this->db->like('numero_consultorio',$filtro['numero_consultorio']);
        }
        if(strcmp($filtro['descripcion'], '')!=0){
            $this->db->like('descripcion',$filtro['descripcion']);
        }
        $this->db->select('id_consultorio,numero_consultorio,descripcion');
        $this->db->from('consultorio');
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