<?php

include_once "Api.php";
$items = "";

try {
    //session_start();
    $api = new ApiAlumno();

    $iduser = $_SESSION["id_usuario"];

    $ListaCursoInscrito = $api->ListaCursoInscrito($iduser);

    if (count($ListaCursoInscrito) > 0) {
        for ($i = 0; $i < count($ListaCursoInscrito); $i++) {
            $idcurso = $ListaCursoInscrito[$i]['idcurso'];
            $items .= '<div id="' . $ListaCursoInscrito[$i]['idcursoinscrito'] . '" class="cursoinscrito">';
            $items .= '<div class="infocurso">';
            $items .= '<img src="data:png;base64,' . base64_encode($ListaCursoInscrito[$i]['imagen_curso']) . '"/>';
            $items .= '<h2>' . $ListaCursoInscrito[$i]['titulo_curso'] . '</h2>';
            $items .= '<h4>' . $ListaCursoInscrito[$i]['descripcion_curso'] . '</h4>';
            $items .= '<label>Fecha de Inscripcion: ' . $ListaCursoInscrito[$i]['fecha_inscripcion'] . '</label>';
            $items .= '</div>';
            $items .= '<div class="nivel">';
            $ListaRecursos = $api->RecursosdelCurso($idcurso);
            for ($j = 0; $j < count($ListaRecursos); $j++) {
                $items .= '<div class="infonivel">';
                $items .= '<p>Contenido: ' . $ListaRecursos[$j]['recurso_nombre'] . '</p>';
                $items .= '<p>Archivo: <a href="data:' . $ListaRecursos[$j]['recurso_tipo'] . ';base64,' . base64_encode($ListaRecursos[$j]['contenido']) . '" download="' . $ListaRecursos[$j]['recurso_nombre'] . '">Descargar</a></p>';
                $items .= '</div>';
            }
            $items .= '</div>';
            if ($ListaCursoInscrito[$i]['finalizado'] === 0) {
                $items .= '<button onclick="finalizar(' . $ListaCursoInscrito[$i]['idcursoinscrito'] . ')" id=' . $ListaCursoInscrito[$i]['fecha_inscripcion'] . '>Finalizar Curso</button>';
            } else {
                $items .= '<p>Este curso ya esta finalizado</p>';
            }
            $items .= '</div>';
        }
    }else{
        $items .= '<div class="sincursos">';
        $items .= '<img src="../multmedia/sincursos.jpg" alt="">';
        $items .= '<h2>Aún no te has inscrito a ningún curso</h2>';
        $items .= '</div>';
    }


} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}

?>