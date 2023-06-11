var selectElement = document.getElementById("listausuarios");
var idRecibido = document.getElementById("idRecibido");


function VerificarSesion() {
    if (!("idusuario" in sessionStorage)) {
        window.location.href = "../paginas/IniciarSesion.php"
    } else {
        iduser = sessionStorage.getItem("idusuario")
        document.querySelector("#idEnviado").value = iduser
        document.querySelector("#idEnviado").disabled = "true";
        $.ajax({
            url: "../php/ListaUsuarios.php",
            success: function (data) {
                var lista = JSON.parse(data)
                for (var i = 0; i < lista.length; i++) {
                    var opcion = lista[i];
                    var optionElement = document.createElement("option");
                    optionElement.value = opcion['id_usuario'];
                    optionElement.text = opcion['correo'];

                    selectElement.appendChild(optionElement);
                }
                idRecibido.value = lista[0]['id_usuario']

            },
            error: function (error) {
                document.querySelector("#ventana-modal").style.display = "block";
                $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
                    "<div class='aviso-modal'><p>Error</p> <h2>Ocurrio un error en la base de datos: " + error + "</h2></div></div>");
                setTimeout(function () {
                    $(".contenido-modal").remove();
                    document.querySelector("#ventana-modal").style.display = "none";
                    window.scrollTo({ top: 100, behavior: 'smooth' })
                }, 3000)
            }
        });
    }
}

document.addEventListener("DOMContentLoaded", VerificarSesion)

$(document).ready(function () {

    function enviarMensaje() {
        var idEnviado = $("#idEnviado").val();
        var idRecibido = selectElement.value; //$("#idRecibido").val();
        var mensaje = $("#mensaje").val();

        $.ajax({
            type: "POST",
            url: "../php/enviarMensaje.php", // El archivo PHP que procesará la solicitud
            data: {
                idEnviado: idEnviado,
                idRecibido: idRecibido,
                mensaje: mensaje
            },
            success: function (response) {
                document.querySelector("#ventana-modal").style.display = "block";
                $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-check'></i>" +
                    "<div class='aviso-modal'><p>Chat</p> <h2>Se ha enviado su mensaje</h2></div></div>");
                setTimeout(function () {
                    $(".contenido-modal").remove();
                    document.querySelector("#ventana-modal").style.display = "none";
                    window.scrollTo({ top: 100, behavior: 'smooth' })
                }, 3000)
                // Limpiar el formulario después de enviar el mensaje
                $("#idEnviado").val("");
                $("#idRecibido").val("");
                $("#mensaje").val("");
                window.location.href = "Chat.php"
            },
            error: function (xhr, status, error) {
                alert("Error al enviar el mensaje: " + error);
            }
        });
    }

    // Función para recibir mensajes
    function recibirMensajes() {
        var idUsuario = sessionStorage.getItem("idusuario")

        $.ajax({
            type: "GET",
            url: "../php/recibirMensajes.php", // El archivo PHP que procesará la solicitud
            data: {
                idUsuario: idUsuario
            },
            success: function (response) {
                console.log(response)
                $("#mensajesContainer").html(response);
            },
            error: function (xhr, status, error) {
                document.querySelector("#ventana-modal").style.display = "block";
                $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
                    "<div class='aviso-modal'><p>Error</p> <h2>Ocurrio un error en la base de datos: " + error + "</h2></div></div>");
                setTimeout(function () {
                    $(".contenido-modal").remove();
                    document.querySelector("#ventana-modal").style.display = "none";
                    window.scrollTo({ top: 100, behavior: 'smooth' })
                }, 3000)
            }
        });
    }

    // Manejar el envío del formulario para enviar mensajes
    $("#enviarMensajeForm").submit(function (event) {
        event.preventDefault(); // Evitar el envío del formulario

        enviarMensaje();
    });

    // Ejecutar la función para recibir mensajes cuando se cargue la página
    recibirMensajes();

    document.querySelector('#salir').addEventListener('click', function (e) {
        e.preventDefault();
        if ('idusuario' in sessionStorage) {
            sessionStorage.removeItem('idusuario');
        }
        if ('rol' in sessionStorage) {
            sessionStorage.removeItem('rol');
        }
        sessionStorage.clear()
        $.ajax({
            url: '../php/CerrarSesion.php',
            success: function (resultado) {
                var res = JSON.parse(resultado)
                console.log(res)
                if (res) {
                    window.location.href = '../paginas/IniciarSesion.php'
                }
            }
        })
    })

})