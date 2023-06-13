<?php

include_once "Api.php";

try {
    $api = new ApiAdministrador();
    $correo = $_GET["correo"];
    $msj = $api->Desbloquear($correo);
    echo json_encode($msj);
} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}

?>