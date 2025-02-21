document.addEventListener("DOMContentLoaded", function () {
    const mostrar = document.getElementById("lottie_carga");
    const boton = document.getElementById("button_enviar");
    const spinner = document.getElementById("spinner_contact");
    const formulario = document.getElementById("form_bagu");

    boton.addEventListener("click", function () {
        if(formulario.checkValidity()){
            mostrar.style.display = "block";    // Muestra la animación lottie
            spinner.style.display = "block"; // Muestra el spinner
            boton.disabled = true; // Deshabilita el botón en lugar de ocultarlo
            boton.innerText = "Enviando..."; // Cambia el texto del botón (opcional)
    
            // Ocultar después de 10 segundos (10000 ms)
            setTimeout(function () {
                mostrar.style.display = "none";
                spinner.style.display = "none";
                boton.disabled = false; // Habilita el botón nuevamente
                boton.innerText = "CONTACTANOS AHORA"; // Restaura el texto del botón
            }, 10000);

            formulario.submit();
        }else{
            console.log("no esta completo el formulario");
        }
    });
});

