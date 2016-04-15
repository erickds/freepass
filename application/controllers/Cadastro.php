<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastro extends CI_Controller {

	public function insert()
	{
		//Pegando parametros recebidos via POST
		$nome = $this->input->post('nome');
		$email = $this->input->post('email');
		$senha = $this->input->post('senha');
		$foto = $this->input->post('foto');
		$telefone = $this->input->post('telefone');
		$endereco = $this->input->post('endereco');
		$dpto = $this->input->post('dpto');
		$cpf = $this->input->post('cpf');
		if($this->input->post('isAdmin'))
			$isAdmin = 1;
		else
			$isAdmin = 0;
		$user = array(
		   'cpf' => $cpf,
		   'nome' => $nome,
		   'email' => $email,
		   'senha' => $senha,
		   'foto' => $foto,
		   'telefone' => $telefone,
		   'endereco' => $endereco,
		   'dpto' => $dpto,
		   'isAdmin' => $isAdmin
		);

		$this->load->model('User_model');
		$result = $this->User_model->insert($user);
		if($result){
			$dados = array(
				"alerta" => "Operação realizada com sucesso!"
			);
		}else{
			$dados = array(
				"alerta" => "Houve um erro ao tentar realizar esta operação"
			);
		}

		redirect('/admin/home', 'refresh');
	}
}
