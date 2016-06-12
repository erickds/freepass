<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Log_model extends CI_Model {

    public function insert($log) {
        if ($this->db->insert('logs', $log)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function list_logs() {
        //select * from logs
        $this->db->from('logs');
        //setando query
        $logs = $this->db->get();

        if ($logs->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $logs->result();
        } else {
            return FALSE;
        }
    }

    public function list_logs_of_rfid($rfid) {
        //select * from logs
        $this->db->from('logs');

        $this->db->where('id_cartao', $rfid);
        //setando query
        $logs = $this->db->get();

        if ($logs->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $logs->result();
        } else {
            return FALSE;
        }
    }

    public function list_logs_of_user($id) {
        //select * from logs
        $this->db->from('logs');

        $this->db->where('id_pessoa', $id);
        //setando query
        $logs = $this->db->get();

        if ($logs->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $logs->result();
        } else {
            return FALSE;
        }
    }

}
