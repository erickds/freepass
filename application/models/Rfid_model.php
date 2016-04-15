<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfid_model extends CI_Model {
	public function check_rfid($rfid)
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
	public function check_rfid_exists($rfid)
	{
		//select * from rfid
		$this->db->from('rfid');
		$this->db->where('rfid',$rfid);

		$user_ok = $this->db->get();
		if($user_ok->num_rows()){
			//Executa a query e retorna para controller Admin o array com os usuários.
			return $user_ok->result();
		}else{
			return FALSE;
		}
	}
	public function check_rfid_pendente($rfid)
	{
		//select * from rfid
		$this->db->from('pendentes');
		$this->db->where('rfid',$rfid);

		$user_ok = $this->db->get();
		if($user_ok->num_rows()){
			//Executa a query e retorna para controller Admin o array com os usuários.
			return $user_ok->result();
		}else{
			return FALSE;
		}
	}
	public function insert_rfid_pendente($rfid)
	{
		$this->load->model('_model');
		if($this->User_model->insert($user)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
