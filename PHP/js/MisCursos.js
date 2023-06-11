// Obtener los botones del cuadro de confirmación personalizado
const btnConfirmar = document.getElementById("btn-confirmar");
const btnCancel = document.getElementById("btn-cancelar");
// Obtener el botón de eliminar
//const botonEliminar = document.getElementById("boton-eliminar");

function VerificarSesion() {
    if (!("idusuario" in sessionStorage)) {
        window.location.href = "../paginas/IniciarSesion.php"
    }
}

function finalizar(id) {
    // Mostrar el cuadro de confirmación personalizado
    const confirmacion = document.getElementById("confirmacion");
    confirmacion.style.display = "block";
    sessionStorage.setItem('idcursoinscrito', id)
}

function confirmarEliminacion() {
    let cursoId = sessionStorage.getItem('idcursoinscrito')
    $.ajax({
        type: "GET",
        url: "../php/FinalizarCurso.php?id=" + cursoId, // Reemplaza "cursoId" con el ID del curso correspondiente
        success: function (resultado) {
            let res = JSON.parse(resultado);
            console.log(res);
            if (res[0]) {
                const confirmacion = document.getElementById("confirmacion");
                confirmacion.style.display = "none";
                document.querySelector("#ventana-modal").style.display = "block";
                $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-check'></i>" +
                    "<div class='aviso-modal'><p>Finalizar Curso</p> <h2>Se ha actualizado la información correctamente</h2></div></div>");
                setTimeout(function () {
                    $(".contenido-modal").remove();
                    document.querySelector("#ventana-modal").style.display = "none";
                    window.location.href = "MisCursos.php"
                }, 2500);
            } else {
                document.querySelector("#ventana-modal").style.display = "block";
                $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
                    "<div class='aviso-modal'><p>Error en el Servidor</p> <h2>No se pudo actualizar los datos. " +
                    "Intente de nuevo más tarde.</h2></div></div>");
                setTimeout(function () {
                    $(".contenido-modal").remove();
                    document.querySelector("#ventana-modal").style.display = "none";
                }, 3000);
            }
        }
    });
}

// Ocultar el cuadro de confirmación personalizado
const confirmacion = document.getElementById("confirmacion");
confirmacion.style.display = "none";
function cancelarEliminacion() {
    // Ocultar el cuadro de confirmación personalizado
    const confirmacion = document.getElementById("confirmacion");
    confirmacion.style.display = "none";

    console.log("Cancelado");
    sessionStorage.removeItem('idcursoinscrito')
}

document.addEventListener("DOMContentLoaded", VerificarSesion)

$(document).ready(function () {

    btnConfirmar.addEventListener("click", confirmarEliminacion);
    btnCancel.addEventListener("click", cancelarEliminacion);

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