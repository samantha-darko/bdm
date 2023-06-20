<?php
include_once "Api.php";
include_once "Clases.php";

session_start();

$status = $_POST["status"];
$total = $_POST["total"];
$idcurso = $_POST["idcurso"];
$usuario = $_POST["usuario"];
$tipo = $_POST["tipo"];

$forma = "paypal";

$db = new DB();
$conn = $db->connect();
$stmt = $conn->prepare('call sp_inscribir_curso(0, ?, ?, 0, 0,"I");');
$stmt->bindValue(1, $idcurso);
$stmt->bindValue(2, $usuario);
$stmt->execute();
if ($stmt->rowCount() > 0) {
    $row = $stmt->fetch();
    $idinsert = array($row['idcursoinscrito'], $row['codigo'], $row['mensaje']);
}
if ($tipo === "por nivel") {
    $db2 = new DB();
    $conn2 = $db2->connect();
    $stmt2 = $conn2->prepare("call sp_pagocurso(0,?,?,?,?,0,'I');");
    $stmt2->bindValue(1, $idinsert[0]);
    $stmt2->bindValue(2, $total);
    $stmt2->bindValue(3, $forma);
    $stmt2->bindValue(4, $total);
    $stmt2->execute();

} elseif ($tipo === "por curso") {

    $db2 = new DB();
    $conn2 = $db2->connect();
    $stmt2 = $conn2->prepare("call sp_pagocurso(0,?,?,?,?,0,'I');");
    $stmt2->bindValue(1, $idinsert[0]);
    $stmt2->bindValue(2, $total);
    $stmt2->bindValue(3, $forma);
    $stmt2->bindValue(4, $total);
    $stmt2->execute();

}

?>