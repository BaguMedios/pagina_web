 // Inicializar el canvas con fondo transparente para ver el fondo asignado
  let canvas = new fabric.Canvas('productCanvas', {
    width: 300,
    height: 300,
    backgroundColor: 'transparent'
  });

  // Función para cargar la imagen del producto como fondo del canvas
  function loadProductBackground(url) {
    fabric.Image.fromURL(url, function(img) {
      // Escalar la imagen del producto para que se ajuste al canvas
      let scaleX = canvas.width / img.width;
      let scaleY = canvas.height / img.height;
      canvas.setBackgroundImage(img, canvas.renderAll.bind(canvas), {
        scaleX: scaleX,
        scaleY: scaleY
      });
    }, { crossOrigin: 'anonymous' });
  }

  // Cargar el fondo del producto seleccionado (por defecto, el primer valor)
  loadProductBackground(document.getElementById("productSelect").value);

  // Actualizar el fondo al cambiar la selección del producto
  document.getElementById("productSelect").addEventListener("change", function() {
    loadProductBackground(this.value);
    // Opcional: eliminar la imagen subida si se desea reiniciar el diseño
    canvas.getObjects().forEach(function(obj) {
      if (obj.customType === 'userImage') {
        canvas.remove(obj);
      }
    });
  });

  // Manejar la carga de la imagen del usuario
  document.getElementById("imageInput").addEventListener("change", function(event) {
    let file = event.target.files[0];
    if (file) {
      let reader = new FileReader();
      reader.onload = function(e) {
        fabric.Image.fromURL(e.target.result, function(img) {
          // Eliminar imágenes previas subidas
          canvas.getObjects().forEach(function(obj) {
            if (obj.customType === 'userImage') {
              canvas.remove(obj);
            }
          });
          // Configurar la imagen del usuario: 
          // - Se centra en el canvas (usando originX/originY: 'center')
          // - Se escala para que tenga un ancho de 150px (manteniendo proporción)
          img.set({
            originX: 'center',
            originY: 'center',
            left: canvas.getWidth() / 2,
            top: canvas.getHeight() / 2,
            selectable: true,
            customType: 'userImage'
          });
          let scaleFactor = 150 / img.width;
          img.scale(scaleFactor);
          
          // Si el producto seleccionado es un vaso, aplicar un efecto para simular la curvatura
          let selectedProduct = document.getElementById("productSelect").value;
          if (selectedProduct.includes("cup.png")) {
            // Por ejemplo, aplicar un skew horizontal. Ajusta el valor según lo que necesites.
            img.set('skewX', 150);
          }
          
          canvas.add(img);
          canvas.renderAll();
        }, { crossOrigin: 'anonymous' });
      };
      reader.readAsDataURL(file);
    }
  });

  // Manejar la descarga del diseño compuesto (producto + imagen)
  document.getElementById("saveImage").addEventListener("click", function() {
    let dataURL = canvas.toDataURL("image/png");
    let a = document.createElement("a");
    a.href = dataURL;
    a.download = "mi_diseño.png";
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
  });