<?php
include_once 'Api.php';

function Paginar($cantidad)
{

    $api = new ApiCurso();
    $cursos = $api->LosMasVistos();

    $items = '';
    if (!empty($cursos)) {
        if (!isset($_GET['pag']))
            $_GET['pag'] = 1;
        $pag = (int) $_GET['pag'];
        if ($pag < 1) {
            $pag = 1;
        }
        $offset = ($pag - 1) * 1;

        $total = count($cursos);

        $stmt = $api->ListaCursosRecientes($offset, $cantidad);        
        $items .= '<h1>Agregados Recientemente</h1>';
        $items .= '<div class="cursos">';
        while ($dato = $stmt->fetch((PDO::FETCH_ASSOC))) {
            $items .= '<div class="infocurso">';
            $items .= '<img src="data:png;base64,' . base64_encode($dato['imagen']) . '"/>';
            $items .= '<h2>' . $dato['titulo'] . '</h2>';
            $items .= '<label>' . $dato['descripcion'] . '</label>';
            $items .= '<button onclick="Agregar(' . $dato['id_curso'] . ')">Inscribirme</button>';
            $items .= '</div>';
        }
        $items .= '</div>';
        $totalPag = ceil($total / $cantidad);
        $items .= '<div class="paginacion">';
        for ($i = 1; $i <= $totalPag; $i++) {
            $items .= "<a href=\"?pag=$i\"><i class='fa fa-duotone fa-circle'></i></a>";
        }
        $items .= '</div>';
    }
    return $items;
}
?>