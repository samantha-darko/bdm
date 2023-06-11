let titulo = document.querySelector("#titulo")
let cortotitulo = document.querySelector("#cortotitulo")
let vaciotitulo = document.querySelector("#vaciotitulo")


let resumen = document.querySelector("#resumen")
let cortoresumen = document.querySelector("#cortoresumen")
let vacioresumen = document.querySelector("#vacioresumen")

let archivos = document.querySelector("#archivos")
let vacioarchivos = document.querySelector("#vacioarchivos")

let costo = document.querySelector("#costo")
let cerocosto = document.querySelector("#cerocosto")
let vaciocosto = document.querySelector("#vaciocosto")

function mostrarArchivo(tipo, contenido, nombre) {
    var data = "data:" + tipo + ";base64," + contenido;
    var nuevaPestana = window.open(data);
    nuevaPestana.document.title = nombre;
}

function ValidarSesion() {
    if (!("idusuario" in sessionStorage)) {
        window.location.href = "../paginas/IniciarSesion.php"
    }
}

function Letters(e) {
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz123456789,¡!¿?/#-";
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

function Enfocar(objeto) {
    objeto.style.borderColor = 'blue'
    objeto.style.boxShadow = '0 1px 1px rgba(12, 22, 51, 0.075)inset, 0 0 8px rgba(7, 145, 230, 0.6)'
}

function Desenfocar(objeto, objeto2) {
    objeto.style.boxShadow = 'none'
    if (objeto.value.length > 0) {
        objeto.style.borderColor = 'gray'
        objeto2.style.display = 'none'
    } else {
        objeto.style.borderColor = '#FF331F'
        objeto2.style.display = 'block'
    }
}

function eliminar(idnivel) {
    $.ajax({
        type: 'GET',
        url: '../php/EliminarNivel.php?nivel=' + idnivel,
        success: function (resultado) {
            let idcurso = sessionStorage.getItem("curso")
            let datos = JSON.parse(resultado)
            console.log(datos)
            if (datos[0] === 1) {
                document.getElementById("ventana-modal").style.display = "block"
                $(".modal").append("<div class='contenido-modal'> <a href='login.php'><img src='../multmedia/logo.png' titlle='Inicio'></a>" +
                    "<div class='aviso-modal'> <p>Eliminar Nivel</p> <h2>Se ha eliminado el nivel de forma correcta.</h2> </div> </div>")
                setTimeout(function () {
                    $(".contenido-modal").remove();
                    window.location.href = window.location.href = "Niveles.php?curso=" + idcurso;
                }, 3000)
            } else {
                document.getElementById("ventana-modal").style.display = "block"
                $(".modal").append("<div class='contenido-modal'> <a href='login.php'><i class='fa-sharp fa-solid fa-circle-xmark'></i><div class='aviso-modal'></a>" +
                    "<div class='aviso-modal'> <p>Error</p> <h2>" + datos[1] + "</h2> </div> </div>");
                setTimeout(function () {
                    $(".contenido-modal").remove();
                    document.getElementById("ventana-modal").style.display = "none"
                }, 3000)
            }
        }
    })
}

document.addEventListener("DOMContentLoaded", ValidarSesion)

$(document).ready(function () {
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

    titulo.addEventListener("focus", function (e) {
        e.preventDefault();
        Enfocar(titulo)
    })
    titulo.addEventListener("blur", function (e) {
        e.preventDefault();
        Desenfocar(titulo, vaciotitulo)
    })

    costo.addEventListener("focus", function (e) {
        e.preventDefault();
        Enfocar(costo)
    })
    costo.addEventListener("blur", function (e) {
        e.preventDefault();
        Desenfocar(costo, vaciocosto)
    })

    $('#agregar').submit(function (e) {
        e.preventDefault()
        agregar = true;
        if (titulo.value.length === 0) {
            agregar = false
            titulo.style.borderColor = '#FF331F'
            vaciotitulo.style.display = "block";
            cortotitulo.style.display = "none";
        } else if (titulo.value.length < 10) {
            agregar = false
            titulo.style.borderColor = '#FF331F'
            cortotitulo.style.display = "block";
            vaciotitulo.style.display = "none";
        } else {
            titulo.style.borderColor = 'gray'
            cortotitulo.style.display = "none";
            vaciotitulo.style.display = "none";
        }

        if (resumen.value.length === 0) {
            agregar = false
            resumen.style.borderColor = '#FF331F'
            vacioresumen.style.display = "block";
            cortoresumen.style.display = "none";
        } else if (resumen.value.length < 10) {
            agregar = false
            resumen.style.borderColor = '#FF331F'
            cortoresumen.style.display = "block";
            vacioresumen.style.display = "none";
        } else {
            resumen.style.borderColor = 'gray'
            cortoresumen.style.display = "none";
            vacioresumen.style.display = "none";
        }

        if (document.querySelector("#costonivel").style.display === 'block') {
            if (costo.value.length === 0) {
                agregar = false
                costo.style.borderColor = '#FF331F'
                cerocosto.style.display = "block";
                vaciocosto.style.display = "none";
            } else if (costo.value < 1) {
                agregar = false
                costo.style.borderColor = '#FF331F'
                cerocosto.style.display = "none";
                vaciocosto.style.display = "block";
            } else {
                costo.style.borderColor = 'gray'
                cerocosto.style.display = "none";
                vaciocosto.style.display = "none";
            }

            if (archivos.value.length === 0) {
                agregar = false
                archivos.style.borderColor = '#FF331F'
                vacioarchivos.style.display = "block";
            } else {
                archivos.style.borderColor = 'gray'
                vacioarchivos.style.display = "none";
            }
        }

        if (agregar) {
            let idcurso = sessionStorage.getItem("curso")
            let idusuario = sessionStorage.getItem("idusuario")
            var formData = new FormData(this);
            $.ajax({
                url: '../php/AgregarNivel.php?curso=' + idcurso + '&maestro=' + idusuario,
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function (response) {
                    let datos = JSON.parse(response)
                    console.log(datos)
                    if (datos[1] === 1) {
                        document.getElementById("ventana-modal").style.display = "block"
                        $(".modal").append("<div class='contenido-modal'> <a href='login.php'><img src='../multmedia/logo.png' titlle='Inicio'></a>" +
                            "<div class='aviso-modal'> <p>Agregar Nivel</p> <h2>Se ha agregado el nivel de forma correcta.</h2> </div> </div>")
                        setTimeout(function () {
                            $(".contenido-modal").remove();
                            window.location.href = "Niveles.php?curso=" + idcurso;
                        }, 3000)
                    } else {
                        document.getElementById("ventana-modal").style.display = "block"
                        $(".modal").append("<div class='contenido-modal'> <a href='login.php'><i class='fa-sharp fa-solid fa-circle-xmark'></i><div class='aviso-modal'></a>" +
                            "<div class='aviso-modal'> <p>No se creo el nivel</p> <h2>" + datos[2] + "</h2> </div> </div>");
                        setTimeout(function () {
                            $(".contenido-modal").remove();
                            document.getElementById("ventana-modal").style.display = "none"
                        }, 3000)
                    }
                }
            });
        } else {
            document.querySelector("#ventana-modal").style.display = "block";
            $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
                "<div class='aviso-modal'><p>Verifique sus datos</p> <h2>No se pudo realizar el registro</h2></div></div>");
            setTimeout(function () {
                $(".contenido-modal").remove();
                document.querySelector("#ventana-modal").style.display = "none";
                window.scrollTo({ top: 100, behavior: 'smooth' })
            }, 3000)
        }

    })

})