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
        <div class="container">
            <div class="row">
                <div class="page-header" align="center">
                    <h1>Cadastro</h1>
                    <h5>Gerencie aqui seu cadastro</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-2 col-md-8" >
                    <div>
                        <a class="btn btn-default" href="<?php echo site_url("home") ?>" role="button">
                            Voltar</a>
                    </div><br>
                    <div class="panel panel-default">
                        <!-- Default panel contents -->
                        <div class="panel-heading">Cadastro de Usuário</div>
                        <div class="panel-body">
                            <form action="<?php echo site_url("cadastro/updateUser"); ?>" method="POST" enctype="multipart/form-data"> <!--FIXME Adicionar action p/ controller-->
                                <div class="col-md-12">
                                    <div class="form-group col-md-12">
                                        <label for="foto">Foto</label>
                                        <input type="file" name="inputFile" id="inputFile">
                                        <p class="help-block">Escolha uma imagem nos formatos jpg/png.</p>
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="cpf" maxlength="12">CPF</label>
                                        <input type="text" name="cpf" value="<?php
                                        if ($action === "edit_user") {
                                            echo $cpfUser ;
                                        } else {
                                            echo "\"";
                                        }
                                        ?>" <?php
                                        if ($action === "edit_user") {
                                            echo "readonly" ;
                                        }?> class="form-control" id="cpf" placeholder="CPF">
                                    </div>
                                    <div class="col-md-8 form-group">
                                        <label for="nome">Nome</label>
                                        <input type="text" name="nome" value="<?php if ($action === "edit_user") echo $nomeUser ?>" class="form-control" id="nome" placeholder="Nome">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="email">E-mail</label>
                                        <input type="email" name="email" value="<?php if ($action === "edit_user") echo $emailUser ?>" class="form-control" id="email" placeholder="Email">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="senha">Password</label>
                                        <input type="password" name="senha" class="form-control" id="senha" placeholder="Password">
                                    </div>
                                    <div class="col-md-4 form-group">
                                        <label for="end">Telefone</label>
                                        <input type="text" name="telefone" value="<?php if ($action === "edit_user") echo $telefoneUser ?>" class="form-control" id="telefone" placeholder="Telefone">
                                    </div>
                                    <div class="col-md-12 form-group">
                                        <label for="end">Endereço</label>
                                        <input type="text" name="endereco" value="<?php if ($action === "edit_user") echo $enderecoUser ?>" class="form-control" id="endereco" placeholder="Endereço">
                                    </div>

                                    <div class="col-md-3 form-group">
                                        <label for="dpto">Departamento</label>
                                        <select name="dpto" class="form-control">
                                            <option value="1" <?php if ($action === "edit_user" && $dptoUser == "1") echo "selected=\"selected\"" ?> >Compras</option>
                                            <option value="2" <?php if ($action === "edit_user" && $dptoUser == "2") echo "selected=\"selected\"" ?> >Marketing</option>
                                            <option value="3" <?php if ($action === "edit_user" && $dptoUser == "3") echo "selected=\"selected\"" ?>>Operacional</option>
                                            <option value="4" <?php if ($action === "edit_user" && $dptoUser == "4") echo "selected=\"selected\"" ?> >Administração</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group col-md-3">
                                        <button type="submit" class="btn btn-default center-block form-control">Enviar</button>
                                    </div>
                                </div>
                            </form>
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