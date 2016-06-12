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
                <div class="row page-header">
                    <div class="col-md-12">
                        <div class="col-md-1">
                            <div class="img-circle"style="margin:auto; height:50px;width: 50px;background-size: cover;
                                 background-image: url('<?php echo base_url($this->session->userdata('foto')) ?>')">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <h1 style="margin: auto">
                                <small> <?php echo $this->session->userdata('userName') ?> </small></h1>
                            <div><a href="./sair">Sair</a></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-3">

                        <ul class="nav nav-pills nav-stacked">
                            <li role="presentation" class="<?php if ($action === "usuarios") echo "active" ?>"><a href="home?opType=2">Usuários</a></li>
                            <li role="presentation" class="<?php if ($action === "horarios") echo "active" ?>"><a href="horarios">Horários</a></li>
                            <li role="presentation" class="<?php if ($action === "periodos") echo "active" ?>"><a href="periodos">Períodos</a></li>
                            <li role="presentation" class="<?php if ($action === "feriados") echo "active" ?>"><a href="feriados">Feriados</a></li>
                            <li role="presentation" class="<?php if ($action === "cartoes") echo "active" ?>"><a href="cartoes?opType=1">Cartões / RFID</a></li>
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
                                                    if ($user->id) {
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
                                                }
                                            } else {
                                                echo "<tr><td colspan=\"4\" align=\"center\">Sem usuários para exibir</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } else if ($action === "cartoes") { ?>

                            <div class="col-md-3">
                                <form action="cartoes" method="GET">
                                    <div class="input-group">
                                        <input type="text" class="form-control" name="pin" id="pin" placeholder="Procurar PIN">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-3">
                                <form action="cartoes" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="search" id="search" class="form-control" placeholder="Procurar RFID">
                                        <span class="input-group-btn">
                                            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-search"></span></button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                            <div>
                                <a class="btn btn-default" href="cadastrarRFID" role="button">
                                    Cadastrar Novo</a>
                            </div><br>
                            <div class="col-md-12">
                                <div class="panel panel-default">
                                    <!-- Default panel contents -->
                                    <div class="panel-heading">Cartão RFID</div>
                                    <div class="panel-body">
                                        <a href="?opType=1" style="float:left;margin: 5px"> Ver Cadastrados</a>
                                        <a href="?opType=2" style="float:left;margin: 5px">Ver Solicitações</a>
                                        <table class="table">
                                            <?php if ($status === "ativos") { ?>
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
                                                        echo "<form action='editarRfid' method='post'>";
                                                        echo "<tr><td>";
                                                        echo $user_rfid->rfid;
                                                        echo"</td><td>";
                                                        echo $user_rfid->nome;
                                                        echo "</td><td>";
                                                        echo $user_rfid->rfidActive;
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
                                                        echo "</form>";
                                                    }
                                                    ?>
                                                </tbody>
                                            <?php } else if ($status === "pendentes") { ?>
                                                <thead>
                                                    <tr>
                                                        <th>PIN</th>
                                                        <th>RFID</th>
                                                        <th>Data/Hora da Solicitação</th>
                                                        <th>Opções</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    foreach ($rfid_pendentes as $rfid_pendente) {
                                                        echo "<form action='editarRfid' method='post'>";
                                                        echo "<tr><td>";
                                                        echo $rfid_pendente->pin;
                                                        echo"</td><td>";
                                                        echo $rfid_pendente->rfid;
                                                        echo "</td><td>";
                                                        echo date("d-m-Y - H:i:s", strtotime($rfid_pendente->data));
                                                        echo "</td><td>" .
                                                        "<div class='btn-group' role='group' aria-label='...'>" .
                                                        "<button type='submit' name='edit' value='" .
                                                        $rfid_pendente->rfid .
                                                        "' class='btn btn-default'><span class='glyphicon glyphicon-edit'></span></button>" .
                                                        "<button type='submit' name='delete' value='" .
                                                        $rfid_pendente->rfid .
                                                        "'class='btn btn-default'><span class='glyphicon glyphicon-trash'></span></button>" .
                                                        "</div>" .
                                                        "</td></tr>";
                                                        echo "</form>";
                                                    }
                                                    ?>
                                                </tbody>
                                            <?php } ?>
                                        </table>
                                    </div>
                                </div>
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
                                        echo date("d-m-Y - H:i:s", strtotime($log->data));
                                        echo"</td><td>";
                                        echo $log->mensagem;
                                        echo "</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        <?php } else if ($action === "horarios") { ?>
                            <div>
                                <a class="btn btn-default" href="cadastrarHorario" role="button">
                                    Cadastrar Novo</a>
                            </div><br>
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Horários</div>
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Início</th>
                                                <th>Fim</th>
                                                <th>Dias</th>
                                                <th>Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($horarios as $horario) {
                                                echo "<form action='editarHorario' method='post'>";
                                                echo "<tr><td>";
                                                echo $horario->nome;
                                                echo"</td><td>";
                                                echo date("H:i", strtotime($horario->horainicio));
                                                echo"</td><td>";
                                                echo date("H:i", strtotime($horario->horafim));
                                                echo "</td><td>";
                                                $strDays = "";
                                                if ($horario->seg) {
                                                    $strDays .= "seg-";
                                                }
                                                if ($horario->ter) {
                                                    $strDays .= "ter-";
                                                }
                                                if ($horario->qua) {
                                                    $strDays .= "qua-";
                                                }
                                                if ($horario->qui) {
                                                    $strDays .= "qui-";
                                                }
                                                if ($horario->sex) {
                                                    $strDays .= "sex-";
                                                }
                                                if ($horario->sab) {
                                                    $strDays .= "sab-";
                                                }
                                                if ($horario->dom) {
                                                    $strDays .= "dom-";
                                                }
                                                echo substr($strDays, 0, -1);
                                                echo "</td><td>" .
                                                "<div class='btn-group' role='group' aria-label='...'>" .
                                                "<button type='submit' name='edit' value='" .
                                                $horario->idhorario .
                                                "' class='btn btn-default'><span class='glyphicon glyphicon-edit'></span></button>" .
                                                "<button type='submit' name='delete' value='" .
                                                $horario->idhorario .
                                                "'class='btn btn-default'><span class='glyphicon glyphicon-trash'></span></button>" .
                                                "</div>" .
                                                "</td></tr>";
                                                echo "</form>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } else if ($action === "periodos") { ?>
                            <div>
                                <a class="btn btn-default" href="cadastrarPeriodo" role="button">
                                    Cadastrar Novo</a>
                            </div><br>
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Períodos</div>
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Início</th>
                                                <th>Fim</th>
                                                <th>Ativo nos Feriados</th>
                                                <th>Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($periodos as $periodo) {
                                                echo "<form action='editarPeriodo' method='post'>";
                                                echo "<tr><td>";
                                                echo $periodo->nome;
                                                echo"</td><td>";
                                                echo date('d-m-Y', strtotime($periodo->datainicio));
                                                echo"</td><td>";
                                                echo date('d-m-Y', strtotime($periodo->datafim));
                                                echo "</td><td>";
                                                if ($periodo->feriadoAtivo) {
                                                    echo "Sim";
                                                } else {
                                                    echo "Não";
                                                }
                                                echo "</td><td>" .
                                                "<div class='btn-group' role='group' aria-label='...'>" .
                                                "<button type='submit' name='edit' value='" .
                                                $periodo->idperiodo .
                                                "' class='btn btn-default'><span class='glyphicon glyphicon-edit'></span></button>" .
                                                "<button type='submit' name='delete' value='" .
                                                $periodo->idperiodo .
                                                "'class='btn btn-default'><span class='glyphicon glyphicon-trash'></span></button>" .
                                                "</div>" .
                                                "</td></tr>";
                                                echo "</form>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php } else if ($action === "feriados") { ?>
                            <div>
                                <a class="btn btn-default" href="cadastrarFeriado" role="button">
                                    Cadastrar Novo</a>
                            </div><br>
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Feriados</div>
                                <div class="panel-body">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Nome</th>
                                                <th>Data</th>
                                                <th>Opções</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($feriados as $feriado) {
                                                echo "<form action='editarFeriado' method='post'>";
                                                echo "<tr><td>";
                                                echo $feriado->nome;
                                                echo"</td><td>";
                                                echo date('d-m-Y', strtotime($feriado->data));
                                                echo "</td><td>" .
                                                "<div class='btn-group' role='group' aria-label='...'>" .
                                                "<button type='submit' name='edit' value='" .
                                                $feriado->idferiado .
                                                "' class='btn btn-default'><span class='glyphicon glyphicon-edit'></span></button>" .
                                                "<button type='submit' name='delete' value='" .
                                                $feriado->idferiado .
                                                "'class='btn btn-default'><span class='glyphicon glyphicon-trash'></span></button>" .
                                                "</div>" .
                                                "</td></tr>";
                                                echo "</form>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
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