<?php
include_once "Api.php";
$items = "";

try {
    $idcursoinscrito = $_SESSION['id_usuario'];
    $api = new ApiAlumno();
    $cursos = $api->Kardex($idcursoinscrito);
    $items .= '<div class="info">';
    $items .= '<h4>Nombre del Curso</h4>';
    $items .= '<h4>Fecha de Inscripción</h4>';
    $items .= '<h4>Fecha Finalizado</h4>';
    $items .= '<h4>Diploma</h4>';
    $items .= '</div>';
    for ($i = 0; $i < count($cursos); $i++) {
        $items .= '<div class="info">';
        $items .= '<label><a href="VerCursoAlumno.php?curso='. $cursos[$i]['id_curso'] .'">' . $cursos[$i]['titulo'] . '</a></label>';
        $items .= '<label>' . $cursos[$i]['fecha_inscripcion'] . '</label>';
        if ($cursos[$i]['finalizado'] === 1)
            $items .= '<label>' . $cursos[$i]['fecha_finalizado'] . '</label>';
        else
            $items .= '<label>Aún no has finalizado este curso.</label>';
        $items .= '<label><a href="Diploma.php?Diploma='. $idcursoinscrito .'">Ver Diploma</a></label>';
        $items .= '</div>';
    }
} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}
