let crear = document.querySelector("#crear");
let titulo = document.querySelector("#titulo");
let descripcion = document.querySelector("#descripcion");

function eliminar(id) {
    $.ajax({
        url: '../php/Categoria.php',
        type: 'POST',
        data: {
            idcurso: id,
            opcion: 'eliminar'
        },
        success: function (response) {
            let respuesta = JSON.parse(response)
            console.log(respuesta)
            if (respuesta[0]) {
                document.querySelector("#ventana-modal").style.display = "block";
                $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-check'></i>" +
                    "<div class='aviso-modal'><p>Categoria</p> <h2>Se ha eliminado la categoria correctamente</h2></div></div>");
                setTimeout(function () {
                    $(".contenido-modal").remove();
                    document.querySelector("#ventana-modal").style.display = "none";
                    window.location.href = "Administrador.php"
                }, 2500)
            } else {
                document.querySelector("#ventana-modal").style.display = "block";
                $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
                    "<div class='aviso-modal'><p>Intente de nuevo</p> <h2> " + respuesta + "</h2></div></div>");
                setTimeout(function () {
                    $(".contenido-modal").remove();
                    document.querySelector("#ventana-modal").style.display = "none";
                    window.scrollTo({ top: 100, behavior: 'smooth' })
                }, 3000)
            }
        }
    })
}

function Letters(e) {
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz123456789,¡!¿?/#";
    especiales = "8-37-38-46-164";
    teclasEspeciales = false;

    for (var i in especiales) {
        if (key == especiales[i]) {
            teclasEspeciales = true; break;
        }
    }
    if (letras.indexOf(teclado) == -1 && !teclasEspeciales) {
        return false;
    }
}

function VerificarSesion() {
    if (!("idusuario" in sessionStorage)) {
        window.location.href = "../paginas/IniciarSesion.php"
    }
}

document.addEventListener("DOMContentLoaded", VerificarSesion)

$(document).ready(function () {

    crear.addEventListener("submit", function (e) {
        e.preventDefault();
        if (titulo.value.length > 0 && descripcion.value.length > 0) {
            $.ajax({
                type: "POST",
                url: "../php/AgregarCategoria.php",
                cache: false,
                contentType: false,
                processData: false,
                data: new FormData(this),
                success: function (resultado) {
                    let res = JSON.parse(resultado);
                    console.log(res)
                    if (res[0] === 1) {
                        document.querySelector("#ventana-modal").style.display = "block";
                        $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-check'></i>" +
                            "<div class='aviso-modal'><p>Categoria</p> <h2>Se ha agregado la categoria correctamente</h2></div></div>");
                        setTimeout(function () {
                            $(".contenido-modal").remove();
                            document.querySelector("#ventana-modal").style.display = "none";
                            $('#crear').get(0).reset()
                            window.location.href = "Administrador.php"
                        }, 2500)
                    } else {
                        document.querySelector("#ventana-modal").style.display = "block";
                        $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
                            "<div class='aviso-modal'><p>Intente de nuevo</p> <h2> " + res[1] + "</h2></div></div>");
                        setTimeout(function () {
                            $(".contenido-modal").remove();
                            document.querySelector("#ventana-modal").style.display = "none";
                            window.scrollTo({ top: 100, behavior: 'smooth' })
                        }, 3000)
                    }
                }

            })
        } else {
            document.querySelector("#ventana-modal").style.display = "block";
            $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
                "<div class='aviso-modal'><p>Categoria</p> <h2>Verifique los datos ingresados. No deje campos vacios.</h2></div></div>");
            setTimeout(function () {
                $(".contenido-modal").remove();
                document.querySelector("#ventana-modal").style.display = "none";
            }, 2500)
        }
    });

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