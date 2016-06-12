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
                "users" => $array_users,
                "infos" => $this->getStatus()
            );
            $this->load->view('rfid/home_admin', $dados);
        } else {
            echo "Acesso não permitido";
        }
    }

    public function horarios() {
        if ($this->session->userdata("isAdmin") == "1") {
            $array_horarios = $this->listarHorarios();
            $dados = array(
                "action" => "horarios",
                "horarios" => $array_horarios,
                "infos" => $this->getStatus()
            );

            $this->load->view('rfid/home_admin', $dados);
        } else {
            echo "Acesso não permitido";
        }
    }

    public function periodos() {
        if ($this->session->userdata("isAdmin") == "1") {
            $array_periodos = $this->listarPeriodos();
            $dados = array(
                "action" => "periodos",
                "periodos" => $array_periodos,
                "infos" => $this->getStatus()
            );

            $this->load->view('rfid/home_admin', $dados);
        } else {
            echo "Acesso não permitido";
        }
    }

    public function feriados() {
        if ($this->session->userdata("isAdmin") == "1") {
            $array_feriados = $this->listarFeriados();
            $dados = array(
                "action" => "feriados",
                "feriados" => $array_feriados,
                "infos" => $this->getStatus()
            );

            $this->load->view('rfid/home_admin', $dados);
        } else {
            echo "Acesso não permitido";
        }
    }

    public function cartoes() {
        if ($this->session->userdata("isAdmin") == "1") {
            $opType = $this->input->get('opType');
            if ($search = $this->input->get('search')) {
                if ($rfid = $this->selectRfid($search)) {
                    $dados = array(
                        "action" => "cartoes",
                        "status" => "ativos",
                        "rfid_users" => $rfid,
                        "infos" => $this->getStatus()
                    );
                } else if ($rfid = $this->selectRfidPendente($search)) {
                    $dados = array(
                        "action" => "cartoes",
                        "status" => "pendentes",
                        "rfid_pendentes" => $rfid,
                        "infos" => $this->getStatus()
                    );
                } else {
                    $dados = array(
                        "action" => "cartoes",
                        "status" => "inexistente",
                        "infos" => $this->getStatus()
                    );
                }
            } else if ($pin = $this->input->get('pin')) {
                if ($rfid = $this->selectRfidPendenteByPin($pin)) {
                    $dados = array(
                        "action" => "cartoes",
                        "status" => "pendentes",
                        "rfid_pendentes" => $rfid,
                        "infos" => $this->getStatus()
                    );
                } else {
                    $dados = array(
                        "action" => "cartoes",
                        "status" => "inexistente",
                        "infos" => $this->getStatus()
                    );
                }
            } else {
                if ($opType != null && $opType == 1) {
                    $rfid_users = $this->listarRfidUsers();
                    $dados = array(
                        "action" => "cartoes",
                        "status" => "ativos",
                        "rfid_users" => $rfid_users,
                        "infos" => $this->getStatus()
                    );
                } else if ($opType != null && $opType == 2) {
                    $rfid_pendentes = $this->listarRfidPendentes();
                    $dados = array(
                        "action" => "cartoes",
                        "status" => "pendentes",
                        "rfid_pendentes" => $rfid_pendentes,
                        "infos" => $this->getStatus()
                    );
                } else {
                    $dados = array(
                        "action" => "cartoes",
                        "status" => "inexistente",
                        "infos" => $this->getStatus()
                    );
                }
            }
            $this->load->view('rfid/home_admin', $dados);
        } else {
            echo "Acesso não permitido";
        }
    }

    public function logs() {
        if ($this->session->userdata("isAdmin") == "1") {
            if ($rfid = $this->input->get('rfid')) {
                $logs = $this->listarLogsOfRfid($rfid);
                $dados = array(
                    "action" => "logs",
                    "logs" => $logs,
                    "infos" => $this->getStatus()
                );
            } else {
                $logs = $this->listarLogs();
                $dados = array(
                    "action" => "logs",
                    "logs" => $logs,
                    "infos" => $this->getStatus()
                );
            }
            $this->load->view('rfid/home_admin', $dados);
        } else {
            echo "Acesso não permitido";
        }
    }

    public function cadastrarRFID() {
        if ($this->session->userdata("isAdmin") == "1") {
            $dados = array(
                "action" => "cad_rfid"
            );
            $this->load->view('rfid/cadastro', $dados);
        } else {
            
        }
    }

    public function editarRFID() {
        if ($this->session->userdata("isAdmin") == "1") {
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
                if ($this->selectRfid($idDel)) {
                    $this->Admin_model->delete_rfid($idDel);
                    redirect("/admin/cartoes?opType=1");
                } else if ($this->selectRfidPendente($idDel)) {
                    $this->Admin_model->delete_rfid_pendente($idDel);
                    redirect("/admin/cartoes?opType=2");
                }
            }
        } else {
            
        }
    }

    public function cadastrarUsuario() {
        if ($this->session->userdata("isAdmin") == "1") {
            $this->load->model('Admin_model');
            $periods = $this->Admin_model->list_periodos();
            $pesssoa_periodos = $this->Admin_model->list_pessoa_periodos();
            $dados = array(
                "action" => "cad_user",
                "periodos" => $periods,
                "pessoa_periodos" => $pesssoa_periodos
            );
            $this->load->view('rfid/cadastro', $dados);
        } else {
            
        }
    }

    public function editarUsuario() {
        if ($this->session->userdata("isAdmin") == "1") {
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
                redirect("/admin/home?opType=2");
            }
        } else {
            
        }
    }

    public function listarUsuarios($modo) {
        if ($this->session->userdata("isAdmin") == "1") {
            $this->load->model('Admin_model');
            //valida no banco e recebe Array com o usuário
            return $this->Admin_model->list_users($modo);
        } else {
            
        }
    }

    public function cadastrarHorario() {
        if ($this->session->userdata("isAdmin") == "1") {
            $dados = array(
                "action" => "cad_horario"
            );
            $this->load->view('rfid/cadastro', $dados);
        } else {
            
        }
    }

    public function editarHorario() {
        if ($this->session->userdata("isAdmin") == "1") {
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
                redirect("/admin/horarios");
            }
        } else {
            
        }
    }

    public function listarHorarios() {
        if ($this->session->userdata("isAdmin") == "1") {
            $this->load->model('Admin_model');
            //valida no banco e recebe Array com o usuário
            return $this->Admin_model->list_horarios();
        } else {
            
        }
    }

    public function cadastrarPeriodo() {
        if ($this->session->userdata("isAdmin") == "1") {
            $this->load->model('Admin_model');
            $horarios = $this->Admin_model->list_horarios();
            $dados = array(
                "action" => "cad_periodo",
                "horarios" => $horarios,
                "periodo_horarios" => null
            );

            $this->load->view('rfid/cadastro', $dados);
        } else {
            
        }
    }

    public function editarPeriodo() {
        if ($this->session->userdata("isAdmin") == "1") {
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
                redirect("/admin/periodos");
            }
        } else {
            
        }
    }

    public function cadastrarFeriado() {
        if ($this->session->userdata("isAdmin") == "1") {
            $dados = array(
                "action" => "cad_feriado"
            );
            $this->load->view('rfid/cadastro', $dados);
        } else {
            
        }
    }

    public function editarFeriado() {
        if ($this->session->userdata("isAdmin") == "1") {
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
                redirect("/admin/feriados");
            }
        } else {
            
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

    public function listarLogsOfRfid($rfid) {
        $this->load->model('Log_model');
        //valida no banco e recebe Array com o usuário
        return $this->Log_model->list_logs_of_rfid($rfid);
    }

    public function getStatus() {
        $this->load->helper('date');
        $this->load->model('Log_model');
        //valida no banco e recebe Array com o usuário
        if ($logs = $this->Log_model->list_logs()) {
            $status = array();
            $status['qttyAccessAll'] = 0;
            $status['qttyBlockedAccessAll'] = 0;
            $status['qttyAccessToday'] = 0;
            $status['qttyBlockedAccessToday'] = 0;

            foreach ($logs as $log) {
                if (strpos($log->mensagem, 'logou/entrou') !== false) {
                    $status['qttyAccessAll'] ++;
                    if (date("Y-m-d", now()) == date("Y-m-d", strtotime($log->data))) {
                        $status['qttyAccessToday'] ++;
                    }
                } else {
                    $status['qttyBlockedAccessAll'] ++;
                    if (date("Y-m-d", now()) == date("Y-m-d", strtotime($log->data))) {
                        $status['qttyBlockedAccessToday'] ++;
                    }
                }
            }
        } else {
            $status = FALSE;
        }
        return $status;
    }

}
