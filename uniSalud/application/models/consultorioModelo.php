<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class consultorioModelo extends CI_Model {
    
        function __construct() {
        parent::__construct();
    }
function obtenerConsultorios() {
        $sql = "SELECT id_consultorio,numero_consultorio FROM consultorio ORDER BY numero_consultorio";
        $query = $this->db->query($sql);
        $data = array();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data[$row['id_consultorio']] = ($row['numero_consultorio']);
            }
            return $data;
        }
        $query->free_result();
        return $data;
    }
}
?>