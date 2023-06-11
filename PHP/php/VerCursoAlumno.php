<?php
include_once 'Api.php';
$items = "";
try {
    $api = new ApiAlumno();

    $curso = $_GET["curso"];

    $ListaCursoInscrito = $api->VerCurso($curso);
    
    $idcurso = $ListaCursoInscrito['id_curso'];
    $items .= '<div id="' . $idcurso . '" class="cursoinscrito">';
    $items .= '<div class="infocurso">';
    $items .= '<img src="data:png;base64,' . base64_encode($ListaCursoInscrito['imagen_curso']) . '"/>';
    $items .= '<h2>' . $ListaCursoInscrito['titulo_curso'] . '</h2>';
    $items .= '<h4>' . $ListaCursoInscrito['descripcion_curso'] . '</h4>';
    $items .= '</div>';
    $items .= '<div class="nivel">';
    $ListaRecursos = $api->RecursosdelCurso($idcurso);
    for ($j = 0; $j < count($ListaRecursos); $j++) {
        $items .= '<div class="infonivel">';
        $items .= '<p>Contenido: ' . $ListaRecursos[$j]['recurso'] . '</p>';
        $items .= '<p>Archivo: <a href="data:' . $ListaRecursos[$j]['tipo'] . ';base64,' . base64_encode($ListaRecursos[$j]['contenido']) . '" download="' . $ListaRecursos[$j]['recurso'] . '">Descargar</a></p>';
        if (strpos($ListaRecursos[$j]['tipo'], 'video') === 0) {
            // Si es un video, mostrarlo
            $items .= '<video controls>';
            $items .= '<source src="data:' . $ListaRecursos[$j]['tipo'] . ';base64,' . base64_encode($ListaRecursos[$j]['contenido']) . '" type="' . $ListaRecursos[$j]['tipo'] . '">';
            $items .= 'Tu navegador no admite la reproducción de video.';
            $items .= '</video>';
        }
        $items .= '</div>';
    }
    $items .= '</div>';
    $items .= '</div>';

} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}
