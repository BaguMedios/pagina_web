    // Inicializa el mapa 
    var map = L.map('map').setView([4.60971, -74.08175], 13); // Ejemplo: Bogotá
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '© OpenStreetMap'
    }).addTo(map);

    // Capa para almacenar los elementos dibujados
    var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);

    // Configura el control de dibujo para círculos
    var drawControl = new L.Control.Draw({
        edit: {
            featureGroup: drawnItems
        },
        draw: {
            circle: true,       // Habilitamos solo círculos
            polygon: false,
            polyline: false,
            rectangle: false,
            marker: false,
            circlemarker: false
        }
    });
    map.addControl(drawControl);



    // Ocultar el tooltip después de 10 segundos
    setTimeout(function(){
        var tooltip = document.getElementById("map-tooltip");

        if(tooltip) {
            tooltip.style.display = 'none';
        }
    }, 10000);

    // Evento al terminar de dibujar
    map.on(L.Draw.Event.CREATED, function (event) {
        var layer = event.layer;
        drawnItems.addLayer(layer);

        // Obtener el centro del círculo
        var center = layer.getLatLng();
        
        // Realizar reverse geocoding para determinar la localidad (utilizando Nominatim)
        var url = "https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=" +
                    center.lat + "&lon=" + center.lng;
        
        fetch(url)
            .then(response => response.json())
            .then(data => {
                // Buscamos la localidad en la respuesta (suburb, neighbourhood, city_district, o city)
                let localidad = data.address.suburb || data.address.neighbourhood || data.address.city_district || data.address.city || "desconocido";
                localidad = localidad.toLowerCase(); // Estandarizamos la localidad
                document.getElementById("localidad").value = localidad;
                console.log("Localidad detectada: " + localidad);
            })
            .catch(error => console.error("Error en reverse geocoding:", error));
    });