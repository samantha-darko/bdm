<?php
include_once 'Api.php';

function Paginar($cantidad)
{

    $api = new ApiCurso();
    $usuario = $_SESSION["id_usuario"];
    $cursos = $api->TodosCursosMaestro($usuario);
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
        $stmt = $api->ListadoMaestro($usuario, $offset, $cantidad);
        $items = '<div class="cursos">';
        while ($dato = $stmt->fetch((PDO::FETCH_ASSOC))) {
            $items .= '<div class="infocurso">';
            $items .= '<img src="data:png;base64,' . base64_encode($dato['imagen']) . '"/>';
            $items .= '<h2>' . $dato['titulo'] . '</h2>';
            $items .= '<label>' . $dato['descripcion'] . '</label>';
            if ($dato['activo'] === 1)
                $items .= '<button onclick="editar(' . $dato['id_curso'] . ')">Ver más</button>';
            else{
                $items .= '<label>Este curso solo se puede visualizar, no se puede editar porque ya se elimino.</label>';
                $items .= '<button onclick="ver(' . $dato['id_curso'] . ')">Ver más</button>';
            }
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
