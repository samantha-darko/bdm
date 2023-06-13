<?php
include_once 'Api.php';

function Paginar()
{

    $api = new ApiCategoria();
    $id = $_SESSION['id_usuario'];
    $categorias = $api->Total($id);

    $items = '';
    if (!empty($categorias)) {
        if (!isset($_GET['pag']))
            $_GET['pag'] = 1;
        $pag = (int) $_GET['pag'];
        if ($pag < 1) {
            $pag = 1;
        }
        $offset = ($pag - 1) * 1;

        $total = count($categorias);

        $stmt = $api->Listado($id, $offset, 1);
        $items .= '<div class="lista">';
        while ($dato = $stmt->fetch((PDO::FETCH_ASSOC))) {
            $items .= '<div class="info">';
            $items .= '<h2>' . $dato['titulo'] . '</h2>';
            $items .= '<label>' . $dato['descripcion'] . '</label>';            
            $items .= '<div class="botones">';
            $items .= '<button id="editar" onclick="editar(' . $dato['id_categoria'] . ')">Editar</button>';
            $items .= '<button id="eliminar" onclick="eliminar(' . $dato['id_categoria'] . ')">Eliminar</button>';
            $items .= '</div></div>';
        }
        $totalPag = ceil($total / 1);
        $items .= '<div class="paginacion">';
        for ($i = 1; $i <= $totalPag; $i++) {
            $items .= "<a href=\"?pag=$i\">". $i ."</a>";
        }//<i class='fa fa-duotone fa-circle'></i>
        $items .= '</div></div>';
    }
    return $items;
}
?>