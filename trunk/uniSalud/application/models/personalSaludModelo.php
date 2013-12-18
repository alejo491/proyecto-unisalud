<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class personalSaludModelo extends CI_Model {
    
    //constructor de la clase
        function __construct() {
        parent::__construct();
    }
    
    //obtiene las tuplas de la tabla personal de salud en la base de datos
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
    
    //ingresa una tupla en la tabla programasalud en la base de datos
    function ingresarPersonalSalud($personal,$pro=NULL){
        
        unset($personal['id_programasalud']);
        $bandera=$this->db->insert('personalsalud',$personal);
        if($bandera){
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
                return TRUE;
            }else{
                
                return FALSE;
            }
        }else{
            
            return FALSE;
        }
    }
    
    //busca los datos en la tabla personalsalud con un id especifico en la base de datos
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
    
    //obtiene la lista de programas deste la tabla atiende, de un personal de salud especifico
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
    //edita una tupla en la tabla personalsalud en la base de datos
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
    //elimina una tupla especifica de la tabla personalsalud en la base de datos
    function eliminarPersonalSalud($id){
        $this->db->where('id_personalsalud', $id);
        $this->db->limit(1);
        return $this->db->delete('personalsalud');
    }
    
    //busca mediante un filtro las tuplas que se acomoden al mismo de la tabla personalsalud en la base de datos
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
    function buscarPersonalSaludPrograma($idPrograma){
        $this->db->select('atiende.id_personalsalud AS id_personalsalud, primer_nombre,primer_apellido');
        $this->db->from('personalsalud');
        $this->db->join('atiende', 'atiende.id_personalsalud = personalsalud.id_personalsalud');
        $this->db->where('atiende.id_programasalud',$idPrograma);
        $data = $this->db->get();
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }
    function obtenerCitas($idPersonal,$fecha){
        $this->db->select('hora_inicio','hora_fin');
        $this->db->from('cita');
        $this->db->order_by("hora_inicio", "asc");
        $this->db->where('id_personalsalud',$idPersonal);
        $this->db->where('dia',$fecha);
        $data=$this->db->get();
        $str=$this->db->last_query();
        echo "<script>alert('$str');</script>";
        if ($data->num_rows() > 0) {
            return $data;
        } else {
            return FALSE;
        }
    }
    function obtenerDiasDisp($idPersonal){
        $this->db->select('id_agenda,id_personalsalud,dia');
        $this->db->where('id_personalsalud',$idPersonal);
        $this->db->group_by('dia');
        $this->db->from('horarioatencion');
        $consulta=$this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
    }
    function obtenerHorarioDia($dia,$idPersonal){
        $this->db->select('dia,hora_inicial,hora_final');
        $this->db->where('id_personalsalud',$idPersonal);
        $this->db->where('dia',$dia);
        $this->db->order_by('hora_inicial','asc');
        $this->db->from('horarioatencion');
        $consulta=  $this->db->get();
        if($consulta->num_rows()>0){
            return $consulta;
        }
        else{
            return FALSE;
        }
    }
}
?>
