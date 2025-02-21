document.addEventListener('DOMContentLoaded', function() {
    grecaptcha.ready(function() {
        grecaptcha.execute('6LefM9wqAAAAAEDFD1OQOXD-HYhEc2_Q_0BYVkjU', { action: 'contact' })
        .then(function(token) {
            const recaptchaResponse = document.getElementById('g-recaptcha-response');
            if (recaptchaResponse) {
                recaptchaResponse.value = token; // Asigna el token al campo oculto
            } else {
                console.error("El elemento 'g-recaptcha-response' no se encontró en el DOM.");
                console.log/("el token no fue incluido")
            }
        }).catch(function(error) {
            console.error("Error al ejecutar grecaptcha:", error);
        });
    });
});

