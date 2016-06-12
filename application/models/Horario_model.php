<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Horario_model extends CI_Model {

    public function update($horario) {
        $this->db->where('idhorario', $horario['idhorario']);
        if ($this->db->update('horarios', $horario)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insert($horario) {
        if ($this->db->insert('horarios', $horario)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
