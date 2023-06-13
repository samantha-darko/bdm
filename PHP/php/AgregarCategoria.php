<?php

include_once "Api.php";
include_once "Clases.php";

try {
    session_start();
    $api = new ApiCategoria();

    $id_usuario_f = $_SESSION['id_usuario'];
    $titulo = $_POST["titulo"];
    $descripcion = $_POST["descripcion"];

    $datos = new Categoria(0, $id_usuario_f, $titulo, $descripcion, 0, 0);
    $msj = $api->Agregar($datos);
    echo json_encode($msj);
} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}
?>