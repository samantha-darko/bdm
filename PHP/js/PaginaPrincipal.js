function Agregar(idcurso) {
    sessionStorage.setItem('curso', idcurso);
    window.location.href = '../paginas/InscribirCurso.php?curso=' + idcurso;
}

function VerificarSesion() {
    if (!("idusuario" in sessionStorage)) {
        window.location.href = "../paginas/IniciarSesion.php"
    }
    if ("total" in sessionStorage)
        sessionStorage.removeItem("total")
    if ("curso" in sessionStorage)
        sessionStorage.removeItem("curso")
}

document.addEventListener("DOMContentLoaded", VerificarSesion)

$(document).ready(function () {
    document.querySelector('#btn-search').addEventListener('click', function (e) {
        e.preventDefault();
        if (document.querySelector('#nav-search').value.length === 0) {
            document.querySelector("#ventana-modal").style.display = "block";
            $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
                "<div class='aviso-modal'><p>Buscador</p> <h2>Debe ingresar una categoria a buscar</h2></div></div>");
            setTimeout(function () {
                $(".contenido-modal").remove();
                document.querySelector("#ventana-modal").style.display = "none";
                window.scrollTo({ top: 100, behavior: 'smooth' })
            }, 3000)
        } else {
            let categoria = document.querySelector('#nav-search').value
            window.location.href = '../paginas/Buscador.php?categoria=' + categoria;
        }
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