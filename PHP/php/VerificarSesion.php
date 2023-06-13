<?php
include_once 'Clases.php';
$loggeado = false;
$menu = '';
if (isset($_SESSION['acceso'])) {
    if ($_SESSION['acceso']) {
        $loggeado = true;
        $datos = new Usuario(
            $_SESSION['id_usuario'], $_SESSION['email'],
            $_SESSION['contra'], $_SESSION['rol'], $_SESSION['imagen'],
            $_SESSION['nombre'], $_SESSION['apellido_p'], $_SESSION['apellido_m'],
            $_SESSION['fch_nacimiento'], $_SESSION['genero'], $_SESSION['errores'], 
            $_SESSION['baja_logica'], $_SESSION['fch_ingreso']);
        if($datos->rol === "alumno"){
            $menu = '<div class="box-menu"><nav id="menu-left"><ul><li><a href="PaginaPrincipal.php"><img src="../multmedia/logo.png" tittle="Jaiko">Jaiko</a></nav>';            
            $menu .= '<nav id="menu-right"><ul>';
            $menu .= '<li><a href="PaginaPrincipal.php"><img src="data:png;base64,' . base64_encode($datos->imagen) . '"/>';
            $menu .= '<label>' . $datos->nombre . '</label></a>';
            $menu .= '<ul><li><a href="Chat.php"><i class="fa-sharp fa-regular fa-comments"></i> Chat</a></li>';
            $menu .= '<li><a href="Kardex.php"><i class="fa-sharp fa-solid fa-list-ul" style="color: #ffffff;"></i> Kardex</a></li>';
            $menu .= '<li><a href="MiPerfil.php"><i class="fa fa-duotone fa-eye"></i> Mi Perfil</a></li>';
            $menu .= '<li><a href="MisCursos.php"><i class="fa-solid fa-circle-plus"></i> Mis Cursos</a></li>';
            $menu .= '<li><a href="" id="salir">';
            $menu .= '<i class="fa fa-sharp fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a></li>';
            $menu .= '</ul></li></ul></nav>';
            $menu .= '<div class="buscador"><input type="search" name="buscador" id="nav-search" placeholder="Buscador...">';
            $menu .= '<button id="btn-search"><i class="fa fa-solid fa-magnifying-glass"></i></button></div></div>';
        }

        if($datos->rol === "maestro"){
            $menu = '<div class="box-menu"><nav id="menu-left"><ul><li><a href="Dashboard.php"><img src="../multmedia/logo.png" tittle="Jaiko"> Jaiko</a></nav>';
            $menu .= '<nav id="menu-right"><ul><li><a href="Dashboard.php"><img src="data:png;base64,' . base64_encode($datos->imagen) . '"/>';
            $menu .= '<label>' . $datos->nombre . '</label></a>';
            $menu .= '<ul><li><a href="Chat.php"><i class="fa-sharp fa-regular fa-comments"></i> Chat</a></li>';
            $menu .= '<li><a href="MiPerfil.php"><i class="fa fa-duotone fa-eye"></i> Mi Perfil</a></li>';
            $menu .= '<li><a href="Dashboard.php"><i class="fa-solid fa-circle-plus"></i> Mis Cursos</a></li>';
            $menu .= '<li><a href="CursosVendidos.php"><i class="fa-sharp fa-solid fa-list-ul" style="color: #ffffff;"></i> Cursos Vendidos</a></li>';
            $menu .= '<li><a href="" id="salir">';
            $menu .= '<i class="fa fa-sharp fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a></li>';
            $menu .= '</ul></li></ul></nav></div>';
        }

        if($datos->rol === "admin"){
            $menu = '<div class="box-menu"><nav id="menu-left"><ul><li><a href="Administrador.php"><img src="../multmedia/logo.png" tittle="Jaiko"> Jaiko</a></nav>';
            $menu .= '<nav id="menu-right"><ul><li><a href="Administrador.php">';
            $menu .= '<label>' . $datos->nombre . '</label></a><ul>';
            $menu .= '<li><a href="" id="salir">';
            $menu .= '<i class="fa fa-sharp fa-solid fa-arrow-right-from-bracket"></i> Cerrar Sesión</a></li>';
            $menu .= '</ul></li></ul></nav></div>';
        }
    }
}else{
    $menu = '<div class="box-menu"><nav id="menu-left"><ul>';
    $menu .= '<li><a href="IniciarSesion.php"><img src="../multmedia/logo.png" tittle="Jaiko"> Jaiko</a>';
    //$menu .= '<ul><li><a href="construccion.php"><i class="fa fa-solid fa-circle-info"></i></i> Contactanos</a>';
    //$menu .= '</li><li><a href="construccion.php"><i class="fa fa-solid fa-map-location-dot"></i></i> Ver Ubicación</a></li>';
    //$menu .= '<li><a href="construccion.php"><i class="fa fa-solid fa-address-card"></i></i> Acerca de Nosotros</a></li></ul>';
    $menu .= '</li></ul></nav>';
    $menu .= '<nav id="menu-right"><ul>';
    $menu .= '<li id="selected"><a href="IniciarSesion.php"><i class="fa-solid fa-arrow-right-to-bracket"';
    $menu .= 'tittle="Iniciar Sesión"></i></a></li></ul></nav></div>';
}
?>