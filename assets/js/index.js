document.addEventListener("DOMContentLoaded", function () {
    const mostrar = document.getElementById("lottie_carga");
    const boton = document.getElementById("button_enviar");

    boton.addEventListener("click", function () {
        mostrar.style.display = "block";
        // Ocultarlo después de 7 segundos (7000 milisegundos)
        setTimeout(function () {
            mostrar.style.display = "none";
        }, 10000);
    });
});
