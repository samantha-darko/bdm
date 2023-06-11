<!DOCTYPE html>
<html lang="es">
<?php session_start();
include_once '../php/VerificarSesion.php';
include_once '../php/CursoInscritoAlumno.php';
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/854b826ed2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../boostrap/css/bootstrap.min.css">
    <script type="text/javascript" src="../boostrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/MisCursos.css">

    <link rel="shortcut icon" href="../multmedia/logo.png" />

    <title>Mis Cursos | Alumno</title>
</head>

<body>
    <?php echo $menu ?>

    <div id="ventana-modal" class="modal"></div>

    <div id="confirmacion" class="modal">
        <div class="modal-contenido">
            <h2>Finalizar Curso</h2>
            <p>¿Estás seguro de que deseas marcar el curso como finalizado?</p>
            <div class="botones">
                <button id="btn-confirmar">Confirmar</button>
                <button id="btn-cancelar">Cancelar</button>
            </div>
        </div>
    </div>


    <div class="box-container" id="box-container">

        <?php echo $items; ?>
    </div>

    <div class="box-footer">
        <a href="">Enseña en Jako</a>
        <a href="">¿Qui&eacute;nes somos?</a>
        <a href="">Inscribite a nuestros cursos</a>
        <a href="">Trabaja con nosotros</a>
    </div>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/MisCursos.js"></script>
</body>

</html>