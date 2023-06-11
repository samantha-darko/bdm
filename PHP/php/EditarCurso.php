<?php

include_once "Api.php";
include_once "Clases.php";

try {
    session_start();
    $api = new ApiCurso();

    $iduser = $_SESSION['id_usuario'];
    $idcurso = $_POST['idcurso'];

    $titulo;
    if (isset($_POST['titulo'])) {
        $titulo = $_POST["titulo"];
    } else {
        $titulo = '';
    }

    $descripcion;
    if (isset($_POST['descripcion'])) {
        $descripcion = $_POST["descripcion"];
    } else {
        $descripcion = '';
    }

    $image;
    if (isset($_FILES['image'])) {
        $image = fopen($_FILES['image']['tmp_name'], 'rb');
    } else {
        $image = '';
    }

    $costocurso;
    if (isset($_POST['costocurso'])) {
        $costocurso = $_POST["costocurso"];
    } else {
        $costocurso = '';
    }

    $datos = new Curso($idcurso, $iduser, $titulo, $descripcion, 1, $image, $costocurso);
    $msj = $api->Editar($datos);

    echo json_encode($msj);
} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}
