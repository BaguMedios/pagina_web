grecaptcha.ready(function() {
    grecaptcha.execute('6LefM9wqAAAAAPyiWzloDFsDT8BQzSJvQ3RWNkqN', { action: 'contact' })
    .then(function(token) {
        const recaptchaResponse = document.getElementById('g-recaptcha-response');
        if (recaptchaResponse) {
            recaptchaResponse.value = token; // Asigna el token al campo oculto
        } else {
            console.error("El elemento 'g-recaptcha-response' no se encontró en el DOM.");
        }
    }).catch(function(error) {
        console.error("Error al ejecutar grecaptcha:", error);
    });
});
