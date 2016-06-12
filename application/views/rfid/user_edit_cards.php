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
                    <h1>Gerenciamento de Cartões</h1>
                    <h5>Gerencie aqui seus cartões RFID.</h5>
                </div>
            </div>
            <div class="row">
                <div class="col-md-offset-2 col-md-8" >

                    <div class="col-md-12">
                        <div>
                            <a class="btn btn-default" href="./" role="button">
                                Voltar</a>
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
                                            <th>Ativar/Desativar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if ($user_rfids) {
                                            foreach ($user_rfids as $user_rfid) {
                                                echo "<form action='../cadastro/ativaDesativaRfid' method='post'>";
                                                echo "<tr><td>";
                                                echo $user_rfid->rfid;
                                                echo"</td><td>";
                                                echo $user_rfid->nome;
                                                echo "</td><td>";
                                                echo $user_rfid->rfidActive;
                                                echo "</td><td>" .
                                                "<div class='btn-group' role='group' aria-label='...'>" .
                                                "<button type='submit' name='ativa' value='" .
                                                $user_rfid->rfid .
                                                "' class='btn btn-default'><span class='glyphicon glyphicon-ok'></span></button>" .
                                                "<button type='submit' name='desativa' value='" .
                                                $user_rfid->rfid .
                                                "'class='btn btn-default'><span class='glyphicon glyphicon-remove'></span></button>" .
                                                "</div>" .
                                                "</td></tr>";
                                                echo "</form>";
                                            }
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
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