<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     * 	- or -
     * 		http://example.com/index.php/welcome/index
     * 	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/user_guide/general/urls.html
     */
    public function index() {
        $this->load->view('rfid/home');
    }

    public function sair() {
        $this->session->sess_destroy();
        redirect('./');
    }

    public function dados() {
        $this->load->model("User_model");
        $id = $this->session->userdata("id");
        $user = $this->User_model->select_user($id);

        $dados = array(
            "action" => "edit_user",
            "status" => "pendente",
            "cpfUser" => $user[0]->cpf,
            "nomeUser" => $user[0]->nome,
            "telefoneUser" => $user[0]->telefone,
            "emailUser" => $user[0]->email,
            "pwdUser" => $user[0]->senha,
            "dptoUser" => $user[0]->dpto,
            "enderecoUser" => $user[0]->endereco,
            "isActive" => $user[0]->isActive,
            "isAdminUser" => $user[0]->isAdmin,
        );

        $this->load->view('rfid/user_edit_data', $dados);
    }

    public function cartoes() {
        $this->load->model("Rfid_model");
        $id = $this->session->userdata("id");
        $user_rfids = $this->Rfid_model->select_rfids_from_user($id);

        $dados = array(
            "action" => "edit_rfid",
            "status" => "pendente",
            "user_rfids" => $user_rfids
        );

        $this->load->view('rfid/user_edit_cards', $dados);
    }

    public function logs() {
        $this->load->model("Log_model");
        $id = $this->session->userdata("id");
        $logs = $this->Log_model->list_logs_of_user($id);
        $dados = array(
            "action" => "logs",
            "logs" => $logs
        );

        $this->load->view('rfid/user_edit_logs', $dados);
    }

}
