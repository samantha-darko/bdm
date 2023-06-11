<?php
include_once "Api.php";
try {
    session_start();
    $idcursoinscrito = $_GET['id'];
    $api = new ApiAlumno();
    $msj = $api->FinalizarCurso($idcursoinscrito);
    
    echo json_encode($msj);
} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}
?>