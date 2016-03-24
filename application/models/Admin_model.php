<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
	public function check_login($rfid)
	{
		//select * from rfid
		$this->db->from('rfid r');
		//join Pessoa p on r.id_pessoa=p.id
		$this->db->join('Pessoa p', 'r.id_pessoa=p.id', 'left');
		//setando query
		$this->db->where('r.rfid',$rfid);

		$user_ok = $this->db->get();
		if($user_ok->num_rows()){
			//Executa a query e retorna para controller Admin o array com os usuários.
			return $user_ok->result();
		}else{
			return FALSE;
		}
	}
	public function select_user($id)
	{
		//select * from pessoa
		$this->db->from('Pessoa p');
		$this->db->where('p.id', $id);
		//setando query
		$user_ok = $this->db->get();
		if($user_ok->num_rows()){
			//Executa a query e retorna para controller Admin o array com o usuário.
			return $user_ok->result();
		}else{
			return FALSE;
		}
		
	}
	public function list_users()
	{
		//select * from pessoa
		$this->db->from('Pessoa p');
		//join Rfid r on r.id_pessoa=p.id
		//para pegar apenas usuarios utilizando rfid linha comentada abaixo
		//$this->db->join('Rfid r', 'r.id_pessoa=p.id', 'left');
		//setando query
		$array_users = $this->db->get();
		
		if($array_users->num_rows()){
			//Executa a query e retorna para controller Admin o array com os usuários.
			return $array_users->result();
		}else{
			return FALSE;
		}
	}
	public function list_rfid_users()
	{
		//select * from rfid
		$this->db->from('Rfid r');
		//join Pessoa p on r.id_pessoa=p.id
		//para pegar apenas usuarios utilizando rfid linha comentada abaixo
		$this->db->join('Pessoa p', 'r.id_pessoa=p.id', 'left');
		//setando query
		$array_rfid_users = $this->db->get();
		
		if($array_rfid_users->num_rows()){
			//Executa a query e retorna para controller Admin o array com os usuários.
			return $array_rfid_users->result();
		}else{
			return FALSE;
		}
	}

}
