<?php

include_once "Api.php";
include_once "Clases.php";

try {
    session_start();
    $api = new ApiCurso();

    $idcurso = $_GET['curso'];

    $msj = $api->Eliminar($idcurso);

    echo json_encode($msj);
} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}
