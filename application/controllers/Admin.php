<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {
	public function index(){
		$alerta = null;
		if($this->input->post('entrar')==="entrar"){
			$this->form_validation->set_rules('rfid','RFID','required|numeric|exact_length[9]');
			
			if($this->form_validation->run() === TRUE){
				
 
				$rfid = $this->input->post('rfid');
				$this->load->model('Admin_model');
				//valida no banco e recebe Array com o usuário
				$user_ok = $this->Admin_model->check_login($rfid);
				//validando se usuário é admin

				if($user_ok && $user_ok[0]->isAdmin === '1'){
					//configura session
					$session = array(
						'rfid' => $rfid,
						'permitido' => TRUE,
						'isAdmin' => TRUE,
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
		$array_users = $this->listarUsuarios();
		$dados = array(
			"action" => "usuarios",
			"users" => $array_users
			);
		
		$this->load->view('rfid/home_admin',$dados);
	}
	public function cartoes()
	{
		$rfid_users = $this->listarRfidUsers();
		$dados = array(
			"action" => "cartoes",
			"rfid_users" => $rfid_users
			);
		
		$this->load->view('rfid/home_admin',$dados);
	}
	public function logs()
	{
		$logs = $this->listarLogs();
		$dados = array(
			"action" => "logs",
			"logs" => $logs
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
			"action" => "edit_rfid",
			"user" => "$user"
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
		$this->load->model('Admin_model');
		$id = $this->input->post('edit');
		$user = $this->Admin_model->select_user($id);
		$dados = array(
			"action" => "edit_user",
			"cpfUser" => $user[0]->cpf,
			"nomeUser" => $user[0]->nome,
			"telefoneUser" => $user[0]->telefone,
			"emailUser" => $user[0]->email,
			"pwdUser" => $user[0]->senha,
			"dptoUser" => $user[0]->dpto,
			"enderecoUser" => $user[0]->endereco,
			"isAdminUser" => $user[0]->isAdmin
			);
		$this->load->view('rfid/cadastro',$dados);
	}

	public function listarUsuarios(){
		$this->load->model('Admin_model');
		//valida no banco e recebe Array com o usuário
		return $this->Admin_model->list_users();
	}
	public function listarRfidUsers(){
		$this->load->model('Admin_model');
		//valida no banco e recebe Array com o usuário
		return $this->Admin_model->list_rfid_users();
	}
	public function listarLogs(){
		$this->load->model('Log_model');
		//valida no banco e recebe Array com o usuário
		return $this->Log_model->list_logs();
	}
}
