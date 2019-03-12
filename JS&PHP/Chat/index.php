<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Chat</title>
        <meta charset="UTF-8">
        <meta name="description" content="Chat Local Dwes">
        <meta name="keywords" content="HTML,CSS,XML,JavaScript">
        <meta name="autor" content="Rafa Anthony Kiko">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link href="recursos/css/index_css.css" rel="stylesheet" type="text/css"/>
        <script src="recursos/jquery/jquery-3.3.1.js" type="text/javascript"></script><!-- BOOTSTRAP LOCAL -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
        <link href="recursos/bootstrap/bootstrap-3.3.7-dist/css/bootstrap.min.css" rel="stylesheet" type="text/css"/><!-- JQUERY LOCAL -->
        <script>var host = "<?php echo gethostbyname(gethostname()); ?>";</script>
        <script src="recursos/js/socket.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-xs-12 col-m-5">
                    <h1 class="page-header centrado">Chat Local</h1>
                    <div class="jumbotron">
                        <form name="frmChat" id="frmChat">
                            <div id="chat-box"></div>
                            <div class="form-group">
                                <input type="text" name="usuario" id="input-user" placeholder="Nombre" class="chat-input form-control" required="required" />
                                <small id="ayudaNombre" class="form-text text-muted">Introduce el nombre que quieres tener en el chat.</small>
                            </div>
                            <div class="form-group">
                                <input type="text" name="mensaje" id="input-mensaje" placeholder="Mensaje"  class="chat-input form-control" required="required" />
                                <small id="ayudaNombre" class="form-text text-muted">Introduce el mensaje a enviar.</small>
                            </div>
                            <input type="submit" name="enviar-mensaje" class="btn btn-primary" id="btnSend" value="Enviar">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>