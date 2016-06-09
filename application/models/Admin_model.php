<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function check_login($email,$pwd) {
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

    public function list_users($mode) {
        //select * from pessoa
        $this->db->from('Pessoa p');
        if($mode == 1){ //ativos
            $this->db->where('isActive = 1');
        }else if($mode == 0){ //inativos
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

}
