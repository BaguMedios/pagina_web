    // Actualiza el valor mostrado en tiempo real
    const rangeInput = document.getElementById('volanteadores');
    const rangeValue = document.getElementById('volanteadoresValue');

    rangeInput.addEventListener('input', function() {
        rangeValue.textContent = this.value;
    });