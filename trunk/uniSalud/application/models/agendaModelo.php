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
}
?>