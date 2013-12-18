<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class consultorioModelo extends CI_Model {
    
    //constructor de la clase
        function __construct() {
        parent::__construct();
    }
    
    //Obtiene el listado de los consultorios existentes en la base de datos
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
    
    //ingresa un consultorio a la tabla consultorio en la base de datos
    function ingresarConsultorio($consultorio){
        return $this->db->insert('consultorio',$consultorio);
    }
    
    //busca un consultorio segun su id en la tabla consultorio de la base de datos
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
    
    //edita una tupla especifica en la tabla consultorio de la base de datos
    function editarConsultorio($data){
        $this->db->where('id_consultorio', $data['id_consultorio']);
        return $this->db->update('consultorio', $data);
    }
    
    //elimina una tupla especifica en la tabla consultorio en la base de datos
    function eliminarConsultorio($id){
        $this->db->where('id_consultorio', $id);
        $this->db->limit(1);
        
        return $this->db->delete('consultorio');
        
    }
    
    //valida si existe o no el consultorio en la tabla personal salud
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
    
    //busca un consultorio mediante un filtro en la tabla consultorio de la base de datos
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