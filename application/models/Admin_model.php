<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_model extends CI_Model {
	public function check_login($rfid)
	{
		//select * from rfid
		$this->db->from('rfid r');
		//join Pessoa p on r.id_pessoa=p.id
		$this->db->join('Pessoa p', 'r.id_pessoa=p.id', 'left');
		//where id = $rfid
		$this->db->where('r.id',$rfid);
		//setando query
		$user_ok = $this->db->get();
		
		if($user_ok->num_rows()){
			//Executa a query e retorna para controller Admin o array com os usuários.
			return $user_ok->result();
		}else{
			return FALSE;
		}
	}
}
