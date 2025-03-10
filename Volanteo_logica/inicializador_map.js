 // Inicializa el mapa en Bogotá
var map = L.map('map').setView([4.60971, -74.08175], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '© OpenStreetMap'
}).addTo(map);

// Variable global para almacenar el polígono de la localidad (si existe)
var localityLayer;

// Función para dibujar el polígono de la localidad
function drawLocalityBoundary(localidad) {
  // Elimina el polígono anterior, si existe
  if (localityLayer) {
    map.removeLayer(localityLayer);
  }
  
  // Llamada a la API de Nominatim para obtener los límites de la localidad (con polygon_geojson)
  var searchUrl = 'https://nominatim.openstreetmap.org/search?format=json&polygon_geojson=1&q=' 
                  + encodeURIComponent(localidad);
  
  fetch(searchUrl)
    .then(response => response.json())
    .then(results => {
      if (results && results.length > 0) {
        // Tomamos el primer resultado
        var result = results[0];
        if (result.geojson) {
          // Creamos una capa GeoJSON con un estilo personalizado (puedes ajustar los estilos a tu gusto)
          localityLayer = L.geoJSON(result.geojson, {
            style: function (feature) {
              return {
                color: '#ff7800',       // Color del borde
                weight: 2,              // Ancho del borde
                fillColor: '#fffc00',    // Color de relleno
                fillOpacity: 0.5,        // Opacidad del relleno
                dashArray: '5, 10'       // Patrón de guiones en el borde
              };
            }
          }).addTo(map);
          // Opcional: ajustar la vista del mapa para que se muestre todo el polígono
          map.fitBounds(localityLayer.getBounds());
        } else {
          console.error("No se encontró un GeoJSON para la localidad: " + localidad);
        }
      } else {
        console.error("No se encontró la localidad en Nominatim: " + localidad);
      }
    })
    .catch(error => console.error("Error al obtener el polígono:", error));
}

document.getElementById("volanteoForm").addEventListener("submit", function(e) {
  e.preventDefault();
  
  const localidad = document.getElementById("localidad").value;
  
  // Aquí, usamos la localidad seleccionada para dibujar su límite en el mapa.
  // Es importante que el value en el select sea idéntico al usado en la API,
  // por ejemplo: "localidad usaquén", "localidad chapinero", etc.
  drawLocalityBoundary(localidad);
});
