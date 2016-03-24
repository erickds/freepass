<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfid_model extends CI_Model {
	public function check_rfid($rfid)
	{
		//select * from rfid
		$this->db->from('rfid r');
		//where id = $rfid
		$this->db->where('r.rfid',$rfid);
		//roda query
		$rfids_ok = $this->db->get();

		if($rfids_ok->num_rows()){
			$rfid_ok = $rfids_ok->result_array();
			return $rfid_ok;
		}else{
			return FALSE;
		}
	}
}
