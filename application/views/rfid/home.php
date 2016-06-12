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
                    <div class="col-md-4 col-md-offset-4" >
                        <div class="page-header">
                            <div class="img-circle"style="margin:auto; height:150px;width: 150px;background-size: cover;
                                 background-image: url('<?php echo base_url($this->session->userdata('foto')) ?>')">
                            </div>

                            <div style="margin:auto">
                                <h1 style="text-align:center"><?php echo $this->session->userdata('nome') ?>
                                    <br>
                                    <small style="margin:auto"><?php echo $this->session->userdata('rfid') ?></small>
                                </h1>
                            </div>
                            <div style="text-align: center">
                                <a href="<?php echo base_url() ?>home/dados">Meus Dados</a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?php echo base_url() ?>home/cartoes">Meus Cartões</a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?php echo base_url() ?>home/logs">Meus Acessos</a>
                                &nbsp;&nbsp;&nbsp;
                                <a href="<?php echo base_url() ?>home/sair">Sair</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
            }
            ?>
            <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    </body>
</html>