<!DOCTYPE html>
<html lang="es-ES">
<?php session_start();
include_once '../php/VerificarSesion.php';
include_once '../php/CursosMaestro.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/854b826ed2.js" crossorigin="anonymous"></script>
    <script type="text/javascript" src="../boostrap/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="../boostrap/css/bootstrap.min.css">

    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/Dashboard.css">

    <link rel="shortcut icon" href="../multmedia/logo.png" />

    <title>Dashboard | Jaiko</title>
</head>

<body>

    <?php echo $menu; ?>

    <div id="ventana-alertas" class="modal">

    </div>

    <div class="box-container" id="box-container">

        <?php
        $items = Paginar(3);
        if ($items != '') {
            echo $items;
        } else { ?>
        <div class="sincursos">
            <img src="../multmedia/sincursos.jpg" alt="">
            <h2>Aún no has ingresado cursos.</h2>
        </div>
        <?php } ?>

        <div class="crearcurso">
            <button id="addcourse">Crear Curso</button>
        </div>
    </div>

    <div class="box-footer">
        <a href="">Enseña en Jako</a>
        <a href="">¿Qui&eacute;nes somos?</a>
        <a href="">Inscribite a nuestros cursos</a>
        <a href="">Trabaja con nosotros</a>
    </div>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/Dashboard.js"></script>

</body>

</html>