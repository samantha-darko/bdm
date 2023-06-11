let mostrar = document.querySelector("#mostrar");
let ocultar = document.querySelector("#ocultar");
let formlogin = document.querySelector("#formlogin");
let correo = document.querySelector("#correo");
let contra = document.querySelector("#contra");
let login = document.querySelector("#login");
let errorcorreo = document.querySelector("#errorcorreo");
let errorcontra = document.querySelector("#errorcontra");
let vaciocorreo = document.querySelector("#vaciocorreo");
let vaciocontra = document.querySelector("#vaciocontra");

function Login(datos) {
    console.log(datos)
    if (datos[0] == 'valido') {
        sessionStorage.setItem("rol", datos[1])
        sessionStorage.setItem("idusuario", datos[2])
        document.getElementById("ventana-modal").style.display = "block"
        $(".modal").append("<div class='contenido-modal'> <a href='login.php'><img src='../multmedia/logo.png' titlle='Inicio'></a>" +
            "<div class='aviso-modal'> <p>Inicio de Sesión Existoso </p> <h2>¡Bienvenido de vuelta!</h2> </div> </div>")
        setTimeout(function () {
            $(".contenido-modal").remove();
            switch (datos[1]) {
                case "alumno": window.location.href = "PaginaPrincipal.php";
                    break;
                case "maestro": window.location.href = "Dashboard.php";
                    break;
                case "admin": window.location.href = "Administrador.php";
                    break;
            }
        }, 3000)
    } else {
        let mensaje = datos[0];
        document.getElementById("ventana-modal").style.display = "block"
        $(".modal").append("<div class='contenido-modal'> <a href='login.php'><i class='fa-sharp fa-solid fa-circle-xmark'></i><div class='aviso-modal'></a>" +
            "<div class='aviso-modal'> <p>Revise sus credenciales</p> <h2>" + mensaje + "</h2> </div> </div>");
        setTimeout(function () {
            $(".contenido-modal").remove();
            document.getElementById("ventana-modal").style.display = "none"
        }, 3000)
    }
}

function VerificarSesion() {
    if ("idusuario" in sessionStorage) {
        if (sessionStorage.getItem('idusuario').length > 0) {
            if (sessionStorage.getItem('rol') === "alumno") {
                window.location.href = "../paginas/PaginaPrincipal.php"
            } else {
                window.location.href = "../paginas/Dashboard.php"
            }
        }
    }
}

document.addEventListener("DOMContentLoaded", VerificarSesion)

$(document).ready(function () {

    correo.addEventListener("focus", function (e) {
        correo.style.borderColor = 'blue'
        correo.style.boxShadow = '0 1px 1px rgba(12, 22, 51, 0.075)inset, 0 0 8px rgba(7, 145, 230, 0.6)'
    })

    correo.addEventListener("blur", function (e) {
        correo.style.boxShadow = 'none'
        if (correo.value.length > 0) {
            correo.style.borderColor = 'gray'
            vaciocorreo.style.display = 'none'
        } else {
            correo.style.borderColor = '#FF331F'
            vaciocorreo.style.display = 'block'
        }
    })

    contra.addEventListener("focus", function (e) {
        contra.style.borderColor = 'blue'
        contra.style.boxShadow = '0 1px 1px rgba(12, 22, 51, 0.075)inset, 0 0 8px rgba(7, 145, 230, 0.6)'
    })

    contra.addEventListener("blur", function (e) {
        contra.style.boxShadow = 'none'
        if (contra.value.length > 0) {
            contra.style.borderColor = 'gray'
            vaciocontra.style.display = 'none'
        } else {
            contra.style.borderColor = '#FF331F'
            vaciocontra.style.display = 'block'
        }
    })

    mostrar.addEventListener("click", function (e) {
        e.preventDefault()
        contra.type = "text"
        mostrar.style.display = "none"
        ocultar.style.display = "block"
    })
    ocultar.addEventListener("click", function (e) {
        e.preventDefault()
        contra.type = "password"
        mostrar.style.display = "block"
        ocultar.style.display = "none"
    })

    formlogin.addEventListener("submit", function (e) {
        e.preventDefault()
        error = false
        if (correo.value.length > 0) {
            correo.style.borderColor = '#98CA3F'
            vaciocorreo.style.display = 'none'
        } else {
            correo.style.borderColor = '#FF331F'
            vaciocorreo.style.display = 'block'
        }

        if (contra.value.length > 0) {
            contra.style.borderColor = '#98CA3F'
            vaciocontra.style.display = 'none'
        } else {
            contra.style.borderColor = '#FF331F'
            vaciocontra.style.display = 'block'
        }

        if (!error) {
            fetch("../php/IniciarSesion.php", {
                method: "POST",
                body: new FormData(this)
            })
                .then(resultado => resultado.json())
                .then(resultado => Login(resultado))

        }

    })

});