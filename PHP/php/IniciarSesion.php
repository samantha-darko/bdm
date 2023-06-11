<?php

include_once "Api.php";
include_once "Clases.php";

try {
    session_start();
    $msj;
    $api = new ApiCliente();
    
    $correo = $_POST["correo"];
    $contra = $_POST["contra"];
    
    $datos = $api->IniciarSesion($correo, $contra);
    if (is_array ($datos)) {
        $msj = array("valido",$datos['rol'],$datos['id_usuario']);
        
        $_SESSION['acceso'] = true;
        $_SESSION['sessCustomerID'] = $datos['id_usuario'];

        $_SESSION['id_usuario'] = $datos['id_usuario'];
        $_SESSION['email'] = $datos['email'];
        $_SESSION['contra'] = $datos['contra'];
        $_SESSION['rol'] = $datos['rol'];
        $_SESSION['imagen'] = $datos['imagen'];
        $_SESSION['nombre'] = $datos['nombre'];
        $_SESSION['apellido_p'] = $datos['apellido_p'];
        $_SESSION['apellido_m'] = $datos['apellido_m'];
        $_SESSION['fch_nacimiento'] = $datos['fch_nacimiento'];
        $_SESSION['genero'] = $datos['genero'];
        $_SESSION['errores'] = $datos['errores'];
        $_SESSION['baja_logica'] = $datos['baja_logica'];
        $_SESSION['fch_ingreso'] = $datos['fch_ingreso'];

    }else if(is_string($datos)){
        $msj = array($datos);
        if (isset($_SESSION['acceso'])) {
            unset($_SESSION['acceso']);
        }
        if (isset($_SESSION['sessCustomerID'])) {
            unset($_SESSION['sessCustomerID']);
        }
        if (isset($_SESSION['id_usuario'])) {
            unset($_SESSION['id_usuario']);
        }
        if (isset($_SESSION['email'])) {
            unset($_SESSION['email']);
        }
        if (isset($_SESSION['contra'])) {
            unset($_SESSION['contra']);
        }
        if (isset($_SESSION['rol'])) {
            unset($_SESSION['rol']);
        }
        if (isset($_SESSION['imagen'])) {
            unset($_SESSION['imagen']);
        }
        if (isset($_SESSION['nombre'])) {
            unset($_SESSION['nombre']);
        }
        if (isset($_SESSION['apellido_p'])) {
            unset($_SESSION['apellido_p']);
        }
        if (isset($_SESSION['apellido_m'])) {
            unset($_SESSION['apellido_m']);
        }
        if (isset($_SESSION['fch_nacimiento'])) {
            unset($_SESSION['fch_nacimiento']);
        }
        if (isset($_SESSION['genero'])) {
            unset($_SESSION['genero']);
        }
        if (isset($_SESSION['errores'])) {
            unset($_SESSION['errores']);
        }
        if (isset($_SESSION['baja_logica'])) {
            unset($_SESSION['baja_logica']);
        }
        if (isset($_SESSION['fch_ingreso'])) {
            unset($_SESSION['fch_ingreso']);
        }
    }    

    echo json_encode($msj);

} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}

?>