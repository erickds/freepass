<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function index() {
        $alerta = null;
        if ($this->input->post('entrar') === "entrar") {
            $this->form_validation->set_rules('email', 'E-Mail', 'required');
            $this->form_validation->set_rules('password', 'Senha', 'required');
            if ($this->form_validation->run() === TRUE) {


                $email = $this->input->post('email');
                $pwd = $this->input->post('password');
                $this->load->model('Admin_model');
                //valida no banco e recebe Array com o usuário
                $user_ok = $this->Admin_model->check_login($email, base64_encode($pwd));
                //validando se usuário é admin

                if ($user_ok && $user_ok[0]->isAdmin === '1') {
                    //configura session
                    $session = array(
                        'cpf' => $user_ok[0]->cpf,
                        'foto' => $user_ok[0]->foto,
                        'permitido' => TRUE,
                        'isAdmin' => TRUE,
                        'userName' => $user_ok[0]->nome
                    );
                    //inicializa session
                    $this->session->set_userdata($session);

                    redirect('/admin/home?opType=2');
                } else {
                    $alerta = array(
                        "class" => "danger",
                        "mensagem" => "Erro, Dados inválidos<br>"
                    );
                }
            } else {

                $alerta = array(
                    "class" => "danger",
                    "mensagem" => "Atenção, erro na entrada!<br>" . validation_errors()
                );
            }
        }

        $dados = array(
            "alerta" => $alerta
        );

        $this->load->view('rfid/admin', $dados);
    }

    public function sair() {
        $this->session->sess_destroy();
        redirect('/admin');
    }

    public function home() {
        if ($this->session->userdata("isAdmin") == "1") {
            $opType = $this->input->get('opType');
            $array_users = $this->listarUsuarios($opType);
            $dados = array(
                "action" => "usuarios",
                "users" => $array_users
            );

            $this->load->view('rfid/home_admin', $dados);
        } else {
            echo "Acesso não permitido";
        }
    }

    public function horarios() {
        $array_horarios = $this->listarHorarios();
        $dados = array(
            "action" => "horarios",
            "horarios" => $array_horarios
        );

        $this->load->view('rfid/home_admin', $dados);
    }

    public function periodos() {
        $array_periodos = $this->listarPeriodos();
        $dados = array(
            "action" => "periodos",
            "periodos" => $array_periodos
        );

        $this->load->view('rfid/home_admin', $dados);
    }

    public function feriados() {
        $array_feriados = $this->listarFeriados();
        $dados = array(
            "action" => "feriados",
            "feriados" => $array_feriados
        );

        $this->load->view('rfid/home_admin', $dados);
    }

    public function cartoes() {
        $opType = $this->input->get('opType');
        if ($search = $this->input->get('search')) {
            if ($rfid = $this->selectRfid($search)) {
                $dados = array(
                    "action" => "cartoes",
                    "status" => "ativos",
                    "rfid_users" => $rfid
                );
            } else if ($rfid = $this->selectRfidPendente($search)) {
                $dados = array(
                    "action" => "cartoes",
                    "status" => "pendentes",
                    "rfid_pendentes" => $rfid
                );
            } else {
                $dados = array(
                    "action" => "cartoes",
                    "status" => "inexistente"
                );
            }
        } else if ($pin = $this->input->get('pin')) {
            if ($rfid = $this->selectRfidPendenteByPin($pin)) {
                $dados = array(
                    "action" => "cartoes",
                    "status" => "pendentes",
                    "rfid_pendentes" => $rfid
                );
            } else {
                $dados = array(
                    "action" => "cartoes",
                    "status" => "inexistente"
                );
            }
        } else {
            if ($opType != null && $opType == 1) {
                $rfid_users = $this->listarRfidUsers();
                $dados = array(
                    "action" => "cartoes",
                    "status" => "ativos",
                    "rfid_users" => $rfid_users
                );
            } else if ($opType != null && $opType == 2) {
                $rfid_pendentes = $this->listarRfidPendentes();
                $dados = array(
                    "action" => "cartoes",
                    "status" => "pendentes",
                    "rfid_pendentes" => $rfid_pendentes
                );
            } else {
                $dados = array(
                    "action" => "cartoes",
                    "status" => "inexistente"
                );
            }
        }
        $this->load->view('rfid/home_admin', $dados);
    }

    public function logs() {
        $logs = $this->listarLogs();
        $dados = array(
            "action" => "logs",
            "logs" => $logs
        );
        $this->load->view('rfid/home_admin', $dados);
    }

    public function cadastrarRFID() {
        $dados = array(
            "action" => "cad_rfid"
        );
        $this->load->view('rfid/cadastro', $dados);
    }

    public function editarRFID() {
        $this->load->model('Admin_model');
        if (isset($_POST['edit'])) {
            $id = $this->input->post('edit');
            if ($rfid_user = $this->selectRfid($id)) {
                $users = $this->listarUsuarios(1);
                $dados = array(
                    "action" => "edit_rfid",
                    "status" => "ativo",
                    "rfid" => $rfid_user[0]->rfid,
                    "rfidActive" => $rfid_user[0]->rfidActive,
                    "idUser" => $rfid_user[0]->id,
                    "nomeUser" => $rfid_user[0]->nome,
                    "users" => $users
                );
            } else if ($rfid_user = $this->selectRfidPendente($id)) {
                $users = $this->listarUsuarios(1);
                $dados = array(
                    "action" => "edit_rfid",
                    "status" => "pendente",
                    "rfid" => $rfid_user[0]->rfid,
                    "rfidActive" => 0,
                    "idUser" => 0,
                    "nomeUser" => "",
                    "users" => $users
                );
            }
            $this->load->view('rfid/cadastro', $dados);
        } else {
            $idDel = $this->input->post('delete');
            $this->Admin_model->delete_user($idDel);
            redirect("/admin/home");
        }
    }

    public function cadastrarUsuario() {
        $this->load->model('Admin_model');
        $periods = $this->Admin_model->list_periodos();
        $pesssoa_periodos = $this->Admin_model->list_pessoa_periodos();
        $dados = array(
            "action" => "cad_user",
            "periodos" => $periods,
            "pessoa_periodos" => $pesssoa_periodos
        );
        $this->load->view('rfid/cadastro', $dados);
    }

    public function editarUsuario() {
        $this->load->model('Admin_model');
        if (isset($_POST['edit'])) {
            $id = $this->input->post('edit');
            $user = $this->Admin_model->select_user($id);
            $periodos = $this->Admin_model->list_periodos();
            $pesssoa_periodos = $this->Admin_model->list_pessoa_periodo($id);
            $id_periodos = array();

            if ($pesssoa_periodos) {
                foreach ($pesssoa_periodos as $pessoa_periodo) {
                    array_push($id_periodos, $pessoa_periodo->idPeriodo);
                    echo $pessoa_periodo->idPeriodo;
                }
            }
            $dados = array(
                "action" => "edit_user",
                "cpfUser" => $user[0]->cpf,
                "nomeUser" => $user[0]->nome,
                "telefoneUser" => $user[0]->telefone,
                "emailUser" => $user[0]->email,
                "pwdUser" => $user[0]->senha,
                "dptoUser" => $user[0]->dpto,
                "enderecoUser" => $user[0]->endereco,
                "isActive" => $user[0]->isActive,
                "isAdminUser" => $user[0]->isAdmin,
                "periodos" => $periodos,
                "pessoa_periodos" => $id_periodos
            );
            $this->load->view('rfid/cadastro', $dados);
        } else {
            $idDel = $this->input->post('delete');
            $this->Admin_model->delete_user($idDel);
            redirect("/admin/home");
        }
    }

    public function listarUsuarios($modo) {
        $this->load->model('Admin_model');
        //valida no banco e recebe Array com o usuário
        return $this->Admin_model->list_users($modo);
    }

    public function cadastrarHorario() {
        $dados = array(
            "action" => "cad_horario"
        );
        $this->load->view('rfid/cadastro', $dados);
    }

    public function editarHorario() {
        $this->load->model('Admin_model');
        if (isset($_POST['edit'])) {
            $idhorario = $this->input->post('edit');
            $horario = $this->Admin_model->select_horario($idhorario);
            $horario = array(
                "action" => "edit_horario",
                "idhorario" => $horario[0]->idhorario,
                "nome" => $horario[0]->nome,
                "horainicio" => $horario[0]->horainicio,
                "horafim" => $horario[0]->horafim,
                "seg" => $horario[0]->seg,
                "ter" => $horario[0]->ter,
                "qua" => $horario[0]->qua,
                "qui" => $horario[0]->qui,
                "sex" => $horario[0]->sex,
                "sab" => $horario[0]->sab,
                "dom" => $horario[0]->dom
            );
            $this->load->view('rfid/cadastro', $horario);
        } else {
            $idDel = $this->input->post('delete');
            $this->Admin_model->delete_horario($idDel);
            redirect("/admin/home");
        }
    }

    public function listarHorarios() {
        $this->load->model('Admin_model');
        //valida no banco e recebe Array com o usuário
        return $this->Admin_model->list_horarios();
    }

    public function cadastrarPeriodo() {
        $this->load->model('Admin_model');
        $horarios = $this->Admin_model->list_horarios();
        $dados = array(
            "action" => "cad_periodo",
            "horarios" => $horarios,
            "periodo_horarios" => null
        );

        $this->load->view('rfid/cadastro', $dados);
    }

    public function editarPeriodo() {
        $this->load->model('Admin_model');
        if (isset($_POST['edit'])) {
            $idperiodo = $this->input->post('edit');
            $periodo = $this->Admin_model->select_periodo($idperiodo);
            $horarios = $this->Admin_model->list_horarios();
            $periodo_horarios = $this->Admin_model->list_periodo_horario($idperiodo);
            $id_horarios = array();

            if ($periodo_horarios) {
                foreach ($periodo_horarios as $periodo_horario) {
                    array_push($id_horarios, $periodo_horario->idHorario);
                }
            }
            $dados = array(
                "action" => "edit_periodo",
                "idperiodo" => $periodo[0]->idperiodo,
                "nome" => $periodo[0]->nome,
                "datainicio" => $periodo[0]->datainicio,
                "datafim" => $periodo[0]->datafim,
                "feriadoAtivo" => $periodo[0]->feriadoAtivo,
                "horarios" => $horarios,
                "periodo_horarios" => $id_horarios
            );
            $this->load->view('rfid/cadastro', $dados);
        } else {
            $idDel = $this->input->post('delete');
            $this->Admin_model->delete_periodo($idDel);
            redirect("/admin/home");
        }
    }

    public function cadastrarFeriado() {
        $dados = array(
            "action" => "cad_feriado"
        );
        $this->load->view('rfid/cadastro', $dados);
    }

    public function editarFeriado() {
        $this->load->model('Admin_model');
        if (isset($_POST['edit'])) {
            $idferiado = $this->input->post('edit');
            $feriado = $this->Admin_model->select_feriado($idferiado);
            $dados = array(
                "action" => "edit_feriado",
                "idferiado" => $feriado[0]->idferiado,
                "nome" => $feriado[0]->nome,
                "data" => $feriado[0]->data,
            );
            $this->load->view('rfid/cadastro', $dados);
        } else {
            $idDel = $this->input->post('delete');
            $this->Admin_model->delete_feriado($idDel);
            redirect("/admin/home");
        }
    }

    public function listarPeriodos() {
        $this->load->model('Admin_model');
        //valida no banco e recebe Array com o usuário
        return $this->Admin_model->list_periodos();
    }

    public function listarFeriados() {
        $this->load->model('Admin_model');
        //valida no banco e recebe Array com o usuário
        return $this->Admin_model->list_feriados();
    }

    public function listarRfidUsers() {
        $this->load->model('Admin_model');
        //valida no banco e recebe Array com o usuário
        return $this->Admin_model->list_rfid_users();
    }

    public function listarRfidPendentes() {
        $this->load->model('Admin_model');
        //valida no banco e recebe Array com o usuário
        return $this->Admin_model->list_rfid_pendentes();
    }

    public function selectRfid($rfid) {
        $this->load->model('Admin_model');
        //valida no banco e recebe Array com o usuário
        return $this->Admin_model->select_rfid_user($rfid);
    }

    public function selectRfidPendente($rfid) {
        $this->load->model('Admin_model');
        //valida no banco e recebe Array com o usuário
        return $this->Admin_model->select_rfid_pendente($rfid);
    }

    public function selectRfidPendenteByPin($pin) {
        $this->load->model('Admin_model');
        //valida no banco e recebe Array com o usuário
        return $this->Admin_model->select_rfid_pendente_by_pin($pin);
    }

    public function listarLogs() {
        $this->load->model('Log_model');
        //valida no banco e recebe Array com o usuário
        return $this->Log_model->list_logs();
    }

}
