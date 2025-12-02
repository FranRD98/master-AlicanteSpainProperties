<?php

// AÑADIR AL ARRAY:
// array(
    // "FeatureId" => 30,					// Hay que ver https://api.inmofactory.com/Help/Misc/DictionariesFeatures
    // "LanguageId" => 4,					// Id del idioma ::DIC_Language
    // Habría que seleccionar uno de estos tipos:
    // "DecimalValue" => 4,				// **OPCIONAL** 'DecimalValue', 'List' or 'Multiple'
    // "BoolValue" => true,				// **OPCIONAL** Si es un Booleano
    // "DateValue" => "",				// **OPCIONAL** Si es una fecha
    // "TextValue" => "",				// **OPCIONAL** Posibilidad multiples items
// ),

$fotocasa_features = array(
    "1" => "Superfície", // OBLIGATORIA
    "2" => "Descripción abreviada", // COMÚN
    "3" => "Descripción extendida", // COMÚN
    "4" => "Ocultar superfície", // COMÚN
    "10" => "Nombre del edificio", // LOCAL | OFICINA
    "11" => "Núm habitaciones",
    "12" => "Núm baño",
    "13" => "Núm aseo",
    "14" => "Núm. despacho", // OFICINA | INDUSTRIAL
    "15" => "Núm. plazas hoteleras", // HOTEL
    "17" => "Tipo de plaza", // PARKING
    "18" => "Tipo de nave", // INDUSTRIAL
    "20" => "Edificio uso", // EDIFICIO
    "21" => "Uso admnitido", // SUELO
    "22" => "Ascensor", // PISO | LOCAL | OFICINA
    "23" => "Párking",
    "24" => "Trastero",
    "25" => "Piscina",
    "26" => "Jardín", // CASA
    "27" => "Terraza",
    "28" => "Orientación",
    "29" => "Calefacción",
    "30" => "Amueblado",
    "69" => "Superfície solar", // CASA | EDIFICIO | INDUSTRIAL
    "142" => "Domótica",
    "152" => "Alarma individual en trastero", // TRASTERO
    "153" => "Sistema de vídeo vigilancia cctv 24h", // TRASTERO
    "171" => "Ascensor", // CASA
    "248" => "Clasificación",
    "249" => "Conservación",
    "254" => "Aire acondicionado",
    "255" => "Nombre de finca", // SUELO
    "257" => "Lavadero",
    "258" => "Armarios",
    "259" => "Electrodomésticos",
    "260" => "Suite con baño",
    "263" => "Patio",
    "266" => "Sólo chicas",
    "267" => "Sólo chicos",
    "268" => "Sólo no fumadores",
    "269" => "Se requiere menos de dos meses de fianza",
    "272" => "Sistema de seguridad / vigilancia", // PARKING
    "273" => "Cuarto para personal de servicio",
    "274" => "Jacuzzi",
    "275" => "Bodega",
    "276" => "Casa de invitados",
    "277" => "Sauna",
    "278" => "Baño de huéspedes",
    "279" => "Muebles de diseño",
    "280" => "Sala de cine",
    "281" => "Cuarto de lavado y plancha",
    "282" => "Música ambiental",
    "283" => "Porche cubierto",
    "284" => "Primera línea de mar",
    "285" => "Vistas a la montaña",
    "286" => "Internet",
    "287" => "Microondas",
    "288" => "Horno",
    "289" => "Cocina office",
    "290" => "Parquet",
    "291" => "Televisión",
    "292" => "Nevera",
    "293" => "Lavadora",
    "294" => "Puerta blindada",
    "295" => "Gres / cerámica",
    "296" => "Calefacción",
    "297" => "Balcones",
    "298" => "Jardín privado",
    "300" => "Piscina comunitaria",
    "301" => "Zona comunitaria",
    "302" => "Zona deportiva",
    "303" => "Zona infantil",
    "304" => "Energía solar",
    "305" => "Párking comunitario",
    "306" => "Conserje",
    "307" => "Vídeo portero",
    "308" => "Ascensor interior",
    "309" => "Gimnasio",
    "310" => "Pista de tenis",
    "311" => "Salida de humos",  // LOCAL
    "312" => "Salida de humos",  // PARKING
    "313" => "Se aceptan mascotas",
    "314" => "Cocina equipada",
    "315" => "Con vistas al mar",
    "316" => "No amueblado",
    "317" => "Certificado energético",
    "318" => "Número de registro de turismo",
    "320" => "Calefacción",
    "321" => "Agua caliente sanitaria",
);

// Orientación
$fotocasa_orientacion = array(
    "1" => "Noreste",
    "2" => "Oeste",
    "3" => "Norte",
    "4" => "Suroeste",
    "5" => "Este",
    "6" => "Sureste",
    "7" => "Noroeste",
    "8" => "Sur",
);

// Conservación
$fotocasa_conservacion = array(
    "1" => "Buena",
    "2" => "Muy buena",
    "3" => "Excelente",
    "4" => "Regular",
    "5" => "Necesita reforma",
);

// Certificado energético
$fotocasa_certificado_energetico = array(
    "1" => "A",
    "2" => "B",
    "3" => "C",
    "4" => "D",
    "5" => "E",
    "6" => "F",
    "7" => "G",
    "8" => "En trámite",
    "9" => "Exento",
);

// Calefacción
$fotocasa_calefaccion = array(
    "1" => "Gas natural",
    "2" => "Electricidad",
    "3" => "Gasóleo",
    "4" => "Butano",
    "5" => "Propano",
    "6" => "Solar",
);

// Agua caliente sanitaria
$fotocasa_agua_caliente = array(
    "1" => "Gas natural",
    "2" => "Electricidad",
    "3" => "Gasóleo",
    "4" => "Butano",
    "5" => "Propano",
    "6" => "Solar",
);

// Edificio uso
$fotocasa_edificio_uso = array(
    "1" => "Industrial",
    "2" => "Mixto",
    "3" => "Oficinas",
    "4" => "Semi industrial",
    "5" => "Viviendas",
);

// Suelo
$fotocasa_uso_admitido = array(
    "1" => "Uso agrícola",
    "2" => "Uso comercial",
    "3" => "Uso equipamientos asistenciales",
    "4" => "Uso equipamientos culturales",
    "5" => "Uso equipamientos deportivos",
    "6" => "Uso industrial (menos 15cv y 45 db)",
    "7" => "Uso industrial general",
    "8" => "Uso residencial plurifamiliar",
    "9" => "Uso residencial unifamiliar aislada",
);

// Tipo de plaza
$fotocasa_tipo_plaza = array(
    "1" => "Plaza box",
    "2" => "Plaza coche + moto",
    "3" => "Plaza doble",
    "4" => "Plaza exterior",
    "5" => "Plaza fija",
    "6" => "Plaza grande",
    "7" => "Plaza mediana",
    "8" => "Plaza moto",
    "9" => "Plaza muy grande",
    "10" => "Plaza no fija",
    "11" => "Plaza pequeña",
);

// Clasificiación
$fotocasa_clasificacion = array(
    "1" => "1 Estrella",
    "2" => "2 Estrellas",
    "3" => "3 Estrellas",
    "4" => "4 Estrellas",
    "5" => "5 Estrellas",
    "6" => "5 Estrellas Gran lujo",
    "7" => "5 Estrellas lujo",
    "8" => "Sin categoría",
);
