// Función para validar el número de teléfono
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
                textoNumero.style.display = 'none';
                botonEnviar.disabled = false;
                botonEnviar.innerText = 'CONTACTANOS AHORA';
            } else {
                console.log("Número inválido");
                textoNumero.style.display = 'block';
                botonEnviar.disabled = true;
                botonEnviar.innerText = 'EL NUMERO NO ES VALIDO';
            }
        });
    });
}


// Ejecutamos las funciones
validar_numero();
