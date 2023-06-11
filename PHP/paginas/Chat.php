<!DOCTYPE html>
<html lang="es-ES">
<?php session_start();
include_once '../php/VerificarSesion.php';
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/854b826ed2.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../boostrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../boostrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/Chat.css">

    <link rel="shortcut icon" href="../multmedia/logo.png" />
    <title>Chat - Jaiko</title>
</head>

<body>

    <?php echo $menu ?>

    <div id="ventana-modal" class="modal">

    </div>

    <div class="box-container" id="box-container">
        <h1>Mensajes Privados</h1>

        <div class="enviado">
            <h2>Enviar Mensaje</h2>
            <form id="enviarMensajeForm">
                <!--<label for="idEnviado">ID de remitente:</label>-->
                <input type="hidden" id="idEnviado" name="idEnviado"><br>

                <label for="idRecibido">Seleccione un usuario:</label>
                <select name="listausuarios" id="listausuarios"></select>
                <input type="hidden" id="idRecibido" name="idRecibido" disabled><br>

                <label for="mensaje">Mensaje:</label><br>
                <textarea id="mensaje" name="mensaje"></textarea><br>

                <button type="submit">Enviar</button>
            </form>
        </div>
    </div>

    <div class="box-container">
        <div class="recibidos">
            <h2>Mensajes Recibidos</h2>
            <div id="mensajesContainer"></div>
        </div>
    </div>

    <div class="box-footer">
        <a href="">Enseña en Jako</a>
        <a href="">¿Qui&eacute;nes somos?</a>
        <a href="">Inscribite a nuestros cursos</a>
        <a href="">Trabaja con nosotros</a>
    </div>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/Chat.js"></script>

</body>

</html>