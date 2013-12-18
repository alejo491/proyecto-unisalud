<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class programaSaludModelo extends CI_Model {
    
    //constructor de la clase
        function __construct() {
        parent::__construct();
    }
    
    //obtiene la lista de los programas de salud de la tabla programasalud en la base de datos
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
    
    //ingresa una tupla en la tabla programasalud en la base de datos
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
    //edita una tupla especifica en la tabla programasalud
    function editarProgramaSalud($datos){
        $this->db->where('id_programasalud', $datos['id_programasalud']);
        return $this->db->update('programasalud', $datos);
    }
    //elimina un programa de salud especifico en la tabla programasalud
    function eliminarProgramaSalud($id){
        $this->db->where('id_programasalud', $id);
        $this->db->limit(1);
        return $this->db->delete('programasalud');
    }
    //busca mediante un filtro la lista de programas de salud que lo cumplan en la tabla programasalud
    function buscarFiltradoProgramaSalud($filtro,$limite=NULL,$inicio=NULL ){
        if($limite!=NULL){
            $this->db->limit($limite,$inicio);
        }
        if(strcmp($filtro['tipo_servicio'], '')!=0){
            $this->db->like('tipo_servicio',$filtro['tipo_servicio']);
        }
        if(strcmp($filtro['actividad'], '')!=0){
            $this->db->like('actividad',$filtro['actividad']);
        }
        if(strcmp($filtro['costo'], '')!=0){
            $this->db->like('costo',$filtro['costo']);
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
    function obtenerActividad($idProg){
        $this->db->select('actividad');
        $this->db->where('id_programasalud',$idProg);
        $this->db->from('programasalud');
        $this->db->limit(1);
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
