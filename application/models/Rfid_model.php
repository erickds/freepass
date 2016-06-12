<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Rfid_model extends CI_Model {

    public function check_rfid($rfid) {
        //select * from rfid
        $this->db->from('rfid r');
        //join Pessoa p on r.id_pessoa=p.id
        $this->db->join('Pessoa p', 'r.id_pessoa=p.id', 'left');
        //setando query
        $this->db->where('r.rfid', $rfid);
        $this->db->where('r.rfidActive', "1");
        $this->db->where('p.isActive', "1");
        $res_ok = $this->db->get();
        if ($res_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $res_ok->result();
        } else {
            return FALSE;
        }
    }

    public function check_rfid_exists($rfid) {
        //select * from rfid
        $this->db->from('rfid');
        $this->db->where('rfid', $rfid);

        $res_ok = $this->db->get();
        if ($res_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $res_ok->result();
        } else {
            return FALSE;
        }
    }

    public function check_pin_exists($pin) {
        //select * from rfid
        $this->db->from('pendentes');
        $this->db->where('pin', $pin);

        $res_ok = $this->db->get();
        if ($res_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $res_ok->result();
        } else {
            return FALSE;
        }
    }

    public function select_pin($rfid) {
        //select * from rfid
        $this->db->from('pendentes');
        $this->db->where('rfid', $rfid);

        $res_ok = $this->db->get();
        if ($res_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $res_ok->result();
        } else {
            return FALSE;
        }
    }

    public function check_rfid_pendente($rfid) {
        //select * from rfid
        $this->db->from('pendentes');
        $this->db->where('rfid', $rfid);

        $res_ok = $this->db->get();
        if ($res_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $res_ok->result();
        } else {
            return FALSE;
        }
    }

    public function update($user_rfid) {
        //removendo campo cpf que não pode ser alterado
        //array_shift($user);
        $this->db->where('rfid', $user_rfid['rfid']);
        if ($this->db->update('rfid', $user_rfid)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insert_rfid_pendente($rfid_pendente) {
        if ($this->db->insert('pendentes', $rfid_pendente)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function insert_rfid($rfid) {
        if ($this->db->insert('rfid', $rfid)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
