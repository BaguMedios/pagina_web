function validate(e) {
    e.preventDefault();
    grecaptcha.enterprise.ready(async () => {
        const token = await grecaptcha.enterprise.execute('6LckMGQqAAAAADV3aj7WV-llXPXPYGMavymV7PxS', {action: 'LOGIN'});
    });
}