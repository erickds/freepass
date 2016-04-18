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
        // se for cadastro inserido pelo master
        if($this->input->get('masterCad') == 1){
          $rfid_insert = array(
             'rfid' => $rfid,
             'isActive' => 0,
             'id_pessoa' => 0
          );
          if($this->User_model->insert_rfid($rfid_insert)){
            //retorna c para indicar cadastro efetuado pelo Master
            $message = [
                'v' => 'c'
            ];
            $log = array(
                   'data' => date("Y-m-d H:i:s"),
                   'id_cartao' => $rfid,
                   'mensagem' => "Master cadastrou o RFID:" . $rfid
                );
          }
        }else{
          //valida no banco se há rfid atrelado a um usuário e master, para cadastrar ou liberar entrada
          $rfid_ok = $this->Rfid_model->check_rfid($rfid);
          if($this->Rfid_model->check_rfid($rfid)){
              if($rfid_ok[0]->isActive == 1){
                // se for master, retornar m para o arduino para efetuar cadastro
                if($rfid_ok[0]->isMaster == 1){
                  $message = [
                      'v' => 'm'
                  ];
                  $log = array(
                     'data' => date("Y-m-d H:i:s"),
                     'id_pessoa' => $rfid_ok[0]->id,
                     'id_cartao' => $rfid,
                     'mensagem' => "Usuário " . $rfid_ok[0]->nome . " logou/entrou com o RFID:" . $rfid
                  );
                }else{
                  //se não for master, retornar t para arduino liberar entrada
                  $message = [
                      'v' => 't'
                  ];
                  $log = array(
                     'data' => date("Y-m-d H:i:s"),
                     'id_pessoa' => $rfid_ok[0]->id,
                     'id_cartao' => $rfid,
                     'mensagem' => "Usuário " . $rfid_ok[0]->nome . " logou/entrou com o RFID:" . $rfid
                  );
                }

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
              //Senha 4 dígitos gerado pelo arduino para cadastrar a rfid
              do{
                $pin = rand(1111, 9999);    
              }while($this->Rfid_model->check_pin_exists($pin));
              //se não houver no banco nem em pendentes nem em cadastradas
              if(! $this->Rfid_model->check_rfid_exists($rfid) && ! $this->Rfid_model->check_rfid_pendente($rfid)){
                  //INSERT DA RFID NA TABELA PENDENT, PARA FICAR DISPONÍVEL AO ADMIN AO CADATRAR UM USUÁRIO
                  $rfid_pendente = array(
                    'data' => date("Y-m-d H:i:s"),
                    'rfid' => $rfid,
                    'pin' => $pin
                  );
                  $this->Rfid_model->insert_rfid_pendente($rfid_pendente);
                  $message = [
                    'v' => 'p',
                    'p' => $pin
                  ]; 
                  //Se já está nos pendentes, retorna o pin
              }else if($rfid_pendente = $this->Rfid_model->check_rfid_pendente($rfid)){
                  $message = [
                    'v' => 'p',
                    'p' => $rfid_pendente[0]->pin
                  ]; 
              }
              $log = array(
                 'data' => date("Y-m-d H:i:s"),
                 'id_cartao' => $rfid,
                 'mensagem' => "Usuário desconhecido tentou logar/entrar com o RFID:" . $rfid
              );
          }
      }
        $this->load->model("Log_model");
        $this->Log_model->insert($log);

        $rfidPendente = array(
           'data' => date("Y-m-d H:i:s"),
           'rfid' => $rfid
        );
        $this->set_response($message, REST_Controller::HTTP_CREATED); // CREATED (201) being the HTTP response code
    }

}
