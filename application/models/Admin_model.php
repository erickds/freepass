<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function check_login($email, $pwd) {
        //select * from rfid
        $this->db->from('Pessoa p');

        //setando query
        $this->db->where('email', $email);
        $this->db->where('senha', $pwd);
        $user_ok = $this->db->get();
        if ($user_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $user_ok->result();
        } else {
            return FALSE;
        }
    }

    public function select_user($id) {
        //select * from pessoa
        $this->db->from('Pessoa p');
        $this->db->where('p.id', $id);
        //setando query
        $user_ok = $this->db->get();
        if ($user_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com o usuário.
            return $user_ok->result();
        } else {
            return FALSE;
        }
    }

    public function select_horario($id) {
        //select * from pessoa
        $this->db->from('Horarios h');
        $this->db->where('h.idhorario', $id);
        //setando query
        $user_ok = $this->db->get();
        if ($user_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com o usuário.
            return $user_ok->result();
        } else {
            return FALSE;
        }
    }

    public function select_periodo($id) {
        //select * from pessoa
        $this->db->from('Periodos p');
        $this->db->where('p.idperiodo', $id);
        //setando query
        $user_ok = $this->db->get();
        if ($user_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com o usuário.
            return $user_ok->result();
        } else {
            return FALSE;
        }
    }

    public function select_feriado($id) {
        //select * from pessoa
        $this->db->from('Feriados f');
        $this->db->where('f.idferiado', $id);
        //setando query
        $user_ok = $this->db->get();
        if ($user_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com o usuário.
            return $user_ok->result();
        } else {
            return FALSE;
        }
    }

    public function select_user_cpf($cpf) {
        //select * from pessoa
        $this->db->from('Pessoa p');
        $this->db->where('p.cpf', $cpf);
        //setando query
        $user_ok = $this->db->get();
        if ($user_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com o usuário.
            return $user_ok->result();
        } else {
            return FALSE;
        }
    }

    public function select_rfid_user($rfid) {
        //select * from rfid
        $this->db->from('Rfid r');
        //join Pessoa p on r.id_pessoa=p.id
        //para pegar apenas usuarios utilizando rfid linha comentada abaixo
        $this->db->join('Pessoa p', 'r.id_pessoa=p.id', 'left');

        $this->db->where('r.rfid', $rfid);
        //setando query
        $rfid_user_ok = $this->db->get();

        if ($rfid_user_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $rfid_user_ok->result();
        } else {
            return FALSE;
        }
    }

    public function select_rfid_pendente($rfid) {
        //select * from rfid
        $this->db->from('Pendentes r');
        $this->db->where('r.rfid', $rfid);
        //setando query
        $rfid_pendente = $this->db->get();
        if ($rfid_pendente->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $rfid_pendente->result();
        } else {
            return FALSE;
        }
    }

    public function select_rfid_pendente_by_pin($pin) {
        //select * from rfid
        $this->db->from('Pendentes r');
        $this->db->where('r.pin', $pin);
        //setando query
        $rfid_user_ok = $this->db->get();
        if ($rfid_user_ok->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $rfid_user_ok->result();
        } else {
            return FALSE;
        }
    }

    public function list_users($mode) {
        //select * from pessoa
        $this->db->from('Pessoa p');
        if ($mode == 1) { //ativos
            $this->db->where('isActive = 1');
        } else if ($mode == 0) { //inativos
            $this->db->where('isActive = 0');
        }
        //setando query
        $array_users = $this->db->get();

        if ($array_users->num_rows() > 0) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $array_users->result();
        } else {
            return FALSE;
        }
    }

    public function list_horarios() {
        //select * from pessoa
        $this->db->from('Horarios');
        //setando query
        $array_horarios = $this->db->get();

        if ($array_horarios->num_rows() > 0) {
            //Executa a query e retorna para controller Admin o array com os horários.
            return $array_horarios->result();
        } else {
            return FALSE;
        }
    }

    public function list_periodos() {
        //select * from pessoa
        $this->db->from('Periodos per');
        //setando query
        $array_periodos = $this->db->get();

        if ($array_periodos->num_rows() > 0) {
            //Executa a query e retorna para controller Admin o array com os períodos.
            return $array_periodos->result();
        } else {
            return FALSE;
        }
    }

    public function list_pessoa_periodos() {
        //select * from pessoa
        $this->db->from('Pessoa_Periodo per');

        $this->db->join('Pessoa pes', 'per.idPessoa=pes.id', 'left');

        //setando query
        $array_periodos = $this->db->get();

        if ($array_periodos->num_rows() > 0) {
            //Executa a query e retorna para controller Admin o array com os períodos.
            return $array_periodos->result();
        } else {
            return FALSE;
        }
    }

    public function list_pessoa_periodo($id) {
        //select * from pessoa
        $this->db->from('Pessoa_Periodo per');

        $this->db->where("idPessoa", $id);

        //setando query
        $array_periodos = $this->db->get();

        if ($array_periodos->num_rows() > 0) {
            //Executa a query e retorna para controller Admin o array com os períodos.
            return $array_periodos->result();
        } else {
            return FALSE;
        }
    }

    public function list_periodo_horarios() {
        //select * from pessoa
        $this->db->from('Periodo_Horario per');

        $this->db->join('Horarios hor', 'per.idHorario=hor.idhorario', 'left');

        //setando query
        $array_periodos = $this->db->get();

        if ($array_periodos->num_rows() > 0) {
            //Executa a query e retorna para controller Admin o array com os períodos.
            return $array_periodos->result();
        } else {
            return FALSE;
        }
    }

    public function list_periodo_horario($id) {
        //select * from pessoa
        $this->db->from('Periodo_Horario per');

        $this->db->where("idPeriodo", $id);

        //setando query
        $array_periodos = $this->db->get();

        if ($array_periodos->num_rows() > 0) {
            //Executa a query e retorna para controller Admin o array com os períodos.
            return $array_periodos->result();
        } else {
            return FALSE;
        }
    }

    public function list_feriados() {
        //select * from pessoa
        $this->db->from('Feriados');
        //setando query
        $array_feriados = $this->db->get();

        if ($array_feriados->num_rows() > 0) {
            //Executa a query e retorna para controller Admin o array com os feriados.
            return $array_feriados->result();
        } else {
            return FALSE;
        }
    }

    public function list_rfid_users() {
        //select * from rfid
        $this->db->from('Rfid r');
        //join Pessoa p on r.id_pessoa=p.id
        //para pegar apenas usuarios utilizando rfid linha comentada abaixo
        $this->db->join('Pessoa p', 'r.id_pessoa=p.id', 'left');
        //setando query
        $array_rfid_users = $this->db->get();

        if ($array_rfid_users->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $array_rfid_users->result();
        } else {
            return FALSE;
        }
    }

    public function list_rfid_pendentes() {
        //select * from rfid
        $this->db->from('Pendentes p');
        //setando query
        $array_rfid_pendentes = $this->db->get();
        if ($array_rfid_pendentes->num_rows()) {
            //Executa a query e retorna para controller Admin o array com os usuários.
            return $array_rfid_pendentes->result();
        } else {
            return FALSE;
        }
    }

    public function delete_user($id) {
        //select * from pessoa
        $this->db->from("Pessoa");
        $this->db->where("id", $id);
        //setando query

        if ($this->db->delete()) {
            //Executa a query e retorna para controller Admin o array com o usuário.
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_rfid_pendente($rfid) {
        $this->db->from("Pendentes");
        $this->db->where('rfid', $rfid);
        if ($this->db->delete()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function delete_pessoa_periodo($idPessoa) {
        $this->db->from("pessoa_periodo");
        $this->db->where('idPessoa', $idPessoa);
        if ($this->db->delete()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    public function delete_periodo_horario($idPeriodo) {
        $this->db->from("Periodo_Horario");
        $this->db->where('idPeriodo', $idPeriodo);
        if ($this->db->delete()) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

}
