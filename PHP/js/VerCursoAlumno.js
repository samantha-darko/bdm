let calificacion = 0

function rateCourse(rating) {
    var stars = document.getElementsByClassName('star');
    for (var i = 0; i < stars.length; i++) {
        if (i < rating) {
            stars[i].classList.add('checked');
        } else {
            stars[i].classList.remove('checked');
        }
    }
    calificacion = rating
}

function VerificarSesion() {
    if (!("idusuario" in sessionStorage)) {
        window.location.href = "../paginas/IniciarSesion.php"
    }
    const valores = window.location.search;
    const urlParams = new URLSearchParams(valores);
    var curso = urlParams.get('curso');
    console.log(curso);
    $.ajax({
        url: '../php/VerCurso.php?curso=' + curso,
        success: function (resultado) {
            let res = JSON.parse(resultado);
            console.log(res)
        }
    })
}

document.addEventListener("DOMContentLoaded", VerificarSesion)

$(document).ready(function () {

    document.querySelector("#btnGuardar").addEventListener('click', function (e) {
        e.preventDefault()
        const valores = window.location.search;
        const urlParams = new URLSearchParams(valores);
        var curso = urlParams.get('curso');
        var usuario = sessionStorage.getItem('idusuario')
        var formData = new FormData();
        formData.append('rating', calificacion);
        formData.append('opcion', 'calificacion');
        formData.append('usuario', usuario)
        formData.append('curso', curso)
        $.ajax({
            type: "POST",
            url: "../php/Comentario.php",
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function (resultado) {
                let res = JSON.parse(resultado);
                console.log(res);
                if (res[0]) {
                    document.querySelector("#ventana-modal").style.display = "block";
                    $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-check'></i>" +
                        "<div class='aviso-modal'><p>Editar Curso</p> <h2>Se han actualizado los datos correctamente</h2></div></div>");
                    setTimeout(function () {
                        $(".contenido-modal").remove();
                        document.querySelector("#ventana-modal").style.display = "none";
                        window.location.href = "VerCursoAlumno.php?curso=" + curso
                    }, 2500)
                } else {
                    document.querySelector("#ventana-modal").style.display = "block";
                    $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
                        "<div class='aviso-modal'><p>Error en el Servidor</p> <h2> " + res[1] +
                        "Intente de nuevo más tarde.</h2></div></div>");
                    setTimeout(function () {
                        $(".contenido-modal").remove();
                        document.querySelector("#ventana-modal").style.display = "none";
                    }, 3000)
                }
            }

        })
    })
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