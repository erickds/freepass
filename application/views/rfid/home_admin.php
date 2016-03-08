<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Free Pass</title>

    <!-- Bootstrap -->
    <link href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
  	<?php if($this->session->userdata('permitido') === TRUE){ ?>
  	<div class="container">
      <div class="row">
        <div class="page-header" align="center">
            <h1>Seja bem-vindo Admin.</h1>
          </div>
      </div>
  		<div class="row">
      <div class="col-md-3">
        <div class="page-header">
          <h1><?php echo $this->session->userdata('rfid') ?> 
            <small> <?php echo $this->session->userdata('userName') ?> </small></h1>
        </div>
        
        <ul class="nav nav-pills nav-stacked">
          <li role="presentation" class="<?php if($action === "usuarios") echo "active"?>"><a href="home">Usuários</a></li>
          <li role="presentation" class="<?php if($action === "cartoes") echo "active"?>"><a href="cartoes">Cartões / RFID</a></li>
          <li role="presentation" class="<?php if($action === "logs") echo "active"?>"><a href="logs">Logs</a></li>
        </ul>
      </div>
  			<div class="col-md-9" >
  			   <?php if($action === "usuarios"){ ?>
           <div>
             <a class="btn btn-default" href="cadastrarUsuario" role="button">
               Cadastrar Novo</a>
           </div><br>
              <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Usuários</div>
                <div class="panel-body">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Admin</th>
                        <th>Opções</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Joaozinho Feliz</td>
                        <td>joao@gmail.com</td>
                        <td>
                            <span class="glyphicon glyphicon-ok-circle"></span>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></button>
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Banana Feliz</td>
                        <td>banana@gmail.com</td>
                        <td>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></button>
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <td>Camelo Feliz</td>
                        <td>camelo@gmail.com</td>
                        <td>
                            <span class="glyphicon glyphicon-ok-circle"></span>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></button>
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
                            </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
              </div>

           <?php }else if($action === "cartoes") {?>
           <div>
             <a class="btn btn-default" href="cadastrarRFID" role="button">
               Cadastrar Novo</a>
           </div><br>
              <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Cartão RFID</div>
                <div class="panel-body">
                  
                  <table class="table">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Utilizador</th>
                        <th>Ativo</th>
                        <th>Opções</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>123456789</td>
                        <td>JOÃO</td>
                        <td>
                            <span class="glyphicon glyphicon-ok-circle"></span>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></button>
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <td>987654321</td>
                        <td>MARIA</td>
                        <td>
                            <span class="glyphicon glyphicon-remove-circle"></span>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></button>
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
                            </div>
                        </td>
                      </tr>
                      <tr>
                        <td>123321123</td>
                        <td>ANTÔNIO</td>
                        <td>
                            <span class="glyphicon glyphicon-ok-circle"></span>
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="...">
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-edit"></span></button>
                              <button type="button" class="btn btn-default"><span class="glyphicon glyphicon-trash"></span></button>
                            </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
              </div>
           <?php }else if($action === "logs") {?>
              LOGS
           <?php }?>
        </div>
  		</div>
    <?php
    }
    ?>
  	</div>


    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
  </body>
</html>