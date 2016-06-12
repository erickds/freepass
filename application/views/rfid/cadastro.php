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
                        <?php if ($action === "cad_rfid" || $action === "edit_rfid") { ?>
                            <div>
                                <a class="btn btn-default" href="cartoes?opType=1" role="button">
                                    Voltar</a>
                            </div><br>
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Cadastro de RFID</div>
                                <form action="<?php
                                if ($action === "edit_rfid" && $status === "ativo") {
                                    echo site_url("cadastro/updateRfid");
                                } else if ($status === "ativo") {
                                    echo site_url("cadastro/insertRfid");
                                } else {
                                    echo site_url("cadastro/aceitaCadastroRfid");
                                }
                                ?>" method="POST">
                                    <div class="panel-body">
                                        <span class="col-md-12">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="rfid">RFID</label>
                                                    <input type="number" class="form-control" id="rfid" name="rfid" value="<?php if ($action === "edit_rfid") echo $rfid ?>" placeholder="RFID">
                                                </div>
                                            </div>
                                            <div class="col-md-5 form-group">
                                                <label for="selectUser">Utilizado Por</label>

                                                <select class="form-control" id="selectUser" name="selectUser">
                                                    <option value="" <?php
                                                    if (!$idUser) {
                                                        echo "selected=\"selected\"";
                                                    }
                                                    ?> </option>
                                                            <?php
                                                            foreach ($users as $user) {
                                                                echo "<option value=\"" .
                                                                $user->id . "\"";
                                                                if ($user->id == $idUser) {
                                                                    echo "selected=\"selected\"";
                                                                }
                                                                echo ">" . $user->nome . "</option>";
                                                            }
                                                            ?>
                                                </select>

                                            </div>
                                            <div class="col-md-3">
                                                <div class="checkbox" valign="center">
                                                    <label>
                                                        <br>
                                                        <input type="checkbox" name="rfidActive" id="rfidActive" value="1"
                                                               <?php if ($action === "edit_rfid" && $rfidActive === "1") echo "checked" ?> ><b>Ativo</b>
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-default">Salvar</button>
                                            </div>
                                        </span>
                                    </div>
                                </form>
                            </div>

                        <?php } else if ($action === "cad_user" || $action === "edit_user") { ?>
                            <div>
                                <a class="btn btn-default" href="home?opType=2" role="button">
                                    Voltar</a>
                            </div><br>
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Cadastro de Usuário</div>
                                <div class="panel-body">
                                    <form action="<?php
                                    if ($action === "edit_user") {
                                        echo site_url("cadastro/update");
                                    } else {
                                        echo site_url("cadastro/insert");
                                    }
                                    ?>" method="POST" enctype="multipart/form-data">
                                        <div class="form-group col-md-12">
                                            <div class="form-group">
                                                <label for="foto">Foto</label>
                                                <input type="file" name="inputFile" id="inputFile">
                                                <p class="help-block">Escolha uma imagem nos formatos jpg/png.</p>
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group">
                                                <label for="nome">CPF</label>
                                                <input type="text" name="cpf" value="<?php
                                                if ($action === "edit_user") {
                                                    echo $cpfUser . "\" readonly";
                                                } else {
                                                    echo "\"";
                                                }
                                                ?>" class="form-control" id="cpf" placeholder="CPF">
                                            </div>
                                        </div>
                                        <div class="col-md-8 form-group">
                                            <div class="form-group">
                                                <label for="nome">Nome</label>
                                                <input type="text" name="nome" value="<?php if ($action === "edit_user") echo $nomeUser ?>" class="form-control" id="nome" placeholder="Nome">
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group">
                                                <label for="email">E-mail</label>
                                                <input type="email" name="email" value="<?php if ($action === "edit_user") echo $emailUser ?>" class="form-control" id="email" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group">
                                                <label for="senha">Password</label>
                                                <input type="password" name="senha" value="" class="form-control" id="senha" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <div class="form-group">
                                                <label for="end">Telefone</label>
                                                <input type="text" name="telefone" value="<?php if ($action === "edit_user") echo $telefoneUser ?>" class="form-control" id="telefone" placeholder="Telefone">
                                            </div>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <div class="form-group">
                                                <label for="end">Endereço</label>
                                                <input type="text" name="endereco" value="<?php if ($action === "edit_user") echo $enderecoUser ?>" class="form-control" id="endereco" placeholder="Endereço">
                                            </div>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            Departamento:
                                            <select name="dpto" class="form-control">
                                                <option value="1" <?php if ($action === "edit_user" && $dptoUser == "1") echo "selected=\"selected\"" ?> >Compras</option>
                                                <option value="2" <?php if ($action === "edit_user" && $dptoUser == "2") echo "selected=\"selected\"" ?> >Marketing</option>
                                                <option value="3" <?php if ($action === "edit_user" && $dptoUser == "3") echo "selected=\"selected\"" ?>>Operacional</option>
                                                <option value="4" <?php if ($action === "edit_user" && $dptoUser == "4") echo "selected=\"selected\"" ?> >Administração</option>
                                            </select>
                                        </div>
                                        <div class="col-md-2 form-group">
                                            <div class="checkbox">
                                                <br>
                                                <label>
                                                    <input type="checkbox" name="isAdmin" value="1"
                                                           <?php if ($action === "edit_user" && $isAdminUser === "1") echo "checked" ?> > Administrador
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6 form-group">
                                            <div class="checkbox">
                                                <br>
                                                <label>
                                                    <input type="checkbox" name="isActive" value="1"
                                                           <?php if ($action === "edit_user" && $isActive === "1") echo "checked" ?> > Usuário Ativo
                                                </label>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-md-12">
                                                    <div class="panel panel-default">
                                                        <div class="panel-body">
                                                            <div class="col-md-12">
                                                                <b>Períodos</b>
                                                            </div>
                                                            <?php
                                                            foreach ($periodos as $periodo) {
                                                                if ($pessoa_periodos) {
                                                                    ?>
                                                                    <div class = "col-md-2">
                                                                        <label class = "checkbox-inline">
                                                                            <input type = "checkbox" 
                                                                                   name = "<?php echo $periodo->nome ?>" 
                                                                                   value = "<?php echo $periodo->idperiodo ?>" 
                                                                                   <?php
                                                                                   if (in_array($periodo->idperiodo, $pessoa_periodos)) {
                                                                                       echo "checked";
                                                                                   }
                                                                                   ?>
                                                                                   />
                                                                                   <?php echo $periodo->nome; ?>
                                                                        </label>
                                                                    </div>
                                                                <?php } else {
                                                                    ?>
                                                                    <div class = "col-md-2">
                                                                        <label class = "checkbox-inline">
                                                                            <input type = "checkbox" 
                                                                                   name = "<?php echo $periodo->nome ?>" 
                                                                                   value = "<?php echo $periodo->idperiodo ?>" 
                                                                                   />
                                                                                   <?php echo $periodo->nome; ?>
                                                                        </label>
                                                                    </div>
                                                                    <?php
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>  
                                        </div>

                                        <div class="col-md-6 form-group">
                                            <button type="submit" class="btn btn-default">Salvar</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php } else if (($action === "cad_horario") || ($action === "edit_horario")) { ?>
                            <div>
                                <a class="btn btn-default" href="horarios" role="button">
                                    Voltar</a>
                            </div><br>
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Cadastro de Horário</div>
                                <div class="panel-body">
                                    <form action="<?php
                                    if ($action === "edit_horario") {
                                        echo site_url("cadastro/updateHorario");
                                    } else {
                                        echo site_url("cadastro/insertHorario");
                                    }
                                    ?>" method="POST">
                                        <span class="col-md-12">
                                            <?php
                                            if ($action === "edit_horario") {
                                                echo "<input type=\"hidden\" name=\"idhorario\" value=\"" . $idhorario . "\"/>";
                                            }
                                            ?>
                                            <div class="form-group col-md-4">
                                                <label for="nome">Nome</label>
                                                <input type="text" name="nome" value="<?php if ($action === "edit_horario") echo $nome ?>" class="form-control" id="nome" placeholder="Nome">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="horainicio">Início</label>
                                                <input type="time" name="horainicio" value="<?php if ($action === "edit_horario") echo date("H:i", strtotime($horainicio)); ?>" class="form-control" id="horainicio" placeholder="Horário Início">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="horafim">Fim</label>
                                                <input type="time" name="horafim" value="<?php if ($action === "edit_horario") echo date("H:i", strtotime($horafim)); ?>" class="form-control" id="horafim" placeholder="Horário Fim">
                                            </div>
                                            <div class="col-md-12">
                                                <b>Dias da Semana</b><br>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="seg" value="1"
                                                           <?php if ($action === "edit_horario" && $seg === "1") echo "checked" ?> > Seg
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="ter" value="1"
                                                           <?php if ($action === "edit_horario" && $ter === "1") echo "checked" ?> > Ter
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="qua" value="1"
                                                           <?php if ($action === "edit_horario" && $qua === "1") echo "checked" ?> > Qua
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="qui" value="1"
                                                           <?php if ($action === "edit_horario" && $qui === "1") echo "checked" ?> > Qui
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="sex" value="1"
                                                           <?php if ($action === "edit_horario" && $sex === "1") echo "checked" ?> > Sex
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="sab" value="1"
                                                           <?php if ($action === "edit_horario" && $sab === "1") echo "checked" ?> > Sáb
                                                </label>
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="dom" value="1"
                                                           <?php if ($action === "edit_horario" && $dom === "1") echo "checked" ?> > Dom
                                                </label>
                                            </div>
                                            <span class="checkbox col-md-12">
                                                <button type="submit" class="btn btn-default">Salvar</button>
                                            </span>

                                        </span>
                                    </form>
                                </div>
                            </div>
                        <?php }else if (($action === "cad_periodo") || ($action === "edit_periodo")) { ?>
                            <div>
                                <a class="btn btn-default" href="periodos" role="button">
                                    Voltar</a>
                            </div><br>
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Cadastro de Período</div>
                                <div class="panel-body">
                                    <form action="<?php
                                    if ($action === "edit_periodo") {
                                        echo site_url("cadastro/updatePeriodo");
                                    } else {
                                        echo site_url("cadastro/insertPeriodo");
                                    }
                                    ?>" method="POST">
                                        <span class="col-md-12">
                                            <?php
                                            if ($action === "edit_periodo") {
                                                echo "<input type=\"hidden\" name=\"idperiodo\" value=\"" . $idperiodo . "\"/>";
                                            }
                                            ?>
                                            <div class="form-group col-md-4">
                                                <label for="nome">Nome</label>
                                                <input type="text" name="nome" value="<?php if ($action === "edit_periodo") echo $nome ?>" class="form-control" id="nome" placeholder="Nome">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="datainicio">Início</label>
                                                <input type="date" name="datainicio" value="<?php if ($action === "edit_periodo") echo date('Y-m-d', strtotime($datainicio)); ?>" class="form-control" id="datainicio" placeholder="Data de Início">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="datafim">Fim</label>
                                                <input type="date" name="datafim" value="<?php if ($action === "edit_periodo") echo date('Y-m-d', strtotime($datafim)); ?>" class="form-control" id="datafim" placeholder="Data de Fim">
                                            </div>
                                            <div class="col-md-12">
                                                <label class="checkbox-inline">
                                                    <input type="checkbox" name="feriadoAtivo" value="1"
                                                           <?php if ($action === "edit_periodo" && $feriadoAtivo === "1") echo "checked" ?> > Ativo nos Feriados
                                                </label>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="col-md-12">
                                                        <div class="panel panel-default">
                                                            <div class="panel-body">
                                                                <div class="col-md-12">
                                                                    <b>Horários</b>
                                                                </div>
                                                                <?php
                                                                if($horarios)
                                                                foreach ($horarios as $horario) {
                                                                    if ($periodo_horarios) {
                                                                        ?>
                                                                        <div class = "col-md-3">
                                                                            <label class = "checkbox-inline">
                                                                                <input type = "checkbox" 
                                                                                       name = "<?php echo $horario->nome ?>" 
                                                                                       value = "<?php echo $horario->idhorario ?>" 
                                                                                       <?php
                                                                                       if (in_array($horario->idhorario, $periodo_horarios)) {
                                                                                           echo "checked";
                                                                                       }
                                                                                       ?>
                                                                                       />
                                                                                       <?php echo $horario->nome; ?>
                                                                            </label>
                                                                        </div>
                                                                    <?php } else {
                                                                        ?>
                                                                        <div class = "col-md-3">
                                                                            <label class = "checkbox-inline">
                                                                                <input type = "checkbox" 
                                                                                       name = "<?php echo $horario->nome ?>" 
                                                                                       value = "<?php echo $horario->idhorario ?>" 
                                                                                       />
                                                                                       <?php echo $horario->nome; ?>
                                                                            </label>
                                                                        </div>
                                                                        <?php
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>  
                                            </div>

                                            <span class="checkbox col-md-12">
                                                <button type="submit" class="btn btn-default">Salvar</button>
                                            </span>

                                        </span>
                                    </form>
                                </div>
                            </div>
                        <?php } else if (($action === "cad_feriado") || ($action === "edit_feriado")) { ?>
                            <div>
                                <a class="btn btn-default" href="feriados" role="button">
                                    Voltar</a>
                            </div><br>
                            <div class="panel panel-default">
                                <!-- Default panel contents -->
                                <div class="panel-heading">Cadastro de Feriado</div>
                                <div class="panel-body">
                                    <form action="<?php
                                    if ($action === "edit_feriado") {
                                        echo site_url("cadastro/updateFeriado");
                                    } else {
                                        echo site_url("cadastro/insertFeriado");
                                    }
                                    ?>" method="POST">
                                        <span class="col-md-12">
                                            <?php
                                            if ($action === "edit_feriado") {
                                                echo "<input type=\"hidden\" name=\"idferiado\" value=\"" . $idferiado . "\"/>";
                                            }
                                            ?>
                                            <div class="form-group col-md-4">
                                                <label for="nome">Nome</label>
                                                <input type="text" name="nome" value="<?php if ($action === "edit_feriado") echo $nome ?>" class="form-control" id="nome" placeholder="Nome">
                                            </div>
                                            <div class="form-group col-md-4">
                                                <label for="data">Data</label>
                                                <input type="date" name="data" value="<?php if ($action === "edit_feriado") echo date('Y-m-d', strtotime($data)); ?>" class="form-control" id="data" placeholder="Data">
                                            </div>
                                            <span class="checkbox col-md-12">
                                                <button type="submit" class="btn btn-default">Salvar</button>
                                            </span>
                                        </span>
                                    </form>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                    <?php
                }
                ?>
            </div>

        </div>
    </div>
</div>
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
</body>
</html>