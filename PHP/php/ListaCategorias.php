<?php

include_once "Api.php";
$lista = '';

try {
    $api = new ApiCategoria();    

    $lista = $api->ListaCategorias();

    echo json_encode($lista);

} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}


?>