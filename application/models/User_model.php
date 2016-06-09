<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    public function insert($user) {
        $this->load->model('Admin_model');
            if ($this->db->insert('pessoa', $user)) {
                return TRUE;
            } else {
                return FALSE;
            } 
    }
    
    public function update($user){
        $this->load->model('Admin_model');
        $res_user = $this->Admin_model->select_user_cpf($user['cpf']);
        if ($res_user[0] != null) {
            //removendo campo cpf que não pode ser alterado
            //array_shift($user);
            $this->db->where('cpf', $user['cpf']);
            $this->db->update('pessoa', $user);
        } 
    }

    public function insertSolicitaCad($user) {
        $this->load->model('Admin_model');

        $res_user = $this->Admin_model->select_user_cpf($user['cpf']);
        if($user != null && $user['cpf'] != null){
            if ($res_user[0] != null) {
                //removendo campo cpf que não pode ser alterado
                array_pop($user);
                $this->db->update('pessoa', $user);
                return TRUE;
            } else {
                if ($this->db->insert('pessoa', $user)) {
                    return TRUE;
                } else {
                    return FALSE;
                }
            }
        }else{
            return FALSE;
        }
    }
}
