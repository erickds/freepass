<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function index(){
		$alerta = null;
		if($this->input->post('entrar')==="entrar"){
			$this->form_validation->set_rules('rfid','RFID','required|numeric|exact_length[9]');
			
			if($this->form_validation->run() === TRUE){
				
				$this->load->model('Admin_model');
 
				$rfid = $this->input->post('rfid');
		
				//valida no banco e recebe Array com o usuário
				$user_ok = $this->Admin_model->check_login($rfid);

				if($user_ok){
					//configura session
					$session = array(
						'rfid' => $rfid,
						'permitido' => TRUE,
						'userName' => $user_ok[0]->nome
					);
					//inicializa session
					$this->session->set_userdata($session);

					redirect('/admin/home');

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

		$this->load->view('rfid/admin',$dados);
	}

	public function sair()
	{
		$this->load->view('welcome_message');
	}
	public function home()
	{
		$dados = array(
			"action" => "usuarios"
			);
		$this->load->view('rfid/home_admin',$dados);
	}
	public function cartoes()
	{
		$dados = array(
			"action" => "cartoes"
			);
		$this->load->view('rfid/home_admin',$dados);
	}
	public function logs()
	{
		$dados = array(
			"action" => "logs"
			);
		$this->load->view('rfid/home_admin',$dados);
	}
	public function cadastrarRFID()
	{
		$dados = array(
			"action" => "cad_rfid"
			);
		$this->load->view('rfid/cadastro',$dados);
	}
	public function editarRFID()
	{
		$dados = array(
			"action" => "edit_rfid"
			);
		$this->load->view('rfid/cadastro',$dados);
	}
	public function cadastrarUsuario()
	{
		$dados = array(
			"action" => "cad_user"
			);
		$this->load->view('rfid/cadastro',$dados);
	}
	public function editarUsuario()
	{
		if($this->input->post('edit') != null){

		$idUser = $this->input->post('idUser');
		$nomeUser = $this->input->post('nomeUser');
		$emailUser = $this->input->post('emailUser');
		$isAdminUser = $this->input->post('isAdminUser');
	}
		$dados = array(
			"action" => "edit_user",
			"idUser" => $idUser,
			"nomeUser" => $nomeUser,
			"emailUser" => $emailUser,
			"isAdminUser" => $isAdminUser
			);
		$this->load->view('rfid/cadastro',$dados);
	}
}
