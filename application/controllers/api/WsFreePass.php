<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class WsFreePass extends REST_Controller {

    function __construct()
    {
        // Construct the parent class
        parent::__construct();

    }

    public function rfid_validate_post()
    {        
        $log = null;
        $this->load->helper('date');
        $this->load->model('Rfid_model');
        $rfid = $this->input->get('id');
        //valida no banco
        $rfid_ok = $this->Rfid_model->check_rfid($rfid);
        if($rfid_ok){
            if($rfid_ok[0]->isActive == 1){
                $message = [
                    'v' => 't'
                ];
                $log = array(
                   'data' => date("Y-m-d H:i:s"),
                   'id_pessoa' => $rfid_ok[0]->id,
                   'id_cartao' => $rfid,
                   'mensagem' => "Usuário " . $rfid_ok[0]->nome . " logou/entrou com o RFID:" . $rfid
                );
            }else{
                    $message = [
                        'v' => 'f'
                    ]; 
                    $log = array(
                       'data' => date("Y-m-d H:i:s"),
                       'id_pessoa' => $rfid_ok[0]->id,
                       'id_cartao' => $rfid,
                       'mensagem' => "Usuário " . $rfid_ok[0]->nome . " tentou logar/entrar com o um cartão bloqueado RFID:" . $rfid
                    );
                }
        }else{

            $message = [
                'v' => 'f'
            ]; 
            //se não houver no banco nem em pendentes nem em cadastradas
            if(! $this->Rfid_model->check_rfid_exists($rfid) || $this->Rfid_model->check_rfid_pendent($rfid)){
                //INSERT DA RFID NA TABELA PENDENT, PARA FICAR DISPONÍVEL AO ADMIN AO CADATRAR UM USUÁRIO

            }

            $log = array(
               'data' => date("Y-m-d H:i:s"),
               'id_cartao' => $rfid,
               'mensagem' => "Usuário desconhecido tentou logar/entrar com o RFID:" . $rfid
            );

        }
        $this->load->model("Log_model");
        $this->Log_model->insert($log);

        $rfidPendente = array(
           'data' => date("Y-m-d H:i:s"),
           'rfid' => $rfid
        );
        $this->User_model->insert_rfid_pendente($rfidPendente);
            
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

}
