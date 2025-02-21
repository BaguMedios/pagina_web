function validar_numero() {
    document.addEventListener('DOMContentLoaded', () => {
        const telefonoInput = document.getElementById('num_colombia');
        const botonEnviar = document.getElementById('button_enviar');
        const textoNumero = document.getElementById('texto_numero');

        telefonoInput.addEventListener('input', () => {
            const telefono = telefonoInput.value.trim();

            // Expresión regular para números móviles y fijos colombianos
            const regexTelefonoColombiano = /^(3\d{9}|(60[1-8])?\d{7})$/;
            // Evitar secuencias repetitivas o números irreales
            const regexSecuenciaRepetitiva = /^(\d)\1*$/;


            if (regexTelefonoColombiano.test(telefono) && !regexSecuenciaRepetitiva.test(telefono)) {
                console.log("Número válido");
                textoNumero.style.display = 'none'; // Ocultar mensaje de error
                botonEnviar.disabled = false; // Habilitar el botón
                botonEnviar.innerText = 'CONTACTANOS AHORA';
            } else {
                console.log("Número inválido");
                textoNumero.style.display = 'block'; // Mostrar mensaje de error
                botonEnviar.disabled = true; // Deshabilitar el botón
                botonEnviar.innerText = 'EL NUMERO NO ES VALIDO';
            }
        });
    });
}

validar_numero();
