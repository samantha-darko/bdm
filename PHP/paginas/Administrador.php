<!DOCTYPE html>
<html lang="es-ES">
<?php session_start();
include_once "../php/VerificarSesion.php";
include_once "../php/Categorias.php";
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/854b826ed2.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../boostrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../boostrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/Administrador.css">

    <link rel="shortcut icon" href="../multmedia/logo.png" />
    <title>Administrador - Jaiko</title>
</head>

<body>

    <?php echo $menu ?>

    <div id="ventana-modal" class="modal"></div>

    <div class="box-container" id="box-container">
        <div class="categoria">
            <form id="crear" name="crear" method="post">
                <h2>Crear Categoria</h2>
                <div>
                    <label>Nombre: </label>
                    <input id="titulo" name="titulo" type="text" onkeypress="return Letters(event);">
                </div>
                <div>
                    <label>Descripcion: </label>
                    <input id="descripcion" name="descripcion" type="text" onkeypress="return Letters(event);">
                </div>

                <button type="submit">Agregar Categoria</button>
            </form>

            <?php
            $items = Paginar(3);
            if ($items != '') {
                echo $items;
            } else { ?>
                <div class="sincursos">
                    <h2>Aún no has ingresado categorias.</h2>
                    <img src="../multmedia/sincursos.jpg" alt="">
                </div>
            <?php } ?>
        </div>
    </div>

    <div class="box-container">
        <div class="desbloquear">
            <h2>Desbloquear Usuario</h2>
            <form id="desbloquear">
                <label>Ingrese el correo del usuario: </label>
                <div>
                    <input id="correo" name="correo" type="text" tabindex="0">
                    <button id="buscar" type="submit" tabindex="1">Desbloquear</button>
                </div>
            </form>
        </div>
    </div>

    <div class="box-footer">
        <a href="">Enseña en Jako</a>
        <a href="">¿Qui&eacute;nes somos?</a>
        <a href="">Inscribite a nuestros cursos</a>
        <a href="">Trabaja con nosotros</a>
    </div>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/Administrador.js"></script>

</body>

</html>