<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Telegram - BOT</title>
        <link href="assets/css/bootstrap.min.css" rel="stylesheet">
        <link href="assets/css/style.css" rel="stylesheet">
    </head>

    <body>

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <h2 class="navbar-title" >Telegram Bot</h2>
                </div>

            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Content -->
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="titulo-intro">Bem vindo ao ambiente de controle</h1>
                    <p>1) Para iniciar qualquer um dos dois procedimentos (ativar ou desativar o bot), inicialmente clique em <b>Download do certificado</b>."</p>
                    <p>2) Feito o download, clique em <b>Selecionar certificado</b>.</p>
                    <p>3) Para iniciar as atividades do BOT, clique em <b>Ativar Bot</b>.</p>
                    <p>4) Para interromper as atividades do BOT, clique em <b>Remover Bot</b>.</p>
                    <br />
                    <p><b>Observação: </b><i>Caso já tenha o certificado de antemão, não é necessário realizar a primeira etapa.</i></p>
                </div>
                <div class="col-md-8">
                    <div class="form-group actions">
                        <form id="form" action="" method="POST" enctype="multipart/form-data" role="form">
                            <input type='hidden' id="url" name='url' value='https://url_your_server/file_response.php'>
                            <p>
                                <a href="cert.crt" class="btn btn-primary" download>
                                    <span class="glyphicon glyphicon-download" aria-hidden="true"></span> Download do Certificado
                                </a>

                                <span class="btn btn-default btn-file">
                                    Selecionar o certificado <input type="file" name="certificate" id="certificate">
                                </span>
                            </p>
                            <div class="col">
                                <button id="ativar" type="button" class="btn btn-success">
                                    <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> Ativar Bot
                                </button>
                                <button id="desativar" type="button" value="Desativar Bot" class="btn btn-danger">
                                    <span class="glyphicon glyphicon-remove" aria-hidden="true"></span> Desativar Bot
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.container -->

        <!-- jQuery -->
        <script src="assets/js/jquery.js"></script>
        <script src="assets/js/request.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>

    </body>

</html>
