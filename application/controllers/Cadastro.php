<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Cadastro extends CI_Controller {

    public function insert() {
        //Pegando parametros recebidos via POST
        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        $senha = $this->input->post('senha');
        $foto = $this->input->post('foto');
        $telefone = $this->input->post('telefone');
        $endereco = $this->input->post('endereco');
        $dpto = $this->input->post('dpto');
        $cpf = $this->input->post('cpf');
        if ($this->input->post('isAdmin'))
            $isAdmin = 1;
        else
            $isAdmin = 0;
        $user = array(
            'cpf' => $cpf,
            'nome' => $nome,
            'email' => $email,
            'senha' => base64_encode($senha),
            'foto' => $foto,
            'telefone' => $telefone,
            'endereco' => $endereco,
            'dpto' => $dpto,
            'isActive' => 1,
            'isAdmin' => $isAdmin
        );

        $this->load->model('User_model');
        $result = $this->User_model->insert($user);
        if ($result) {
            $dados = array(
                "alerta" => "Operação realizada com sucesso!"
            );
        } else {
            $dados = array(
                "alerta" => "Houve um erro ao tentar realizar esta operação"
            );
        }

        redirect('/admin/home?opType=2', 'refresh');
    }

    public function solicitaCadastro() {
        //Pegando parametros recebidos via POST
        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        $senha = $this->input->post('senha');
        $telefone = $this->input->post('telefone');
        $endereco = $this->input->post('endereco');
        $dpto = $this->input->post('dpto');
        $cpf = $this->input->post('cpf');
        $url = $this->do_upload();
        $user = array(
            'cpf' => $cpf,
            'nome' => $nome,
            'email' => $email,
            'senha' => base64_encode($senha),
            'foto' => $url . "/",
            'telefone' => $telefone,
            'endereco' => $endereco,
            'dpto' => $dpto,
            'isActive' => 0,
            'isAdmin' => 0
        );

        $this->load->model('User_model');
        $result = $this->User_model->insertSolicitaCad($user);
        if ($result > 0) {
            $dados = array(
                "alerta" => "Operação realizada com sucesso!"
            );
        } else {
            $dados = array(
                "alerta" => "Houve um erro ao tentar realizar esta operação"
            );
        }
        redirect('/cadastro/success', 'refresh');
    }

    public function update() {
        $this->load->model('User_model');
        $this->load->model('Admin_model');
        //Pegando parametros recebidos via POST
        $nome = $this->input->post('nome');
        $email = $this->input->post('email');
        $senha = $this->input->post('senha');
        $telefone = $this->input->post('telefone');
        $endereco = $this->input->post('endereco');
        $dpto = $this->input->post('dpto');
        $cpf = $this->input->post('cpf');
        if ($this->input->post('isAdmin'))
            $isAdmin = 1;
        else
            $isAdmin = 0;
        $isActive = $this->input->post('isActive');

        $url = $this->do_upload();

        $user = array(
            'cpf' => $cpf,
            'nome' => $nome,
            'email' => $email,
            'senha' => base64_encode($senha),
            'foto' => $url,
            'telefone' => $telefone,
            'endereco' => $endereco,
            'dpto' => $dpto,
            'isActive' => $isActive,
            'isAdmin' => $isAdmin
        );
        if($user['foto'] != null) {
            $usr = $this->Admin_model->select_user_cpf($cpf);
            unlink("." . $usr[0]->foto);
        }
        $user = array_filter($user);
        
        $result = $this->User_model->update($user);
        if ($result) {
            $dados = array(
                "alerta" => "Operação realizada com sucesso!"
            );
        } else {
            $dados = array(
                "alerta" => "Houve um erro ao tentar realizar esta operação"
            );
        }
        //redirect('/admin/home?opType=2', 'refresh');
    }

    private function do_upload() {
        $type = explode('.', $_FILES["inputFile"]["name"]);
        $type = strtolower($type[count($type) - 1]);
        $url = "/assets/images/users/" . uniqid(rand()) . '.' . $type;
        if (in_array($type, array("jpg", "jpeg", "gif", "png")))
            if (is_uploaded_file($_FILES["inputFile"]["tmp_name"]))
                if (move_uploaded_file($_FILES["inputFile"]["tmp_name"], "." . $url))
                    return $url;
        return "";
    }

    public function success() {
        $this->load->view("rfid/success");
    }

}
