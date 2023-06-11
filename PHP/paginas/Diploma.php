<!DOCTYPE html>
<html lang="es">
<?php session_start();
include_once '../php/VerificarSesion.php';
?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/854b826ed2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../boostrap/css/bootstrap.min.css">
    <script type="text/javascript" src="../boostrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/Diploma.css">

    <link rel="shortcut icon" href="../multmedia/logo.png" />

    <title>Kardex | Alumno</title>
</head>

<body>
    <?php echo $menu ?>

    <div id="ventana-modal" class="modal"></div>
    <div class="box-container" id="box-container">

        <div>
            <div class="header">
                <div>
                    <img id="medallon" src="../multmedia/medallon.png">
                </div>
                <div>
                    <h1>Diploma</h1>
                    <p>otorgado a:</p>
                </div>
                <div>
                    <img id="logo" src="../multmedia/logo.png">
                </div>
            </div>

            <div class="info">
                <h2 id="alumno"></h2>
            </div>
            <div class="info">
                <p>Por haber concluido satisfactoriamente el curso de:</p>
                <h2 id="curso"></h2>
            </div>
        </div>

        <div class="info">
            <label>Fecha de Terminación</label>
            <h2 id="fechatermino"></h2>
        </div>

        <div class="info">
            <label>Nombre del Certificador</label>
            <h2 id="maestro"></h2>
        </div>
    </div>

    <div class="box-footer">
        <a href="">Enseña en Jako</a>
        <a href="">¿Qui&eacute;nes somos?</a>
        <a href="">Inscribite a nuestros cursos</a>
        <a href="">Trabaja con nosotros</a>
    </div>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/Diploma.js"></script>
</body>

</html>