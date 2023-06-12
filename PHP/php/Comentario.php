<?php

try {
    include_once "Api.php";
    $api = new ApiComentario();
    $msj = '';
    session_start();
    $rating = $_POST['rating'];
    $opcion = $_POST['opcion'];
    $usuario = $_POST['usuario'];
    $curso = $_POST['curso'];

    if ($opcion === 'calificacion') {
        $msj = $api->Calificacion($rating, $usuario, $curso);
    }

    echo json_encode(($msj));

} catch (Throwable $th) {
    echo json_encode($th);
}
?>