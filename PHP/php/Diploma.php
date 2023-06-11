<?php

include_once "Api.php";
include_once "Clases.php";

try {
    $api = new ApiAlumno();

    $idcursoinscrito = $_GET["Diploma"];
    $diploma = $api->Diploma($idcursoinscrito);
    echo json_encode($diploma);

} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}