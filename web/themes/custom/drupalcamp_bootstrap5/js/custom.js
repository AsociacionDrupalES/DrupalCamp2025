/* document.addEventListener("DOMContentLoaded", function () {
    // Selección de elementos dentro del bloque por ID
    const blockElement = document.querySelector("#block-drupalcamp-bootstrap5-drupaliberia2025caceres");
  
    // Nos aseguramos de que el bloque exista en la página
    if (!blockElement) return;
  
    // Seleccionamos los elementos de texto dentro del bloque (h2 y h3)
    const titleElement = blockElement.querySelector("h2");
    const subTitleElement = blockElement.querySelector("h3");
  
    // Obtenemos el texto real de los elementos h2 y h3
    const titleText = titleElement.textContent.trim();  // Elimina posibles espacios extra al principio y al final
    const subTitleText = subTitleElement.textContent.trim();
  
    // Inicializamos el contenido de los elementos en vacío
    titleElement.textContent = '';
    subTitleElement.textContent = '';
  
    let titleIndex = 0;
    let subTitleIndex = 0;
  
    let interval = 100; // Velocidad de escritura
  
    // Función para escribir el texto del título (h2)
    function typeWriterTitle() {
      titleElement.textContent = titleText.substring(0, titleIndex);
      titleIndex++;
      if (titleIndex <= titleText.length) {
        setTimeout(typeWriterTitle, interval);
      } else {
        // Una vez que termine de escribir el título, escribe el subtítulo
        setTimeout(typeWriterSubTitle, 500); // Pausa antes de empezar con el subtítulo
      }
    }
  
    // Función para escribir el texto del subtítulo (h3)
    function typeWriterSubTitle() {
      subTitleElement.textContent = subTitleText.substring(0, subTitleIndex);
      subTitleIndex++;
      if (subTitleIndex <= subTitleText.length) {
        setTimeout(typeWriterSubTitle, interval);
      }
    }
  
    // Iniciar la animación de escritura con el título
    typeWriterTitle();
  }); */
  