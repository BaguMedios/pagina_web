    document.getElementById("volanteoForm").addEventListener("submit", function(e) {
        e.preventDefault();

        const localidad = document.getElementById("localidad").value;
        const volanteadores = document.getElementById("volanteadores").value;

        if (!localidad) {
        alert("Primero dibuja en el mapa para detectar la localidad.");
        return;
        }

        // Llamada a la API con los parámetros
        fetch(`api.php?localidad=${encodeURIComponent(localidad)}&volanteadores=${volanteadores}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
            document.getElementById("resultado").innerHTML = `<p>${data.error}</p>`;
            } else {
            document.getElementById("resultado").innerHTML = `
                <h3>Resultados para ${data.localidad}</h3>
                <p>Efectividad: ${data.data.efectividad}%</p>
                <p>Volantes Recomendados por dia: ${data.data.volantes_recomendados}</p>
                <p>Descripción: ${data.data.descripcion}</p>
            `;
            }
        })
        .catch(error => console.error("Error al consultar la API:", error));
    });