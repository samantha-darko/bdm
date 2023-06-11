let mostrar = document.querySelector("#mostrar");
let ocultar = document.querySelector("#ocultar");

let fotoperfil = document.querySelector("#fotoperfil");
let registro = document.querySelector("#registro");
let correo = document.querySelector("#correo")
let contra = document.querySelector("#contra")
let nombre = document.querySelector("#nombre")
let apellidop = document.querySelector("#apellidop")
let apellidom = document.querySelector("#apellidom")
let fechanac = document.querySelector("#fechanac")
let genero = document.querySelector("#genero")

let vaciocorreo = document.querySelector("#vaciocorreo")
let errorcorreo = document.querySelector("#errorcorreo")
let vaciocontra = document.querySelector("#vaciocontra")
let vacionombre = document.querySelector("#vacionombre")
let vacioapellidop = document.querySelector("#vacioapellidop")
let vacioapellidom = document.querySelector("#vacioapellidom")
let vaciofechanac = document.querySelector("#vaciofechanac")
let errorfechanac = document.querySelector("#errorfechanac")
let vaciogenero = document.querySelector("#vaciogenero")

function readURL(input) {
    if (input.files && input.files[0]) { //Revisamos que el input tenga contenido
        var reader = new FileReader(); //Leemos el contenido

        reader.onload = function (e) { //Al cargar el contenido lo pasamos como atributo de la imagen de arriba
            fotoperfil.style.display = 'block'
            $('#fotoperfil').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    } else {
        fotoperfil.style.display = 'none'
    }
}

function validarCorreo(correo, correovacio, errorcorreo) {
    var regCorreo = /^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    var error = false;
    var email = correo.value;

    if (correo.value.length < 1) {
        correovacio.style.display = "block";
        error = true;
    } else {
        correovacio.style.display = "none";
        if (!regCorreo.test(email)) {
            correo.style.borderColor = '#FF331F'
            errorcorreo.style.display = "block";
            error = true;
        } else {
            errorcorreo.style.display = "none";
            error = false;
        }
    }
    return error;
}

function validarNombre(nombre, idvacio) {
    var error = false;

    if (nombre.value.length < 1) {
        idvacio.style.display = "block";
        error = true;
    } else {
        idvacio.style.display = "none";
    }
    return error;
}

function SoloLetras(e) { //FUNCIÓN PARA VALIDAR SÓLO LETRAS (NOMBRE Y APELLIDO)
    key = e.keyCode || e.which;  //Agarra el evento cuando presiono el teclado
    tecla = String.fromCharCode(key).toString();
    letras = "ABCDEFGHIJKLMNOPQRSTUVWXYZÁÉÍÓÚabcdefghijklmnopqrstuvwxyzáéíóúñÑ";

    especiales = [8, 13, 32, 164, 165];
    tecla_especial = false;
    for (var i in especiales) {
        if (key === especiales[i]) {
            tecla_especial = true;
            break;
        }
    }

    if (letras.indexOf(tecla) === -1 && !tecla_especial) { //SI PONEMOS UN NÚMERO

        //document.getElementById("msjErrorName").style.display = "block";
        alert("Ingresar solo letras");

        return false;
    } else {
        //document.getElementById("msjErrorName").style.display = "none";
    }
}

function validarPassword(password) {

    var error = false;

    if (password.value.length < 1) {
        error = true;
        vaciocontra.style.display = "block"
    } else {
        vaciocontra.style.display = "none"
    }

    if (!error) {
        var minimocar = false;
        var mayuscula = false;
        var minuscula = false;
        var numero = false;
        var caracter_raro = false;

        if (password.value.length > 7) {
            minimocar = true;
        }

        for (var i = 0; i < password.value.length; i++) {
            if (password.value.charCodeAt(i) >= 65 && password.value.charCodeAt(i) <= 90) {
                mayuscula = true;
            }
            if (password.value.charCodeAt(i) >= 97 && password.value.charCodeAt(i) <= 122) {
                minuscula = true;

            }
            if (password.value.charCodeAt(i) >= 48 && password.value.charCodeAt(i) <= 57) {
                numero = true;
            }
            if ((password.value.charCodeAt(i) >= 35 && password.value.charCodeAt(i) <= 38)
                || password.value.charCodeAt(i) == 33 || password.value.charCodeAt(i) == 42
                || password.value.charCodeAt(i) == 43 || password.value.charCodeAt(i) == 46
                || password.value.charCodeAt(i) == 47) {
                caracter_raro = true;
            }
        }
        if (minimocar === true && mayuscula === true && minuscula === true && caracter_raro === true && numero === true) {
            errorletras.style.display = 'none';

        } else {
            errorletras.style.display = 'block';
            error = true;
        }
    }

    return error;
}

function validarUsuario(usuario, idvacio, iderror) {
    const user = usuario;
    const regUsuario = /^[a-zA-Z0-9]+$/;
    var error = false;

    if (user == 0) {
        document.getElementById(idvacio).style.display = "block"
        error = true;
    } else {
        document.getElementById(idvacio).style.display = "none"
        error = false;
    }

    if (!error) {
        if (user.length > 2 && !regUsuario.test(user)) {
            document.getElementById(iderror).style.display = "block"
            error = true;
        } else {
            document.getElementById(iderror).style.display = "none"
            error = false;
        }
    }

    return error;
}

function validarFecha(fecha, iderror, idvacio) {
    var error = false;

    if (fecha == "") {
        document.getElementById(idvacio).style.display = "block";
        error = true;
    } else {
        document.getElementById(idvacio).style.display = "none";
        const date1 = new Date(Date.now());
        const date2 = new Date(fecha);
        date2.setMinutes(date2.getMinutes() + date2.getTimezoneOffset());
        date1.setHours(0, 0, 0);
        date2.setHours(0, 0, 0);

        if (date1 < date2) {
            document.getElementById(iderror).style.display = "block";
            error = true;
        } else {
            document.getElementById(iderror).style.display = "none";
            error = false;
        }
    }

    return error;
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

function Nombre(e) {
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key).toLowerCase();
    letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
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

function Correo(e) {
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key).toLowerCase();
    letras = "abcdefghijklmnopqrstuvwxyz1234567890.-_@";
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

function Contra(e) {
    key = e.keyCode || e.which;
    teclado = String.fromCharCode(key).toLowerCase();
    letras = "abcdefghijklmnopqrstuvwxyz1234567890ñ.#$%!¡¿?()*/-_";
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

$(document).ready(function () {
    $("#image").change(function () {
        readURL(this);
    });

    ////////////////////
    correo.addEventListener("focus", function (e) {
        Enfocar(correo)
    })

    correo.addEventListener("blur", function (e) {
        Desenfocar(correo, vaciocorreo)
    })
    ////////////////////
    contra.addEventListener("focus", function (e) {
        Enfocar(contra)
    })

    contra.addEventListener("blur", function (e) {
        Desenfocar(contra, vaciocontra)
    })
    ////////////////////
    /*contrac.addEventListener("focus", function (e) {
        Enfocar(contrac)
    })

    contrac.addEventListener("blur", function (e) {
        Desenfocar(contrac, vaciocontrac)
    })*/
    ////////////////////
    nombre.addEventListener("focus", function (e) {
        Enfocar(nombre)
    })

    nombre.addEventListener("blur", function (e) {
        Desenfocar(nombre, vacionombre)
    })
    ////////////////////
    apellidop.addEventListener("focus", function (e) {
        Enfocar(apellidop)
    })

    apellidop.addEventListener("blur", function (e) {
        Desenfocar(apellidop, vacioapellidop)
    })
    ////////////////////
    apellidom.addEventListener("focus", function (e) {
        Enfocar(apellidom)
    })

    apellidom.addEventListener("blur", function (e) {
        Desenfocar(apellidom, vacioapellidom)
    })
    ////////////////////
    fechanac.addEventListener("focus", function (e) {
        Enfocar(fechanac)
    })

    fechanac.addEventListener("blur", function (e) {
        Desenfocar(fechanac, vaciofechanac)
    })
    ////////////////////
    genero.addEventListener("focus", function (e) {
        Enfocar(genero)
    })

    genero.addEventListener("blur", function (e) {
        Desenfocar(genero, vaciogenero)
    })
    ////////////////////
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

    registro.addEventListener("submit", function (e) {
        e.preventDefault();
        efoto = false
        ecorreo = validarCorreo(correo, vaciocorreo, errorcorreo)
        econtra = validarPassword(contra)
        enombre = validarNombre(nombre, vacionombre)
        eapellidop = validarNombre(apellidop, vacioapellidop)
        eapellidom = validarNombre(apellidom, vacioapellidom)
        if (document.querySelector("#fotoperfil").style.display == '') {
            document.querySelector("#vaciofoto").style.display = 'block'
            efoto = true
        } else {
            document.querySelector("#vaciofoto").style.display = 'none'
        }

        if (ecorreo || econtra || enombre || eapellidop || eapellidom || efoto) {
            document.querySelector("#ventana-modal").style.display = "block";
            $(".modal").append("<div class='contenido-modal'><i class='fa-sharp fa-solid fa-circle-xmark'></i>" +
                "<div class='aviso-modal'><p>Verifique sus datos</p> <h2>No se pudo realizar el registro</h2></div></div>");
            setTimeout(function () {
                $(".contenido-modal").remove();
                document.querySelector("#ventana-modal").style.display = "none";
                window.scrollTo({ top: 100, behavior: 'smooth' })
            }, 3000)
        } else {
            $.ajax({
                type: "POST",
                url: "../php/AgregarCliente.php",
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
                            "<div class='aviso-modal'><p>Registrarse</p> <h2>Se ha registrado de forma satisfactoria</h2></div></div>");
                        setTimeout(function () {
                            $(".contenido-modal").remove();
                            document.querySelector("#ventana-modal").style.display = "none";
                            $('#registro').get(0).reset()
                            window.location.href = "IniciarSesion.php"
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
                        if (res[0] === 1062) {
                            correo.style.borderColor = '#FF331F'
                            errorcorreo.style.display = "block";
                        }
                    }
                }

            })
        }
    })
})