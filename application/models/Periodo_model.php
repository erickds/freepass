<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Periodo_model extends CI_Model {

    public function update($periodo) {
        $this->db->where('idperiodo', $periodo['idperiodo']);
        if ($this->db->update('periodos', $periodo)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insert($periodo) {
        if ($this->db->insert('periodos', $periodo)) {
            return $insert_id = $this->db->insert_id();
        } else {
            return FALSE;
        }
    }

    public function insert_pessoa_periodos($id, $idperiodos) {
        foreach ($idperiodos as $idperiodo) {
            $periodo['idPessoa'] = $id;
            $periodo['idPeriodo'] = $idperiodo;
            $this->db->insert('pessoa_periodo', $periodo);
        }
        return $insert_id = $this->db->insert_id();
    }
    
    public function insert_periodo_horarios($id, $idhorarios) {
        foreach ($idhorarios as $idhorario) {
            $periodo['idPeriodo'] = $id;
            $periodo['idHorario'] = $idhorario;
            $this->db->insert('Periodo_Horario', $periodo);
        }
        return $insert_id = $this->db->insert_id();
    }
}
