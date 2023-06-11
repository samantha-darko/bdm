<?php

include_once "Api.php";
include_once "Clases.php";

try {
    session_start();
    $api = new ApiCliente();

    $email = $_POST["correo"];
    $contra = $_POST["contra"];
    $rol = $_POST["rol"];
    $imagen = fopen($_FILES['image']['tmp_name'], 'rb');
    $nombre = $_POST["nombre"];
    $apellido_p = $_POST["apellidop"];
    $apellido_m = $_POST["apellidom"];
    $fch_nacimiento = $_POST["fechanac"];
    $genero = $_POST["genero"];

    $tipoFoto = $_FILES['image']['type'];

    $datos = new Usuario(0, $email, $contra, $rol, $imagen, $nombre, $apellido_p, $apellido_m, $fch_nacimiento, $genero, 0, 0, 0);
    $msj = $api->Agregar($datos);
    echo json_encode($msj);

} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}

?>