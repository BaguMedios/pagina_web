function validar_numero() {
    //etsa funcion se realizo para poder validar los numeros de celular en el formulario compuesto por un DOMContentLoaded que trae todo el DOM del documento
    //Despues se usa un evenlisener con input prara verificar que pasa dentorn del input y ejecutar nuestro codigo para verifficar
    document.addEventListener('DOMContentLoaded', () => {
        const telefonoInput = document.getElementById('num_colombia'); //input de numero en el formulario
        const botonEnviar = document.getElementById('button_enviar'); // boton para enviar el formulario
        const textoNumero = document.getElementById('texto_numero'); //texto que mostrara una advertencia si el numero esta mal

        telefonoInput.addEventListener('input', () => {
            const telefono = telefonoInput.value.trim(); //taremos el valor del input y quitamos sus espacios 

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

validar_numero(); //ejecutamos la funcion
