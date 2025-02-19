document.addEventListener("DOMContentLoaded", function() {
    grecaptcha.ready(function() {
        grecaptcha.execute('6LefM9wqAAAAAEDFD1OQOXD-HYhEc2_Q_0BYVkjU', {action: 'contacto'})
        .then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
        });
    });
});

document.querySelector("form").addEventListener("submit", function(event) {
    event.preventDefault(); // Detener el envío del formulario
    grecaptcha.execute('6LefM9wqAAAAAEDFD1OQOXD-HYhEc2_Q_0BYVkjU', {action: 'contacto'})
    .then(function(token) {
        document.getElementById('g-recaptcha-response').value = token;
        event.target.submit(); // Enviar el formulario después de actualizar el token
    });
});

console.log(document.getElementById('g-recaptcha-response').value);


