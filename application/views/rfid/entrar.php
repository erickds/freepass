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
                <div class="col-md-4 col-md-offset-4" >
                    <div class="page-header">
                        <h1>Insira o RFID <br><small>9 Dígitos</small></h1>
                    </div>
                    <?php if ($alerta != null) { ?>
                        <div class="alert alert-danger">
                            <?php echo $alerta["mensagem"]; ?>
                        </div>
                    <?php } ?>
                    <form action="<?php echo base_url('rfid/entrar'); ?>" method="POST">
                        <div class="form-group">
                            <label for="rfid">RFID:</label>
                            <input type="text" class="form-control" name="rfid" id="rfid" placeholder="000000000">
                        </div>
                        <div class="center-block">
                            <a href="rfid/pre_cadastro" name="entrar" value="entrar" class="btn btn-primary">Pré-Cadastro</a>
                            <button type="submit" name="entrar" value="entrar" class="btn btn-success">Entrar</button>                                  
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <!-- Include all compiled plugins (below), or include individual files as needed -->
        <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    </body>
</html>