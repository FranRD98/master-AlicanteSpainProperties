// PRECIOS PARA ALQUILERES
var preciosAlquiler = [
    { value: "200", text: "200 €" },
    { value: "400", text: "400 €" },
    { value: "600", text: "600 €" },
    { value: "800", text: "800 €" },
    { value: "1000", text: "1.000 €" },
    { value: "1200", text: "1.200 €" },
    { value: "1400", text: "1.400 €" },
    { value: "1600", text: "1.600 €" },
    { value: "1800", text: "1.800 €" },
    { value: "2000", text: "2.000 €" },
    { value: "3000", text: "3.000 €" },
];

// PRECIOS PARA VENTA
var preciosVenta = [
    // { value: "25000", text: "25.000 €" },
    // { value: "50000", text: "50.000 €" },
    // { value: "75000", text: "75.000 €" },
    { value: "100000", text: "100.000 €" },
    { value: "125000", text: "125.000 €" },
    { value: "150000", text: "150.000 €" },
    { value: "175000", text: "175.000 €" },
    { value: "200000", text: "200.000 €" },
    { value: "225000", text: "225.000 €" },
    { value: "250000", text: "250.000 €" },
    { value: "275000", text: "275.000 €" },
    { value: "300000", text: "300.000 €" },
    { value: "350000", text: "350.000 €" },
    { value: "400000", text: "400.000 €" },
    { value: "450000", text: "450.000 €" },
    { value: "500000", text: "500.000 €" },
    { value: "550000", text: "550.000 €" },
    { value: "600000", text: "600.000 €" },
    { value: "650000", text: "650.000 €" },
    { value: "700000", text: "700.000 €" },
    { value: "800000", text: "800.000 €" },
    { value: "900000", text: "900.000 €" },
    { value: "1000000", text: "1.000.000 €" },
    { value: "1250000", text: "1.250.000 €" },
    { value: "1000000", text: "1.500.000 €" },
    { value: "1750000", text: "1.750.000 €" },
    { value: "2000000", text: "2.000.000 €" }
];
var preciosVentaHasta = [
    // { value: "25000", text: "25.000 €" },
    // { value: "50000", text: "50.000 €" },
    // { value: "75000", text: "75.000 €" },
    { value: "100000", text: "100.000 €" },
    { value: "125000", text: "125.000 €" },
    { value: "150000", text: "150.000 €" },
    { value: "175000", text: "175.000 €" },
    { value: "200000", text: "200.000 €" },
    { value: "225000", text: "225.000 €" },
    { value: "250000", text: "250.000 €" },
    { value: "275000", text: "275.000 €" },
    { value: "300000", text: "300.000 €" },
    { value: "350000", text: "350.000 €" },
    { value: "400000", text: "400.000 €" },
    { value: "450000", text: "450.000 €" },
    { value: "500000", text: "500.000 €" },
    { value: "550000", text: "550.000 €" },
    { value: "600000", text: "600.000 €" },
    { value: "650000", text: "650.000 €" },
    { value: "700000", text: "700.000 €" },
    { value: "800000", text: "800.000 €" },
    { value: "900000", text: "900.000 €" },
    { value: "1000000", text: "1.000.000 €" },
    { value: "1250000", text: "1.250.000 €" },
    { value: "1000000", text: "1.500.000 €" },
    { value: "1750000", text: "1.750.000 €" },
    { value: "2000000", text: "+2.000.000 €" }
];

// PRECIOS PARA TODOS LOS ESTATUS



function printOptionSelect (optionText, selectSelected, optionValue){
    if( selectSelected == optionValue ) {
        return '<option value="'+optionValue+'" selected>' + optionText + '</option>';
    } else {
        return '<option value="'+optionValue+'">' + optionText + '</option>';
    }
}

function returnPrices(seleccionado, alquiler, venta, texto, mas) {

    if (mas == 1) {
        var preciosTodos = preciosAlquiler.concat(preciosVentaHasta);
        // Introducimos el primer option con el valor vacío
        var returnStr = printOptionSelect(texto, seleccionado, "");

        if (alquiler == 1 && venta == 1 ) { // ALL
            for (var i = 0; i < preciosTodos.length; i++) {
                returnStr += printOptionSelect(preciosTodos[i].text, seleccionado, preciosTodos[i].value);
            }
        } else if (alquiler == 0 && venta == 0 ) { // NONE
            for (var i = 0; i < preciosVentaHasta.length; i++) {
                returnStr += printOptionSelect(preciosVentaHasta[i].text, seleccionado, preciosVentaHasta[i].value);
            }
        } else if (alquiler == 1 ) { // RENTAL
            for (var i = 0; i < preciosAlquiler.length; i++) {
                returnStr += printOptionSelect(preciosAlquiler[i].text, seleccionado, preciosAlquiler[i].value);
            }
        } else if (venta == 1 ) { // SALE
            for (var i = 0; i < preciosVentaHasta.length; i++) {
                returnStr += printOptionSelect(preciosVentaHasta[i].text, seleccionado, preciosVentaHasta[i].value);
            }
        }
    } else {
        var preciosTodos = preciosAlquiler.concat(preciosVenta);
        // Introducimos el primer option con el valor vacío
        var returnStr = printOptionSelect(texto, seleccionado, "");

        if (alquiler == 1 && venta == 1 ) { // ALL
            for (var i = 0; i < preciosTodos.length; i++) {
                returnStr += printOptionSelect(preciosTodos[i].text, seleccionado, preciosTodos[i].value);
            }
        } else if (alquiler == 0 && venta == 0 ) { // NONE
            for (var i = 0; i < preciosVenta.length; i++) {
                returnStr += printOptionSelect(preciosVenta[i].text, seleccionado, preciosVenta[i].value);
            }
        } else if (alquiler == 1 ) { // RENTAL
            for (var i = 0; i < preciosAlquiler.length; i++) {
                returnStr += printOptionSelect(preciosAlquiler[i].text, seleccionado, preciosAlquiler[i].value);
            }
        } else if (venta == 1 ) { // SALE
            for (var i = 0; i < preciosVenta.length; i++) {
                returnStr += printOptionSelect(preciosVenta[i].text, seleccionado, preciosVenta[i].value);
            }
        }
    }

    // Introducimos el primer option con el valor vacío
    // var returnStr = printOptionSelect(texto, seleccionado, "");

    // if (alquiler == 1 && venta == 1 ) { // ALL
    //     for (var i = 0; i < preciosTodos.length; i++) {
    //         returnStr += printOptionSelect(preciosTodos[i].text, seleccionado, preciosTodos[i].value);
    //     }
    // } else if (alquiler == 0 && venta == 0 ) { // NONE
    //     for (var i = 0; i < preciosVenta.length; i++) {
    //         returnStr += printOptionSelect(preciosVenta[i].text, seleccionado, preciosVenta[i].value);
    //     }
    // } else if (alquiler == 1 ) { // RENTAL
    //     for (var i = 0; i < preciosAlquiler.length; i++) {
    //         returnStr += printOptionSelect(preciosAlquiler[i].text, seleccionado, preciosAlquiler[i].value);
    //     }
    // } else if (venta == 1 ) { // SALE
    //     for (var i = 0; i < preciosVenta.length; i++) {
    //         returnStr += printOptionSelect(preciosVenta[i].text, seleccionado, preciosVenta[i].value);
    //     }
    // }

    return returnStr;
}
