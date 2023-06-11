<!DOCTYPE html>
<html lang="es-ES">
<?php session_start();
include_once '../php/VerificarSesion.php'; ?>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://kit.fontawesome.com/854b826ed2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../boostrap/css/bootstrap.min.css">
    <script type="text/javascript" src="../boostrap/js/bootstrap.min.js"></script>

    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="../css/CrearCuenta.css">

    <link rel="shortcut icon" href="../multmedia/logo.png" />
    <title>Unirse a Jaiko</title>
</head>

<body>

    <?php echo $menu ?>

    <div id="ventana-modal" class="modal">

    </div>

    <div class="box-container" id="box-container">
        <h1>¡&Uacute;nete y haz crecer tu conocimiento!</h1>
        <form id="registro" method="post">

            <div class="bloque">
                <div class="block">
                    <label for="rol">Selecciona un rol:</label>
                    <select name="rol" id="rol" name="rol" tabindex="0">
                        <option value="alumno">Alumno</option>
                        <option value="maestro">Maestro</option>
                    </select>
                    <p id="vaciorol">* Debe seleccionar un rol.</p>
                </div>

                <div class="block">
                    <label for="correo">Ingresa tu correo:</label>
                    <input type="text" id="correo" name="correo" onkeypress="return Correo(event);" tabindex="1">
                    <p id="vaciocorreo">* Campo vac&iacute;o.</p>
                    <p id="errorcorreo">* Ingrese un correo v&aacute;lido.</p>
                </div>

                <div class="block">
                    <div>
                        <label for="contra">Ingresa tu contraseña:</label>
                        <div class="inputcontra">
                            <input type="password" id="contra" name="contra" onkeypress="return Contra(event);"
                                tabindex="2">
                            <button type="button" id="mostrar"><i class="fa-sharp fa-solid fa-eye"></i></button>
                            <button type="button" id="ocultar"><i class="fa-sharp fa-solid fa-eye-slash"></i></button>
                        </div>
                        <p id="vaciocontra">* Campo vac&iacute;o.</p>
                        <p id="errorletras">* La contrase&ntilde;a debe de tener minimo 8 caracteres en los cuales debe
                            de haber 1 may&uacute;scula, 1 min&uacute;scula, 1 n&uacute;mero y 1 signo de
                            puntuaci&oacute;n.</p>
                    </div>
                </div>
            </div>

            <div class="bloque">
                <div class="block">
                    <label for="nombre">Ingresa tu(s) nombre(s):</label>
                    <input type="text" id="nombre" name="nombre" onkeypress="return Nombre(event);" tabindex="3">
                    <p id="vacionombre">* Campo vac&iacute;o.</p>
                </div>

                <div class="columna">
                    <div>
                        <label for="apellidop">Ingresa tu apellido paterno:</label>
                        <input type="text" id="apellidop" name="apellidop" onkeypress="return Nombre(event);"
                            tabindex="4">
                        <p id="vacioapellidop">* Campo vac&iacute;o.</p>
                    </div>

                    <div>
                        <label for="apellidom">Ingresa tu apellido materno:</label>
                        <input type="text" id="apellidom" name="apellidom" onkeypress="return Nombre(event);"
                            tabindex="5">
                        <p id="vacioapellidom">* Campo vac&iacute;o.</p>
                    </div>
                </div>

                <div class="columna">
                    <div>
                        <label for="fechanac">Fecha de Nacimiento:</label>
                        <input type="date" id="fechanac" name="fechanac" tabindex="6">
                        <p id="vaciofechanac">* Debe seleccionar una fecha</p>
                        <p id="errorfechanac">* Su fecha de nacimiento no puede ser igual al día de hoy.</p>
                    </div>

                    <div>
                        <label for="genero">G&eacute;nero:</label>
                        <select name="genero" id="genero" name="genero" tabindex="7">
                            <option value="mujer">Mujer</option>
                            <option value="hombre">Hombre</option>
                        </select>
                        <p id="vaciogenero">* Debe seleccionar un g&eacute;nero.</p>
                    </div>
                </div>
            </div>

            <div class="bloquefoto">
                <label for="">Foto de Perfil:</label>
                <div><input type="file" id="image" name="image" accept="image/png, image/jpeg" tabindex="8"></div>
                <img class="usuarioFoto" id="fotoperfil" name="fotoperfil" src="#" alt="Foto de Perfil" />
                <p id="vaciofoto">* Debe seleccionar una imagen de perfil.</p>
            </div>

            <div class="bloque">
                <button id="crear" type="submit" tabindex="9">Registrarme</button>
            </div>

        </form>

        <div class="ingresar">
            <label>¿Ya tienes cuenta? <a href="IniciarSesion.php">Ingresa aquí</a></label>
        </div>
    </div>

    <div class="box-footer">
        <a href="">Enseña en Jako</a>
        <a href="">¿Qui&eacute;nes somos?</a>
        <a href="">Inscribite a nuestros cursos</a>
        <a href="">Trabaja con nosotros</a>
    </div>

    <script src="../js/jquery-3.6.0.min.js"></script>
    <script src="../js/CrearCuenta.js"></script>
</body>

</html>