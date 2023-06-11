<!DOCTYPE html>
<html lang="es">
<?php session_start();
include_once '../php/VerificarSesion.php'; ?>

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/854b826ed2.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../boostrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../boostrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/MiPerfil.css">

    <link rel="shortcut icon" href="../multmedia/logo.png" />
    <title>Mi Perfil | Jaiko</title>
</head>

<body onload="VerificarSesion();">

    <?php echo $menu ?>

    <div id="ventana-alertas" class="modal"></div>

    <div class="box-container" id="box-container">
        <div class="ver">

            <div class="encabezado">
                <h1>Mi Perfil</h1>
            </div>
            <div class="datos">
                <div class="group">
                    <?php echo '<div><img class="foto" id="foto" name="foto" src="data:png;base64,' . base64_encode($datos->imagen) . '"/></div>'; ?>
                </div>
                <div class="group">
                    <label>Correo:</label>
                    <?php echo '<p>' . $datos->email . '</p>'; ?>

                    <label>Nombre:</label>
                    <?php echo '<p>' . $datos->nombre . ' ' . $datos->apellido_p . ' ' . $datos->apellido_m . '</p>'; ?>

                    <label>Fecha de Nacimiento:</label>
                    <?php echo '<p>' . $datos->fch_nacimiento . '</p>'; ?>

                    <label>Rol:</label>
                    <?php echo '<p>' . $datos->rol . '</p>'; ?>

                    <label>G&eacute;nero:</label>
                    <?php echo '<p>' . $datos->genero . '</p>'; ?>

                    <label>Fecha de Ingreso:</label>
                    <?php echo '<p>' . $datos->fch_ingreso . '</p>'; ?>
                </div>
            </div>
            <div class="datos">
                <button id="editar" onclick="location.href = '../paginas/EditarPerfil.php';">Editar Perfil</button>
                <button id="cerrar" onclick="salir()">Cerrar Sesi&oacute;n</button>
            </div>

        </div>
    </div>
    <div class="box-footer">
        <a href="">Enseña en Jako</a>
        <a href="">¿Qui&eacute;nes somos?</a>
        <a href="">Inscribite a nuestros cursos</a>
        <a href="">Trabaja con nosotros</a>
    </div>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/MiPerfil.js"></script>

</body>

</html>