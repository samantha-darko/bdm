function formatoFecha(fecha){
    // Fecha en formato "YYYY-MM-DD"
var fechaOriginal = fecha;

// Crear un objeto Date con la fecha original
var fecha = new Date(fechaOriginal);

// Obtener el día, mes y año de la fecha
var dia = fecha.getDate();
var mesNum = fecha.getMonth(); // Los meses en JavaScript son indexados desde 0
var anio = fecha.getFullYear();

// Array de nombres de los meses
var nombresMeses = [
  "enero",
  "febrero",
  "marzo",
  "abril",
  "mayo",
  "junio",
  "julio",
  "agosto",
  "septiembre",
  "octubre",
  "noviembre",
  "diciembre"
];

// Obtener el nombre del mes correspondiente al número
var mesLetras = nombresMeses[mesNum];

// Formatear la fecha en "día de mes de año"
var fechaFormateada = dia + " de " + mesLetras + " de " + anio;

return fechaFormateada

}

function VerificarSesion() {
    if (!("idusuario" in sessionStorage)) {
        window.location.href = "../paginas/IniciarSesion.php"
    } else {
        var urlActual = window.location.href;
        var url = new URL(urlActual);
        var Diploma = url.searchParams.get("Diploma");
        $.ajax({
            type: 'GET',
            url: '../php/Diploma.php?Diploma='+Diploma,
            success: function (resultado) {
                var res = JSON.parse(resultado)
                console.log(res)
                document.querySelector("#curso").innerHTML = res[2]
                fecha = formatoFecha(res[3])
                document.querySelector("#fechatermino").innerHTML = fecha
                document.querySelector("#alumno").innerHTML = res[4]
                document.querySelector("#maestro").innerHTML = res[5]
            }
        })
    }
}

document.addEventListener("DOMContentLoaded", VerificarSesion)

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