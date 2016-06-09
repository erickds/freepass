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
        <?php if ($this->session->userdata('permitido') === TRUE) { ?>
            <div class="container">
                <div class="row">
                    <div class="page-header" align="center">
                        <h1>Seja bem-vindo Admin.</h1>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">
                        <div class="page-header" align="center">
                            <div class="img-circle"style="height:200px;width: 200px;background-size: cover;
                                 background-image: url('<?php echo base_url($this->session->userdata('foto'))?>')">
                                
                            </div>
                            <h1>
                            <small> <?php echo $this->session->userdata('userName') ?> </small></h1>
                            <a href="./sair">Sair</a>
                        </div>

                        <ul class="nav nav-pills nav-stacked">
                            <li role="presentation" class="<?php if ($action === "usuarios") echo "active" ?>"><a href="home?opType=2">Usuários</a></li>
                            <li role="presentation" class="<?php if ($action === "cartoes") echo "active" ?>"><a href="cartoes">Cartões / RFID</a></li>
                            <li role="presentation" class="<?php if ($action === "logs") echo "active" ?>"><a href="logs">Logs</a></li>
                        </ul>
                    </div>
                    <div class="col-md-9" >
                        <?php if ($action === "usuarios") { ?>
                            <div>
                                <a class="btn btn-default" href="cadastrarUsuario" role="button">
                                            Cadastrar Novo</a>
                            </div><br>
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Usuários</div>
                                <div class="panel-body">
                                    <a href="?opType=1" style="float:left;margin: 5px">Ver Ativos</a>
                                    <a href="?opType=0" style="float:left;margin: 5px">Ver Inativos</a>
                                    <a href="?opType=2" style="float:left;margin: 5px"> Ver Todos</a>
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
                                            <?php
                                            if ($users != NULL) {
                                                foreach ($users as $user) {
                                                    echo "<form action='editarUsuario' method='post'>";
                                                    echo "<tr><td>";
                                                    echo $user->nome;
                                                    echo "</td><td>";
                                                    echo $user->email;
                                                    echo "</td><td>";
                                                    echo $user->isAdmin;
                                                    echo "</td><td>" .
                                                    "<div class='btn-group' role='group' aria-label='...'>" .
                                                    "<button type='submit' name='edit' value='" .
                                                    $user->id .
                                                    "' class='btn btn-default'><span class='glyphicon glyphicon-edit'></span></button>" .
                                                    "<button type='submit' name='delete' value='" .
                                                    $user->id .
                                                    "'class='btn btn-default'><span class='glyphicon glyphicon-trash'></span></button>" .
                                                    "</div>" .
                                                    "</td></tr>";
                                                    echo "</form>";
                                                }
                                            }else{
                                                echo "<tr><td colspan=\"4\" align=\"center\">Sem usuários para exibir</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>

                            <?php } else if ($action === "cartoes") { ?>
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
                                                <?php
                                                foreach ($rfid_users as $user_rfid) {

                                                    echo "<tr><td>";
                                                    echo $user_rfid->rfid;
                                                    echo"</td><td>";
                                                    echo $user_rfid->nome;
                                                    echo "</td><td>";
                                                    echo $user_rfid->isActive;
                                                    echo "</td><td>" .
                                                    "<div class='btn-group' role='group' aria-label='...'>" .
                                                    "<button type='submit' name='edit' value='" .
                                                    $user_rfid->rfid .
                                                    "' class='btn btn-default'><span class='glyphicon glyphicon-edit'></span></button>" .
                                                    "<button type='submit' name='delete' value='" .
                                                    $user_rfid->rfid .
                                                    "'class='btn btn-default'><span class='glyphicon glyphicon-trash'></span></button>" .
                                                    "</div>" .
                                                    "</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                <?php } else if ($action === "logs") { ?>
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Horário</th>
                                                <th>Evento</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($logs as $log) {
                                                echo "<tr><td>";
                                                echo $log->data;
                                                echo"</td><td>";
                                                echo $log->mensagem;
                                                echo "</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                <?php } ?>
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