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

        $this->load->model('Admin_model');
        $user = $this->Admin_model->select_user_cpf($cpf);
        $periodos = $this->Admin_model->list_periodos();

        $idperiods = array();
        foreach ($periodos as $periodo) {
            if ($this->input->post($periodo->nome)) {
                array_push($idperiods, $periodo->idperiodo);
            }
        }

        $this->load->model('Periodo_model');
        $periodos = $this->Periodo_model->insert_pessoa_periodos($user[0]->id, $idperiods);

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

    public function insertRfid() {
        //Pegando parametros recebidos via POST
        $rfid = $this->input->post('rfid');
        $id_pessoa = $this->input->post('selectUser');
        $rfidActive = $this->input->post('rfidActive');

        $cartao = array(
            'rfid' => $rfid,
            'id_pessoa' => $id_pessoa,
            'rfidActive' => $rfidActive
        );

        $this->load->model('Rfid_model');
        $result = $this->Rfid_model->insert_rfid($cartao);
        if ($result) {
            $dados = array(
                "alerta" => "Operação realizada com sucesso!"
            );
        } else {
            $dados = array(
                "alerta" => "Houve um erro ao tentar realizar esta operação"
            );
        }

        redirect('/admin/cartoes?opType=1', 'refresh');
    }

    public function aceitaCadastroRfid() {
        //Pegando parametros recebidos via POST
        $rfid = $this->input->post('rfid');
        $id_pessoa = $this->input->post('selectUser');
        if (!$rfidActive = $this->input->post('rfidActive')) {
            $rfidActive = 0;
        }

        $cartao = array(
            'rfid' => $rfid,
            'id_pessoa' => $id_pessoa,
            'rfidActive' => $rfidActive
        );

        $this->load->model('Rfid_model');
        $result = $this->Rfid_model->insert_rfid($cartao);
        if ($result) {
            $this->load->model('Admin_model');
            $this->Admin_model->delete_rfid_pendente($rfid);
            $dados = array(
                "alerta" => "Operação realizada com sucesso!"
            );
        } else {
            $dados = array(
                "alerta" => "Houve um erro ao tentar realizar esta operação"
            );
        }

        redirect('/admin/cartoes?opType=1', 'refresh');
    }

    public function insertHorario() {
        //Pegando parametros recebidos via POST
        $nome = $this->input->post('nome');
        $horainicio = $this->input->post('horainicio');
        $horafim = $this->input->post('horafim');
        $seg = $this->input->post('seg');
        $ter = $this->input->post('ter');
        $qua = $this->input->post('qua');
        $qui = $this->input->post('qui');
        $sex = $this->input->post('sex');
        $sab = $this->input->post('sab');
        $dom = $this->input->post('dom');

        $horario = array(
            'nome' => $nome,
            'horainicio' => date("Y-m-d H:i:s", strtotime($horafim)),
            'horafim' => date("Y-m-d H:i:s", strtotime($horainicio)),
            'seg' => $seg,
            'ter' => $ter,
            'qua' => $qua,
            'qui' => $qui,
            'sex' => $sex,
            'sab' => $sab,
            'dom' => $dom
        );

        $this->load->model('Horario_model');
        $result = $this->Horario_model->insert($horario);
        if ($result) {
            $dados = array(
                "alerta" => "Operação realizada com sucesso!"
            );
        } else {
            $dados = array(
                "alerta" => "Houve um erro ao tentar realizar esta operação"
            );
        }

        redirect('/admin/horarios', 'refresh');
    }

    public function insertPeriodo() {
        //Pegando parametros recebidos via POST
        $nome = $this->input->post('nome');
        $datainicio = $this->input->post('datainicio');
        $datafim = $this->input->post('datafim');
        $feriadoAtivo = $this->input->post('feriadoAtivo');

        $periodo = array(
            'nome' => $nome,
            'datainicio' => $datainicio,
            'datafim' => $datafim,
            'feriadoAtivo' => $feriadoAtivo
        );

        $this->load->model('Periodo_model');
        $result = $this->Periodo_model->insert($periodo);

        $this->load->model('Admin_model');
        $periodo = $this->Admin_model->select_periodo($result);
        $horarios = $this->Admin_model->list_horarios();
        $idhorarios = array();
        foreach ($horarios as $horario) {
            if ($this->input->post($horario->nome)) {
                array_push($idhorarios, $horario->idhorario);
            }
        }

        $this->load->model('Periodo_model');
        $periodos = $this->Periodo_model->insert_periodo_horarios($periodo[0]->idperiodo, $idhorarios);


        if ($result) {
            $dados = array(
                "alerta" => "Operação realizada com sucesso!"
            );
        } else {
            $dados = array(
                "alerta" => "Houve um erro ao tentar realizar esta operação"
            );
        }
        redirect('/admin/periodos', 'refresh');
    }

    public function insertFeriado() {
        //Pegando parametros recebidos via POST
        $nome = $this->input->post('nome');
        $data = $this->input->post('data');

        $feriado = array(
            'nome' => $nome,
            'data' => $data
        );

        $this->load->model('Feriado_model');
        $result = $this->Feriado_model->insert($feriado);
        if ($result) {
            $dados = array(
                "alerta" => "Operação realizada com sucesso!"
            );
        } else {
            $dados = array(
                "alerta" => "Houve um erro ao tentar realizar esta operação"
            );
        }

        redirect('/admin/feriados', 'refresh');
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
        $usr = $this->Admin_model->select_user_cpf($cpf);
        if ($user['foto'] != null) {
            unlink("." . $usr[0]->foto);
        }
        $user = array_filter($user);

        $result = $this->User_model->update($user);

        $this->Admin_model->delete_pessoa_periodo($usr[0]->id);
        $periodos = $this->Admin_model->list_periodos();

        $idperiods = array();
        foreach ($periodos as $periodo) {
            if ($this->input->post($periodo->nome)) {
                array_push($idperiods, $periodo->idperiodo);
            }
        }

        $this->load->model('Periodo_model');
        $periodos = $this->Periodo_model->insert_pessoa_periodos($usr[0]->id, $idperiods);
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

    public function updateRfid() {
        $this->load->model('Rfid_model');
        $this->load->model('Admin_model');
        //Pegando parametros recebidos via POST
        $rfid = $this->input->post('rfid');
        $selectUser = $this->input->post('selectUser');
        if ($rfidActive = $this->input->post('rfidActive')) {
            
        } else {
            $rfidActive = '0';
        }
        $user_rfid = array(
            'rfid' => $rfid,
            'id_pessoa' => $selectUser,
            'rfidActive' => $rfidActive,
        );

        $result = $this->Rfid_model->update($user_rfid);
        if ($result) {
            $dados = array(
                "alerta" => "Operação realizada com sucesso!"
            );
        } else {
            $dados = array(
                "alerta" => "Houve um erro ao tentar realizar esta operação"
            );
        }
        redirect('/admin/cartoes?opType=1', 'refresh');
    }

    public function updateHorario() {
        $this->load->model('Horario_model');
        //Pegando parametros recebidos via POST
        $idhorario = $this->input->post('idhorario');
        $horainicio = $this->input->post('horainicio');
        $horafim = $this->input->post('horafim');
        $seg = $this->input->post('seg');
        $ter = $this->input->post('ter');
        $qua = $this->input->post('qua');
        $qui = $this->input->post('qui');
        $sex = $this->input->post('sex');
        $sab = $this->input->post('sab');
        $dom = $this->input->post('dom');

        $horario = array(
            'idhorario' => $idhorario,
            'horainicio' => date("Y-m-d H:i:s", strtotime($horainicio)),
            'horafim' => date("Y-m-d H:i:s", strtotime($horafim)),
            'seg' => $seg,
            'ter' => $ter,
            'qua' => $qua,
            'qui' => $qui,
            'sex' => $sex,
            'sab' => $sab,
            'dom' => $dom
        );

        $result = $this->Horario_model->update($horario);
        if ($result) {
            $dados = array(
                "alerta" => "Operação realizada com sucesso!"
            );
        } else {
            $dados = array(
                "alerta" => "Houve um erro ao tentar realizar esta operação"
            );
        }
        redirect('/admin/horarios', 'refresh');
    }

    public function updatePeriodo() {
        $this->load->model('Periodo_model');
        //Pegando parametros recebidos via POST
        $idperiodo = $this->input->post('idperiodo');
        $nome = $this->input->post('nome');
        $datainicio = $this->input->post('datainicio');
        $datafim = $this->input->post('datafim');
        $feriadoAtivo = $this->input->post('feriadoAtivo');

        $periodo = array(
            'idperiodo' => $idperiodo,
            'nome' => $nome,
            'datainicio' => $datainicio,
            'datafim' => $datafim,
            'feriadoAtivo' => $feriadoAtivo
        );

        $result = $this->Periodo_model->update($periodo);
        $this->load->model('Admin_model');
        $this->Admin_model->delete_periodo_horario($idperiodo);
        $horarios = $this->Admin_model->list_horarios();

        $idhorarios = array();
        foreach ($horarios as $horario) {
            if ($this->input->post($horario->nome)) {
                array_push($idhorarios, $horario->idhorario);
            }
        }
        $this->load->model('Periodo_model');
        $periodos = $this->Periodo_model->insert_periodo_horarios($idperiodo, $idhorarios);

        if ($result) {
            $dados = array(
                "alerta" => "Operação realizada com sucesso!"
            );
        } else {
            $dados = array(
                "alerta" => "Houve um erro ao tentar realizar esta operação"
            );
        }
        redirect('/admin/periodos', 'refresh');
    }

    public function updateFeriado() {
        $this->load->model('Feriado_model');
        //Pegando parametros recebidos via POST
        $idferiado = $this->input->post('idferiado');
        $nome = $this->input->post('nome');
        $data = $this->input->post('data');

        $feriado = array(
            'idferiado' => $idferiado,
            'nome' => $nome,
            'data' => $data
        );

        $result = $this->Feriado_model->update($feriado);
        if ($result) {
            $dados = array(
                "alerta" => "Operação realizada com sucesso!"
            );
        } else {
            $dados = array(
                "alerta" => "Houve um erro ao tentar realizar esta operação"
            );
        }
        redirect('/admin/feriados', 'refresh');
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
