<?php
include_once("conexion.php");
$db = new DB();
$conn = $db->connect();
if (is_array($conn)) {
    $msj = $conn['error'];
    return $msj;
}

$idEnviado = $_POST["idEnviado"];
$idRecibido = $_POST["idRecibido"];
$mensaje = $_POST["mensaje"];

try {
    // Preparar la consulta
    $stmt = $conn->prepare("INSERT INTO mensajes (id_enviado_f, id_recivido_f, mensaje) VALUES (?, ?, ?)");
    // Asignar los valores de los parámetros
    $stmt->bindParam(1, $idEnviado);
    $stmt->bindParam(2, $idRecibido);
    $stmt->bindParam(3, $mensaje);
    // Ejecutar la consulta
    $stmt->execute();
} catch (PDOException $e) {
    // Manejo de errores de la consulta
    echo "Error al enviar el mensaje: " . $e->getMessage();
    die();
}
