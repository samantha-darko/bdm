<?php
include_once 'Api.php';
$items = "";
try {
    $api = new ApiAlumno();

    $curso = $_GET["curso"];
    $ListaRecursos = $api->RecursosdelCurso($curso);
    $titulo = '';

    if (count($ListaRecursos) > 0) {
        $items .= '<div class="curso">';
        $items .= '<h1>Curso: ' . $ListaRecursos[0]['curso_titulo'] . '</h1>';
        $items .= '<img src="data:png;base64,' . base64_encode($ListaRecursos[0]['curso_imagen']) . '"/>';
        $items .= '</div>';
    }

    /*for ($i = 0; $i < count($ListaRecursos); $i++) {
        $items .= '<div class="nivel">';
        $items .= '<h2>' . $ListaRecursos[$i]['nivel_titulo'] . '</h2>';
        $items .= '<p>Contenido: ' . $ListaRecursos[$i]['recurso_nombre'] . '</p>';
        $items .= '<p>Archivo: <a href="data:' . $ListaRecursos[$i]['recurso_tipo'] . ';base64,' . base64_encode($ListaRecursos[$i]['contenido']) . '" download="' . $ListaRecursos[$i]['recurso_nombre'] . '">Descargar</a></p>';
        if (strpos($ListaRecursos[$i]['recurso_tipo'], 'video') === 0) {
            // Si es un video, mostrarlo
            $items .= '<video controls>';
            $items .= '<source src="data:' . $ListaRecursos[$i]['recurso_tipo'] . ';base64,' . base64_encode($ListaRecursos[$i]['contenido']) . '" type="' . $ListaRecursos[$i]['recurso_tipo'] . '">';
            $items .= 'Tu navegador no admite la reproducción de video.';
            $items .= '</video>';
        }
        $items .= '</div>';
    }*/

    $tituloMostrado = ''; // Variable para rastrear el último título mostrado

    for ($i = 0; $i < count($ListaRecursos); $i++) {
        $nivelTitulo = $ListaRecursos[$i]['nivel_titulo'];

        // Verificar si el título es diferente al último mostrado
        if ($nivelTitulo !== $tituloMostrado) {
            $items .= '<div class="nivel">';
            $items .= '<h2>' . $nivelTitulo . '</h2>';

            $tituloMostrado = $nivelTitulo; // Actualizar el último título mostrado
        }

        $items .= '<p>Contenido: ' . $ListaRecursos[$i]['recurso_nombre'] . '</p>';
        $items .= '<p>Archivo: <a href="data:' . $ListaRecursos[$i]['recurso_tipo'] . ';base64,' . base64_encode($ListaRecursos[$i]['contenido']) . '" download="' . $ListaRecursos[$i]['recurso_nombre'] . '">Descargar</a></p>';

        if (strpos($ListaRecursos[$i]['recurso_tipo'], 'video') === 0) {
            // Si es un video, mostrarlo
            $items .= '<video controls>';
            $items .= '<source src="data:' . $ListaRecursos[$i]['recurso_tipo'] . ';base64,' . base64_encode($ListaRecursos[$i]['contenido']) . '" type="' . $ListaRecursos[$i]['recurso_tipo'] . '">';
            $items .= 'Tu navegador no admite la reproducción de video.';
            $items .= '</video>';
        }

        // Cerrar el bloque del nivel si se ha mostrado un nuevo título
        if ($i + 1 === count($ListaRecursos) || $ListaRecursos[$i + 1]['nivel_titulo'] !== $nivelTitulo) {
            $items .= '<button onclick="finalizar('. $ListaRecursos[$i]['nivel_id'] .')">Finalizar Nivel</button>';
            $items .= '</div>';
        }
    }



} catch (PDOException $e) {
    $msj = "Error en servidor: " . $e->getMessage();
    echo json_encode($msj);
}