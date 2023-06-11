<?php

include_once "Api.php";
$lista = '';

try {
    $api = new ApiCliente();    

    $lista = $api->ListaUsuarios();

    echo json_encode($lista);

} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}


?>