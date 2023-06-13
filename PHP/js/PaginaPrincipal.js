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
    document.querySelector('#buscador').addEventListener('submit', function (e) {
        e.preventDefault();
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