<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rfid extends CI_Controller {
	public function entrar(){
		$alerta = null;
		if($this->input->post('entrar')==="entrar"){
			$this->form_validation->set_rules('rfid','RFID','required|numeric|exact_length[9]');
			
			if($this->form_validation->run() === TRUE){
				
				$this->load->model('Rfid_model');

				$rfid = $this->input->post('rfid');

				
				//valida no banco
				$rfid_ok = $this->Rfid_model->check_rfid($rfid);

				if($rfid_ok){
					//configura session
					$session = array(
						'rfid' => $rfid,
						'permitido' => TRUE
					);
					//inicializa session
					$this->session->set_userdata($session);

					redirect('home');

				}else{
				$alerta = array(
						"class" => "danger",
						"mensagem" => "Erro, RFID não permitida<br>"
					);	
				}

			}else{

				$alerta = array(
						"class" => "danger",
						"mensagem" => "Atenção, erro na entrada!<br>". validation_errors()
					);
			}
		}

		$dados = array(
			"alerta" => $alerta
			);

		$this->load->view('rfid/entrar',$dados);
	}

	public function sair()
	{
		$this->session->sess_destroy();
		redirect('rfid/entrar');
	}
        
        public function pre_cadastro(){
		$alerta = null;
		if($this->input->post('entrar')==="entrar"){
			$this->form_validation->set_rules('rfid','RFID','required|numeric|exact_length[9]');
			
			if($this->form_validation->run() === TRUE){
				
				$this->load->model('Rfid_model');

				$rfid = $this->input->post('rfid');

				
				//valida no banco
				$rfid_ok = $this->Rfid_model->check_rfid($rfid);

				if($rfid_ok){
					//configura session
					$session = array(
						'rfid' => $rfid,
						'permitido' => TRUE
					);
					//inicializa session
					$this->session->set_userdata($session);

					redirect('home');

				}else{
				$alerta = array(
						"class" => "danger",
						"mensagem" => "Erro, RFID não permitida<br>"
					);	
				}

			}else{

				$alerta = array(
						"class" => "danger",
						"mensagem" => "Atenção, erro na entrada!<br>". validation_errors()
					);
			}
		}

		$dados = array(
			"alerta" => $alerta
			);

		$this->load->view('rfid/pre-cadastro',$dados);
	}

}
