<?php

include_once "Api.php";

try {
    $api = new ApiComentario();

    $curso = $_GET["curso"];

    $msj = $api->Comentarios($curso);

    if (count($msj) === 0)
        $msj = 0;
    echo json_encode($msj);
} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}