<?php

include_once "Api.php";
include_once "Clases.php";

try {
    session_start();
    $api = new ApiCategoria();
    $opcion = $_POST['opcion'];
    
    if($opcion === 'eliminar'){
        $id = $_POST['idcurso'];
        $msj = $api->Eliminar($id);
    }
    echo json_encode($msj);
} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}
