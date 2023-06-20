<?php

try {
    include_once "Api.php";
    $api = new ApiComentario();
    $msj = '';
    session_start();
    $usuario = $_POST['usuario'];
    $curso = $_POST['curso'];
    $comentario = $_POST['comentario'];
    $calificacion = $_POST['calificacion'];

    $msj = $api->Agregar($usuario, $curso, $comentario, $calificacion);

    echo json_encode(($msj));

} catch (Throwable $th) {
    echo json_encode($th);
}
?>