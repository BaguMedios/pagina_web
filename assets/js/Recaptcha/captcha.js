grecaptcha.ready(function() {
    grecaptcha.execute('6LefM9wAAAAAEDFD1OQOXD-HYhEc2_Q_0BYVkjU', {action: 'contact'}).then(function(token) {
        document.getElementById('g-recaptcha-response').value = token;
    });
});
