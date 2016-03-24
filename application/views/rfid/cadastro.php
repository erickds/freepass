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
          <h1><?php echo $this->session->userdata('rfid') ?> <small>USERNAME</small></h1>
        </div>
        
        <ul class="nav nav-pills nav-stacked">
          <li role="presentation" class="<?php if($action === "usuarios") echo "active"?>"><a href="home">Usuários</a></li>
          <li role="presentation" class="<?php if($action === "cartoes") echo "active"?>"><a href="cartoes">Cartões / RFID</a></li>
          <li role="presentation" class="<?php if($action === "logs") echo "active"?>"><a href="logs">Logs</a></li>
        </ul>
      </div>
        <div class="col-md-9" >
          <div>
            <a class="btn btn-default" href="home" role="button">
              Voltar</a>
          </div><br>
           <?php if($action === "cad_rfid" || $action === "edit_rfid"){ ?>
              <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Cadastro de RFID</div>
                <div class="panel-body">
                  <form>
                    <div class="form-group">
                      <label for="exampleInputEmail1">RFID</label>
                      <input type="number" class="form-control" id="exampleInputEmail1" placeholder="RFID">
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox"> Ativo
                      </label>
                    </div>
                    <button type="submit" class="btn btn-default">Salvar</button>
                  </form>
              </div>
              <div class="panel-heading">Utilizado atualmente por:</div>
                <div class="panel-body">
                  <form>
                    <div class="form-group">
                      Usuário:
                      <select name="Usuário">
                          <option value="Joao">João</option>
                          <option value="Maria">Maria</option>
                          <option value="Inácio">Inacio</option>
                      </select>
                        <button type="submit" class="btn btn-default">Atribuir</button>
                    </div>
                  </form>
                </div>
              </div>

           <?php }else if($action === "cad_user" || $action === "edit_user") {?>
          
              <div class="panel panel-default">
                <!-- Default panel contents -->
                <div class="panel-heading">Cadastro de Usuários</div>
                <div class="panel-body">
                  <form action="<?php echo site_url("cadastro/insert");?>" method="POST"> <!--FIXME Adicionar action p/ controller-->
                    <div class="form-group">
                      <label for="foto">Foto</label>
                      <input type="file" name="foto" id="exampleInputFile">
                      <p class="help-block">Escolha uma imagem nos formatos jpg/png.</p>
                    </div>
                    <div class="form-group">
                      <label for="nome">CPF</label>
                      <input type="text" name="cpf" value="<?php if($action === "edit_user") echo $cpfUser?>" class="form-control" id="cpf" placeholder="CPF">
                    </div>
                    <div class="form-group">
                      <label for="nome">Nome</label>
                      <input type="text" name="nome" value="<?php if($action === "edit_user") echo $nomeUser?>" class="form-control" id="nome" placeholder="Nome">
                    </div>
                    <div class="form-group">
                      <label for="email">E-mail</label>
                      <input type="email" name="email" value="<?php if($action === "edit_user") echo $emailUser?>" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                      <label for="senha">Password</label>
                      <input type="password" name="senha" value=" <?php if($action === "edit_user") echo $pwdUser?> "class="form-control" id="senha" placeholder="Password">
                    </div>
                    <div class="form-group">
                      <label for="end">Endereço</label>
                      <input type="text" name="endereco" value="<?php if($action === "edit_user") echo $enderecoUser?>" class="form-control" id="endereco" placeholder="Endereço">
                    </div>
                    <div class="form-group">
                      <label for="end">Telefone</label>
                      <input type="text" name="telefone" value="<?php if($action === "edit_user") echo $telefoneUser?>" class="form-control" id="telefone" placeholder="Telefone">
                    </div>
                    <div>
                      Departamento:
                      <select name="dpto">
                          <option value="Compras">Compras</option>
                          <option value="Marketing">Marketing</option>
                          <option value="Operacional">Operacional</option>
                          <option value="Administração">Administração</option>
                      </select>
                    </div>
                    <div class="checkbox">
                      <label>
                        <input type="checkbox" name="isAdmin" value="1"
                        <?php if($action === "edit_user" && $isAdminUser === TRUE) echo "checked"?> > Administrador
                      </label>
                    </div>
                      <button type="submit" class="btn btn-default">Salvar</button>
                  </form>
                </div>
            
                <?php }else{?>
                LOGS

                <div>
                  OCORREU UM ERRO NA SOLICITAÇÃO!
                </div>
                <?php }?>
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