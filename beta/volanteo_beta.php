<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volanteo Beta</title>
    <!-- Incluye en tu HTML los CSS y JS necesarios para Leaflet y Leaflet.draw -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>
</head>
<body>
    <section id="formulario_mapa">

    <form id="volanteoForm">
        <!-- Campo oculto que se llenará con la localidad detectada -->
        <input type="hidden" id="localidad" name="localidad">
        
        <!-- Input numérico para la cantidad de volanteadores -->
        <label for="volanteadores">Número de volanteadores:</label>
        <input type="number" id="volanteadores" name="volanteadores" min="1" value="1" required>

        <button type="submit">Calcular Efectividad</button>
    </form>

    <div id="resultado"></div>

    <!-- Contenedor del mapa -->
    <div id="map" style="width: 100%; height: 400px;">
        <div id="map-tooltip">Hola</div>
    </div>
    </section>

    <script src="./procesador_formulario_volanteador.js"></script>
    <script src="./inicializador_map.js"></script>
</body>
</html>