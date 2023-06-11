<!DOCTYPE html>
<html lang="es-ES">
<?php session_start();
include_once '../php/VerificarSesion.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/854b826ed2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../boostrap/css/bootstrap.min.css">
    <script type="text/javascript" src="../boostrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/IniciarSesion.css">

    <link rel="shortcut icon" href="../multmedia/logo.png" />
    <title>Bienvenida/o - Iniciar Sesi&oacute;n</title>
</head>

<body>

    <?php echo $menu ?>

    <div id="ventana-modal" class="modal">

    </div>

    <div class="box-container" id="box-container">

        <form id="formlogin" method="post">
            <div>
                <h2>Bienvenida/o de vuelta</h2>
            </div>
            <div><input type="email" id="correo" name="correo" type="text" placeholder="Tu correo" tabindex="1">
                <p id="vaciocorreo">Campo vac&iacute;o.</p>
                <div class="ingresar">
                    <input type="password" id="contra" name="contra" type="text" placeholder="Tu contrase&ntilde;a"
                        tabindex="2">
                    <button type="button" id="mostrar"><i class="fa-sharp fa-solid fa-eye"></i></button>
                    <button type="button" id="ocultar"><i class="fa-sharp fa-solid fa-eye-slash"></i></button>
                </div>
            </div>
            <p id="errorcorreo">Debe ingresar un correo valido.</p>

            <p id="vaciocontra">Campo vac&iacute;o.</p>
            <p id="errorcontra">Debe ingresar una contrase&ntilde;a valido.</p>
            <div><button type="submit" id="login" tabindex="2">Iniciar Sesi&oacute;n</button></div>
        </form>

        <div class="crear">
            <p>¿A&uacute;n no tienes cuenta en Jaiko?</p>
            <a href=""></a>
            <button id="crear" onclick="location.href='CrearCuenta.php';">Crear cuenta</button>
        </div>

    </div>

    <div class="box-footer">
        <a href="">Enseña en Jako</a>
        <a href="">¿Qui&eacute;nes somos?</a>
        <a href="">Inscribite a nuestros cursos</a>
        <a href="">Trabaja con nosotros</a>
    </div>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/IniciarSesion.js"></script>

</body>

</html>