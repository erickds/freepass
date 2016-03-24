<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {
	public function insert($user)
	{
		
		if($this->db->insert('pessoa', $user)){
			return TRUE;
		}else{
			return FALSE;
		}
	}
}
