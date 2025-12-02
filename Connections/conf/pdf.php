<?php
/*******************************
**  Configuración del PDF  **
******************************/

$urlwebsite = "www.website.immo"; //para los pdf (así evitamos que aparezca la url de test en el pdf)

//ajustar los colores usando los de la web (el secondary se usa especialmente para el texto del footer)
$maincolorPDF = "#004484";
$secondarycolorPDF = "#fff";

// Teléfonos:
// Se usará el $telefonoEmpresa para mostrar el teléfono en el PDF
// El teléfono que se usa para whatsapp es el $phoneRespBar. Tenerlo en cuenta.

//seleccionar entre LG y XL el que se ajuste según las proporciones de las fotos del diseño
$tamanyoImgPDF = "xl";
//el logo que se va a usar en el header del pdf. Según el tamaño del logotipo y la relación de aspecto que tenga tocará mover un poco a izquierda o derecha la cabecera. USAR VERSION @3x
$pdfLogo = '/media/images/website/website-logo.png'; //preferible usar el tamaño @2x que exporta zeplin 