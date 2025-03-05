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

// Función para validar la descripción
function ValidarDescripcion() {
    document.addEventListener('DOMContentLoaded', () => {
        const descripcion = document.getElementById('informacio_usuario');
        const botonEnviar = document.getElementById('button_enviar');

        // Palabras prohibidas, incluyendo errores ortográficos comunes
        const palabrasProhibidas = [
            'trabajo', 'trabajar','trabaja', 'travajo', 'trabaho', 'travajito', 'trabajito',
            'empleo', 'empleyo', 'emplebo', 'oportunidad laboral', 
            'camello', 'cameyo', 'camelo', 'chamba', 'chambita',
            'contratación', 'vacante', 'bacante', 'reclutamiento', 
            'busco empleo', 'busco travajo', 'oferta laboral', 
            'oferta de trabajo', 'oportunidad de trabajo', 
            'quiero trabajar', 'kiero trabajar', 'necesito empleo', 
            'necesito travajo', 'me postulo', 'me postullo', 
            'enviar hoja de vida', 'enviar cv', 'curriculum', 
            'curriculum vitae', 'curriculo', 'oferta de empleo', 
            'ofertas laborales', 'plaza laboral', 'ofertas de trabajo', 
            'trabajar con ustedes', 'trabajar con ustedez', 
            'emplearme', 'emplearme con ustedes', 'emplearme en su empresa', 
            'trabajo disponible', 'travajo disponible', 
            'estoy buscando empleo', 'estoy bucando travajo', 
            'dame trabajo', 'dame travajo', 'necesito un camello', 
            'quiero un camello', 'trabajo en su empresa', 
            'travajo en su empresa', 'quiero un empleo', 
            'quiero un travajo', 'estoy sin trabajo', 'sin empleo', 
            'laboralmente', 'buscando una oportunidad de trabajo', 
            'buscando un empleo', 'quiero ser parte de su equipo', 
            'me gustaría aplicar', 'me gustaria aplicar', 
            'me interesa la vacante', 'me interesa la bacante', 
            'posición laboral', 'posición de trabajo', 
            'abierto a oportunidades laborales', 'aplicar a un empleo', 
            'postularme', 'solicitud de empleo', 
            'enviar mi cv', 'enviar mi hoja de vida', 
            'enviar mi currículum', 'trabajo formal', 'travajo formal',
            'necesito trabajar', 'necesito travajar', 
            'trabajo urgente', 'travajo urgente', 'trabajo temporal', 
            'travajo temporal', 'trabajo fijo', 'travajo fijo', 
            'buscando ingresos', 'generar ingresos', 'trabajo por horas', 
            'empleo a medio tiempo', 'empleo a tiempo completo', 
            'empleo freelance', 'trabajo freelance', 'trabajo remoto', 
            'teletrabajo', 'necesito una oportunidad', 
            'propuesta laboral', 'propuesta de empleo', 
            'me gustaría colaborar', 'trabajo inmediato', 
            'busco una chamba', 'estoy desempleado', 
            'necesito un ingreso', 'necesito un salario', 
            'salario fijo', 'salario mensual', 'inserción laboral', 
            'me gustaría formar parte del equipo', 'trabajo eventual', 
            'busco estabilidad económica', 'me urge trabajar', 
            'me urge travajar', 'necesito generar ingresos'
        ];

        // Expresiones regulares con tolerancia a saludos y rellenos
        const patronesSospechosos = [
            /\b(buenas|hola|saludos|buenos días|buenas tardes|buenas noches)?\s*(quiero|busco|necesito|me gustaría|me gustaria)\s*(una|un)?\s*(oportunidad|trabajo|empleo|camello|chamba|trabajar)/i,
            /\b(oportunidad|propuesta)\s*(laboral|de empleo|de trabajo)/i,
            /\b(deseo|me interesa|me gustaría|me gustaria)\s*(trabajar|aplicar|colaborar)/i
        ];

        // Función para normalizar texto eliminando tildes y caracteres especiales
        function normalizarTexto(texto) {
            return texto
                .toLowerCase()
                .normalize("NFD")
                .replace(/[\u0300-\u036f]/g, ""); // Elimina tildes y diacríticos
        }

        descripcion.addEventListener('input', () => {
            const texto = normalizarTexto(descripcion.value.trim());

            // Comprobar si alguna palabra prohibida está presente en el texto
            const contienePalabraProhibida = palabrasProhibidas.some(palabra => texto.includes(normalizarTexto(palabra)));

            // Comprobar si el texto coincide con algún patrón sospechoso
            const contienePatronSospechoso = patronesSospechosos.some(patron => patron.test(texto));

            if (contienePalabraProhibida || contienePatronSospechoso) {
                botonEnviar.innerText = "No puede enviar solicitudes de empleo y no seran procesadas ni tomadas en cuenta anque lo envie";
                botonEnviar.disabled = true;
                botonEnviar.style.background = "gray";
            } else {
                botonEnviar.innerText = "CONTACTANOS AHORA";
                botonEnviar.disabled = false;
                botonEnviar.style.background = "#E62168";
            }
        });
    });
}



// Ejecutamos las funciones
validar_numero();
ValidarDescripcion();
