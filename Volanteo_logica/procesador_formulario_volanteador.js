document.getElementById("volanteoForm").addEventListener("submit", function (e) {
    e.preventDefault();

    const localidad = document.getElementById("localidad").value;
    const volanteadores = document.getElementById("volanteadores").value;
    const resultado = document.getElementById('resultadoCheck');
    const mapa = document.querySelector('.mapas');
    console.log(`Se envió un formulario con la localidad: ${localidad}`);
    console.log(`Se envió un formulario con el número de volanteadores: ${volanteadores}`);

    if (!localidad) {
        alert("Primero selecciona una localidad para continuar");
        return;
    }

    // Llamada a la API con los parámetros
    fetch(`./Volanteo_logica/api.php?localidad=${encodeURIComponent(localidad)}&volanteadores=${volanteadores}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                document.getElementById("resultado").innerHTML = `<p>${data.error}</p>`;
            } else {
                //mostramos los datos
                resultado.style.display = 'grid';
                resultado.style.filter = 'blur(10px)';
                mapa.style.display = 'block';
                mapa.style.filter = 'blur(10px)';
                document.getElementById('resultadoTitulo').innerHTML = `${data.localidad}`;
                document.getElementById('resultadoEfectividad').innerHTML = `${data.data.efectividad}%`;
                document.getElementById('resultadoVolantes').innerHTML = `${data.data.volantes_recomendados}`;
                document.getElementById('resultadoDescripcion').innerHTML = `${data.data.descripcion}`;
                document.getElementById('valorVolanteador').innerHTML = `EFECTIVIDAD (con <strong>${volanteadores}</strong> Volanteadores): `
            }
        })
        .catch(error => console.error("Error al consultar la API:", error));
});
