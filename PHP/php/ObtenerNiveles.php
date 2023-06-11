<?php
include_once 'Api.php';


function Curso(){
    $itemcurso = '';
    $curso = $_GET["curso"];
    $apicurso = new ApiCurso();
    $infocurso = $apicurso->Ver($curso);
    $itemcurso .= '<div class="infocurso">';
    $itemcurso .= '<h2>Curso: '. $infocurso['titulo'] .'</h2>';
    $itemcurso .= '</div>';
    return $itemcurso;
}

function Paginar()
{
    $items = '';
    $api = new ApiNivel();
    $curso = $_GET["curso"];
    $niveles = $api->TotalNiveles($curso);
    $datoscurso = $api->CostoCurso($curso);
    $tipo = floatval($datoscurso[0]);
    if ($tipo < 1) {
        echo '<script>document.querySelector("#costonivel").style.display = "block"</script>';
    } else {
        echo '<script>document.querySelector("#costonivel").style.display = "none"</script>';
    }
    $archivos = '';

    if (!empty($niveles)) {
        if (!isset($_GET['pag']))
            $_GET['pag'] = 1;
        $pag = (int) $_GET['pag'];
        if ($pag < 1) {
            $pag = 1;
        }
        $offset = ($pag - 1) * 1;

        $total = count($niveles);
        $stmt = $api->ListadoNiveles($curso, $offset, 1);
        $items .= '<div class="niveles">';
        while ($dato = $stmt->fetch((PDO::FETCH_ASSOC))) {
            $items .= '<div class="division">';
            $items .= '<label>Título Nivel</label>';
            $items .= '<h2>' . $dato['titulo'] . '</h2>';
            $items .= '</div>';
            $items .= '<div class="division">';
            $items .= '<label>Precio curso</label>';
            $items .= '<h3>' . $dato['costo'] . '</h3>';
            $items .= '</div>';
            
            $db = new DB();
            $conn = $db->connect();
            $stmt = $conn->prepare("call sp_vista(:id_nivel,'vista_recursos')");
            $stmt->bindParam(':id_nivel', $dato['id_nivel']);
            $stmt->execute();
            $archivos = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $items .= '<div class="recursos">';
            foreach ($archivos as $archivo) {
                $nombre = $archivo['nombre'];
                $tipo = $archivo['tipo'];
                $contenido = $archivo['contenido'];

                // Generar el código HTML para mostrar el contenido multimedia
                $items .= '<div class="contenido">';
                $items .= '<p>Archivo: ' . $nombre . '</p>';
                $items .= '<p>Archivo: <a href="data:' . $tipo . ';base64,' . base64_encode($contenido) . '" download="' . $nombre . '">Descargar</a></p>';
                $items .= '<div class="archivo">';
                if (strpos($tipo, 'image') === 0) {
                    // Si es una imagen, mostrarla
                    $items .= '<img src="data:' . $tipo . ';base64,' . base64_encode($contenido) . '">';
                } elseif (strpos($tipo, 'video') === 0) {
                    // Si es un video, mostrarlo
                    $items .= '<video controls>';
                    $items .= '<source src="data:' . $tipo . ';base64,' . base64_encode($contenido) . '" type="' . $tipo . '">';
                    $items .= 'Tu navegador no admite la reproducción de video.';
                    $items .= '</video>';
                }
                $items .= '</div></div>';
            }

            $items .= '</div>';
            $items .= '<button id="btnEliminar" onclick="eliminar(' . $dato['id_nivel'] . ')">Eliminar</button>';
        }
        $totalPag = ceil($total / 1);
        $items .= '<div class="paginacion">';
        for ($i = 1; $i <= $totalPag; $i++) {
            $items .= "<a href=\"?curso=$curso&pag=$i\"><i class='fa fa-duotone fa-circle'></i></a>";
        }
        $items .= '</div></div>';
    }
    return $items;
}