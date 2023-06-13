<?php

include_once "Api.php";
include_once "Clases.php";

try {
    session_start();
    $api = new ApiCurso();

    $iduser = $_SESSION['id_usuario'];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];
    $costo = $_POST["costocurso"];
    $foto = fopen($_FILES['image']['tmp_name'], 'rb');
    $categorias = $_POST['categorias'];
    if ($costo == "")
        $costo = "0";

    $datos = new Curso(0, $iduser, $titulo, $descripcion, 0, $foto, $costo);
    $idcurso = $api->Agregar($datos);

    if ($idcurso[0] > 0) {
        $categoria = new ApiCategoriaCurso();
        for ($i = 0; $i < count($categorias); $i++) {
            $idcategoria = $categorias[$i];
            $categoria->Agregar($idcurso[0],$idcategoria);
        }
    }

    echo json_encode(true);
} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}
