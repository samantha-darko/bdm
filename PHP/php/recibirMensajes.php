<?php
include_once("conexion.php");
$db = new DB();
$conn = $db->connect();
if (is_array($conn)) {
    $msj = $conn['error'];
    return $msj;
}
$idUsuario = $_GET["idUsuario"];;

try {
    // Preparar la consulta
    $stmt = $conn->prepare("SELECT * FROM mensajes 
    JOIN usuario 
    ON mensajes.id_enviado_f = usuario.id_usuario
    WHERE id_recivido_f = ?;");
    // Asignar el valor del parámetro
    $stmt->bindParam(1, $idUsuario);
    // Ejecutar la consulta
    $stmt->execute();
    // Obtener todos los mensajes como un array asociativo
    $mensajes = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Mostrar los mensajes recibidos
    foreach ($mensajes as $mensaje) {
        echo "De: " . $mensaje['nombre'] . " " . $mensaje['apellido_p'] . "<br>";
        echo "Mensaje: " . $mensaje['mensaje'] . "<br>";
        echo "Fecha de envío: " . $mensaje['fecha_envio'] . "<br><br>";
    }
} catch (PDOException $e) {
    // Manejo de errores de la consulta
    echo "Error al recibir los mensajes: " . $e->getMessage();
    die();
}
