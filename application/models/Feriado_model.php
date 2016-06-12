<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Feriado_model extends CI_Model {

    public function update($feriado) {
        $this->db->where('idferiado', $feriado['idferiado']);
        if ($this->db->update('feriados', $feriado)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insert($feriado) {
        if ($this->db->insert('feriados', $feriado)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
