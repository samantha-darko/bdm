<?php

include_once "Api.php";
include_once "Clases.php";

try {
    session_start();
    $api = new ApiCliente();

    $email = $_SESSION["email"];
    $contra;
    if (isset($_POST['contra'])) {
        $contra = $_POST["contra"];
    }else{
        $contra = '';
    }
    $rol;
    if (isset($_POST['rol'])) {
        $rol = $_POST["rol"];
    }else{
        $rol = '';
    }
    
    $imagen;
    if (isset($_FILES['image'])) {
        $imagen = fopen($_FILES['image']['tmp_name'], 'rb');
    } else {
        $imagen = '';
    }
    $nombre;
    if (isset($_POST['nombre'])) {
        $nombre = $_POST["nombre"];
    }else{
        $nombre = '';
    }
    $apellido_p;
    if (isset($_POST['apellidop'])) {
        $apellido_p = $_POST["apellidop"];
    }else{
        $apellido_p = '';
    }
    $apellido_m;
    if (isset($_POST['apellidom'])) {
        $apellido_m = $_POST["apellidom"];
    }else{
        $apellido_m = '';
    }
    $fch_nacimiento;
    if (isset($_POST['fechanac'])) {
        $fch_nacimiento = $_POST["fechanac"];
    }else{
        $fch_nacimiento = '';
    }
    $genero = $_POST["genero"];
    if (isset($_POST['genero'])) {
        $genero = $_POST["genero"];
    }else{
        $genero = '';
    }

    $datos = new Usuario(0, $email, $contra, $rol, $imagen, $nombre, $apellido_p, $apellido_m, $fch_nacimiento, $genero, 0, 0, 0);
    $msj = $api->Editar($datos);
    if ($msj) {
        $datos = $api->IniciarSesion($datos->email,$datos->contra);
        if (!empty($datos['contra']))
            $_SESSION['contra'] = $datos['contra'];
        if (!empty($datos['imagen']))
            $_SESSION['imagen'] = $datos['imagen'];
        if (!empty($datos['nombre']))
            $_SESSION['nombre'] = $datos['nombre'];
        if (!empty($datos['apellido_p']))
            $_SESSION['apellido_p'] = $datos['apellido_p'];
        if (!empty($datos['apellido_m']))
            $_SESSION['apellido_m'] = $datos['apellido_m'];
        if (!empty($datos['fch_nacimiento']))
            $_SESSION['fch_nacimiento'] = $datos['fch_nacimiento'];
        if (!empty($datos['genero']))
            $_SESSION['genero'] = $datos['genero'];
    }
    echo json_encode($msj);

} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}
