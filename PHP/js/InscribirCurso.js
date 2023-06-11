let _total = 0;
let _curso = 0;
let _usuario = 0;
let _niveles = [];
let _tipo = "";

function VerificarSesion() {
    if (!("idusuario" in sessionStorage)) {
        window.location.href = "../paginas/IniciarSesion.php"
    }
    idcurso = sessionStorage.getItem('curso')
    _usuario = sessionStorage.getItem('idusuario')
    $.ajax({
        url: '../php/VerCurso.php?curso=' + idcurso,
        success: function (resultado) {
            let res = JSON.parse(resultado);
            //console.log(res)
            let total = 0
            if (res != "vacio") {
                _curso = res[0]['id_curso']
                $("#curso").append("<label>Titulo Curso:</label>" +
                    "<h2>" + res[0]['titulo_curso'] + "</h2>" +
                    "<div id='infocurso'>" +
                    "<div><label>Descripción:</label>" +
                    "<p class='descripcion_curso'>" + res[0]['descripcion_curso'] + "</p></div>")
                if (res[0]['costo_curso'] != "0.00") {
                    $("#curso").append("<div><label>Costo curso:</label>" +
                        "<h3 class='costo_curso'>" + res[0]['costo_curso'] + "</h3></div>" +
                        "</div>")
                    $("#curso").append("<div><p>*No se puede pagar por nivel, debe comprar el curso completo</p>")
                    _tipo = "por curso"
                    total = parseFloat(res[0]['costo_curso'])
                } else {
                    $("#curso").append("<div><p>*Este curso se cobra por nivel</p>")
                    _tipo = "por nivel"
                }
                for (i = 0; i < res.length; i++) {
                    _niveles.push(res[i]['id_nivel']);
                    if (res[i]['costo_nivel'] != "0.00") {
                        precio = parseFloat(res[i]['costo_nivel'])
                        total = total + precio
                    }
                    $("#nivel").append(
                        "<div id='infonivel'>" +
                        "<div><label>Titulo nivel:</label>" +
                        "<h4>" + res[i]['titulo_nivel'] + "</h4></div>" +
                        "<div><label>Costo nivel:</label>" +
                        "<h4>" + res[i]['costo_nivel'] + "</h4></div>" +
                        "</div>")
                }
                $("#total").append("<h1>Total a pagar: $" + total + "</h1>")
            }
            if (total != 0) {
                console.log(total)
                sessionStorage.setItem("total", total)
                _total = total
            } else {
                if ("total" in sessionStorage) {
                    sessionStorage.removeItem("total")
                }
            }
        }
    })
}

document.addEventListener("DOMContentLoaded", VerificarSesion)

paypal.Buttons({
    style: {
        color: "blue",
        shape: "pill",
        label: "pay"
    },
    createOrder: function (data, actions) {
        return actions.order.create({
            purchase_units: [{
                amount: {
                    currency_code: "MXN",
                    value: _total
                }
            }]
        })
    },
    onCancel: function (data) {
        document.getElementById("ventana-modal").style.display = "block"
        $(".modal").append("<div class='contenido-modal'> <a href='login.php'><i class='fa-sharp fa-solid fa-circle-xmark'></i><div class='aviso-modal'></a>" +
            "<div class='aviso-modal'> <p>Cancelado</p> <h2>No se concluyo la inscripcion al curso.</h2> </div> </div>");
        setTimeout(function () {
            $(".contenido-modal").remove();
            document.getElementById("ventana-modal").style.display = "none"
        }, 3000)
        console.log(data)
        if ("total" in sessionStorage)
            sessionStorage.removeItem("total")
        if ("curso" in sessionStorage)
            sessionStorage.removeItem("curso")
    },
    onApprove: function (data, actions) {
        return actions.order.capture().then(function (details) {
            console.log(details);
            
            $.ajax({
                url: '../php/Pagar.php',
                type: 'POST',
                data: {
                    total: details.purchase_units[0].amount.value,
                    status: details.status,
                    idcurso: _curso,
                    niveles: _niveles,
                    datos: details,
                    usuario: _usuario,
                    tipo: _tipo
                },
                success: function (response) {
                    document.getElementById("ventana-modal").style.display = "block"
                    $(".modal").append("<div class='contenido-modal'> <a href='login.php'><img src='../multmedia/logo.png' titlle='Inicio'></a>" +
                        "<div class='aviso-modal'> <p>Inscribir Curso </p> <h2>Inscripcion completa al curso</h2> </div> </div>")
                    setTimeout(function () {
                        $(".contenido-modal").remove();
                        window.location.href = "PaginaPrincipal.php";
                    }, 3000)
                },
                error: function () {
                    document.getElementById("ventana-modal").style.display = "block"
                    $(".modal").append("<div class='contenido-modal'> <a href='login.php'><i class='fa-sharp fa-solid fa-circle-xmark'></i><div class='aviso-modal'></a>" +
                        "<div class='aviso-modal'> <p>Error</p> <h2>Hubo un error al procesar el pago, intente de nuevo más tarde.</h2> </div> </div>");
                    setTimeout(function () {
                        $(".contenido-modal").remove();
                        document.getElementById("ventana-modal").style.display = "none"
                    }, 3000)
                }
            });
            if ("total" in sessionStorage)
                sessionStorage.removeItem("total")
            if ("curso" in sessionStorage)
                sessionStorage.removeItem("curso")
        });
    }
}).render('#paypal-button-container');

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
})