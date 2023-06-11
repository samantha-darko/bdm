let datos = document.querySelector("#datos");

let titulo = document.querySelector("#titulo");
let cortotitulo = document.querySelector("#cortotitulo");
let vaciotitulo = document.querySelector("#vaciotitulo");

let descripcion = document.querySelector("#descripcion");
let cortodescripcion = document.querySelector("#cortodescripcion");
let vaciodescripcion = document.querySelector("#vaciodescripcion");

let fotocurso = document.querySelector("#fotocurso");
let vaciofoto = document.querySelector("#vaciofoto");

let preciocurso = document.querySelector("#preciocurso");
let costocurso = document.querySelector("#costocurso");
let cerocosto = document.querySelector("#cerocosto");
let vaciocosto = document.querySelector("#vaciocosto");

let tipo = document.querySelector("#tipo");

function readURL(input) {
    if (input.files && input.files[0]) { //Revisamos que el input tenga contenido
        var reader = new FileReader(); //Leemos el contenido

        reader.onload = function (e) { //Al cargar el contenido lo pasamos como atributo de la imagen de arriba
            fotocurso.style.display = 'block'
            vaciofoto.style.display = 'none'
            $('#fotocurso').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        fotocurso.style.display = 'none'
        vaciofoto.style.display = 'block'
    }
}

function filterFloat(evt, input) {
    // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
    var key = window.Event ? evt.which : evt.keyCode;
    var chark = String.fromCharCode(key);
    var tempValue = input.value + chark;
    if (key >= 48 && key <= 57) {
        if (filter(tempValue) === false) {
            return false;
        } else {
            return true;
        }
    } else {
        if (key == 8 || key == 13 || key == 0) {
            return true;
        } else if (key == 46) {
            if (filter(tempValue) === false) {
                return false;
            } else {
                return true;
            }
        } else {
            return false;
        }
    }
}
function filter(__val__) {
    var preg = /^([0-9]+\.?[0-9]{0,2})$/;
    if (preg.test(__val__) === true) {
        return true;
    } else {
        return false;
    }

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

function infocurso() {
    if (!("idusuario" in sessionStorage)) {
        window.location.href = "../paginas/IniciarSesion.php"
    } else {
        let id = sessionStorage.getItem('curso')
        if (id.length > 0) {
            const formData = new FormData();
            formData.append("curso", id);
            fetch('../php/VerCursoMaestro.php?curso=' + id, {
                method: "GET",
                headers: { 'Content-Type': 'application/json' },
            })
                .then(res => res.json())
                .then(resultado => Mostrar(resultado))
        }
    }
}

function Mostrar(resultado) {
    if (resultado === "Este curso se ha eliminado") {
        document.querySelector("#ventana-modal").style.display = "block";
        $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
            "<div class='aviso-modal'><p>Verifique sus datos</p> <h2>Este curso se ha eliminado</h2></div></div>");
        setTimeout(function () {
            $(".contenido-modal").remove();
            document.querySelector("#ventana-modal").style.display = "none";
            window.scrollTo({ top: 100, behavior: 'smooth' })
        }, 3000)
    } else {
        if (resultado['id_curso'] != "") {
            document.querySelector("#idcurso").setAttribute("value", resultado['id_curso'])
            fotocurso.src = "data:image/png;base64," + resultado['imagen'];
            titulo.setAttribute("value", resultado['titulo'])
            descripcion.innerText = resultado['descripcion']
            if (resultado['costo'] > "0.00") {
                preciocurso.style.display = "block"
                costocurso.setAttribute("value", resultado['costo'])
                tipo.innerText = 'Por curso'
                document.querySelector("#price").style.display = "block"
                document.querySelector("#price").innerText = resultado['costo']
            } else {
                preciocurso.style.display = "none"
                document.querySelector("#price").innerText = "N/A"
            }
            document.querySelector("#foto").src = "data:image/png;base64," + resultado['imagen'];
            document.querySelector("#tittle").innerText = resultado['titulo']
            document.querySelector("#description").innerText = resultado['descripcion']
        } else {
            document.querySelector("#ventana-modal").style.display = "block";
            $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
                "<div class='aviso-modal'><p>Verifique sus datos</p> <h2>No se encontro ningun curso con ese id.</h2></div></div>");
            setTimeout(function () {
                $(".contenido-modal").remove();
                document.querySelector("#ventana-modal").style.display = "none";
                window.scrollTo({ top: 100, behavior: 'smooth' })
            }, 3000)
        }

    }
}

document.addEventListener("DOMContentLoaded", infocurso)

$(document).ready(function () {
    $("#image").change(function () {
        readURL(this);
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

    document.querySelector('#btnEditar').addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector('#info').style.display = "none";
        document.querySelector('#datos').style.display = "block";
    })

    document.querySelector('#btnEliminar').addEventListener('click', function (e) {
        e.preventDefault();
        let id = sessionStorage.getItem('curso')
        $.ajax({
            url: '../php/EliminarCurso.php?curso='+id,
            success: function (resultado) {
                var res = JSON.parse(resultado)
                console.log(res)
            }
        })
    })

    document.querySelector('#btnCancelar').addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector('#datos').style.display = "none";
        document.querySelector('#info').style.display = "block";
    })

    document.querySelector('#btnNiveles').addEventListener('click', function (e) {
        e.preventDefault();
        let id = sessionStorage.getItem('curso')
        window.location.href = '../paginas/Niveles.php?curso=' + id;
    })

    document.querySelector('#btnGuardar').addEventListener('click', function (e) {
        e.preventDefault();
        e.preventDefault();
        costoc = true;
        if (preciocurso.style.display == 'block' && costocurso.value === '0') {
            costoc = false;
        }
        if (titulo.value.length > 4 && descripcion.value.length > 9 && costoc && document.querySelector("#image").value.length > 0) {
            $.ajax({
                type: "POST",
                url: "../php/EditarCurso.php",
                cache: false,
                contentType: false,
                processData: false,
                data: new FormData(datos),
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
                            window.location.href = "Dashboard.php"
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
        } else {
            if (titulo.value.length == 0) {
                titulo.style.borderColor = '#FF331F'
                vaciotitulo.style.display = 'block'
            } else if (titulo.value.length < 5) {
                titulo.style.borderColor = '#FF331F'
                cortotitulo.style.display = 'block'
            }

            if (descripcion.value.length == 0) {
                descripcion.style.borderColor = '#FF331F'
                vaciodescripcion.style.display = 'block'
            } else if (descripcion.value.length < 10) {
                descripcion.style.borderColor = '#FF331F'
                cortodescripcion.style.display = 'block'
            }

            if (preciocurso.style.display == 'block') {
                if (costocurso.value.length == 0) {
                    costocurso.style.borderColor = '#FF331F'
                    vaciocosto.style.display = 'block'
                } else if (costocurso.value == '0') {
                    costocurso.style.borderColor = '#FF331F'
                    cerocosto.style.display = 'block'
                }
            }

            if (fotocurso.style.display == '') {
                vaciofoto.style.display = 'block'
            }
            document.querySelector("#ventana-modal").style.display = "block";
            $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
                "<div class='aviso-modal'><p>Verifique sus datos</p> <h2>No se pudo actualizar la informacion</h2></div></div>");
            setTimeout(function () {
                $(".contenido-modal").remove();
                document.querySelector("#ventana-modal").style.display = "none";
                window.scrollTo({ top: 100, behavior: 'smooth' })
            }, 3000)
        }
    })
})