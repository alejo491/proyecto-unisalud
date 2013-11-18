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
    function ingresarPersonalSalud($personal,$pro=NULL){
        
        unset($personal['id_programasalud']);
        $this->db->insert('personalsalud',$personal);
        if($pro!=NULL){
            $this->db->select('id_personalsalud');
            $this->db->limit(1);
            $this->db->where('identificacion',$personal['identificacion']);
            $this->db->from('personalsalud');
            $personalsalud=$this->db->get()->row();
            $progra=explode(',',$pro);
            foreach ($progra as $programasalud):
                $query="INSERT INTO atiende (id_personalsalud,id_programasalud) VALUES (".$personalsalud->id_personalsalud.",".$programasalud.")";
                $this->db->query($query);    
            endforeach;
        }
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
            return NULL;
        }
    }
    
    function programasPersonal($id){
        
        $this->db->select('id_programasalud');
        $this->db->where('id_personalsalud',$id);
        $this->db->from('atiende');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
    }
    function editarPersonalSalud($datos,$pro=NULL){
        
        
        if($pro!=NULL){
            $progra=explode(',',$pro);
            $this->db->where('id_personalsalud',$datos['id_personalsalud']);
            $this->db->delete('atiende');
            foreach ($progra as $programasalud):
                $query="INSERT INTO atiende (id_personalsalud,id_programasalud) VALUES (".$datos['id_personalsalud'].",".$programasalud.")";
                $this->db->query($query);    
            endforeach;    
        }
        
        $this->db->where('id_personalsalud', $datos['id_personalsalud']);
        return $this->db->update('personalsalud', $datos);
    }
    function eliminarPersonalSalud($id){
        $this->db->where('id_personalsalud', $id);
        $this->db->limit(1);
        return $this->db->delete('personalsalud');
    }
    function buscarFiltradoPersonalSalud($filtro,$limite=NULL,$inicio=NULL){
        if($limite!=NULL){
            $this->db->limit($limite,$inicio);
        }
        if(strcmp($filtro['primer_nombre'],'')!=0){
            $this->db->like('primer_nombre',$filtro['primer_nombre']);
        }
        if(strcmp($filtro['primer_apellido'],'')!=0){
            $this->db->like('primer_apellido',$filtro['primer_apellido']);
        }
        if(strcmp($filtro['identificacion'],'')!=0){
            $this->db->like('identificacion',$filtro['identificacion']);
        }
        if(strcmp($filtro['especialidad'],'')!=0){
            $this->db->like('especialidad',$filtro['especialidad']);
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
    
    function verificar_citas($id){
        
        $query="SELECT * FROM cita NATURAL JOIN personalsalud WHERE id_personalsalud =$id";
        $consulta=$this->db->query($query);
        if($consulta->num_rows()>0){
            return FALSE;
        }
        else{
            return TRUE;
        }
    }
}
?>
