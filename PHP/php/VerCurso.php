<?php

include_once "Api.php";
include_once "Clases.php";

try {
    $api = new ApiCurso();

    $curso = $_GET["curso"];

    $msj = $api->VerCurso($curso);
    if ($msj != null)
        echo json_encode($msj);
    else
        echo json_encode("vacio");
} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}