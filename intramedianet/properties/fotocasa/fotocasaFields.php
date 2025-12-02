<?php
return array(
    "318" => array(
        "name" => __('Nº Registro Turismo', 1),
        "comment" => __('Requerido para Alq. Vacacional.', 1),
        "type" => "int",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
            "TransactionTypeId" => array(8),
        ),
    ),
    "10" => array(
        "name" => __('Nombre del edificio', 1),
        "comment" => __('En caso de ser local, oficina, etc.', 1),
        "type" => "text",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(3, 4, 5, 10, 12),
        ),
    ),
    "20" => array(
        "name" => __('Edificio uso', 1),
        "type" => "list",
        "show" => 1,
        "options" => array(
            "1" => __("Industrial", 1),
            "2" => __("Mixto", 1),
            "3" => __("Oficinas", 1),
            "4" => __("Semi industrial", 1),
            "5" => __("Viviendas", 1),
        ),
        "showOn" => array(
            "TypeId" => array(5),
        ),
    ),
    "14" => array(
        "name" => __('Nº. despachos', 1),
        "comment" => __('Para Oficinas.', 1),
        "type" => "int",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(4,7),
        ),
    ),
    "15" => array(
        "name" => __('Nº. plazas hoteleras', 1),
        "comment" => __('Para Hoteles.', 1),
        "type" => "int",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(10),
        ),
    ),
    "255" => array(
        "name" => __('Nombre de finca', 1),
        "comment" => __('Para Suelo.', 1),
        "type" => "text",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(6),
        ),
    ),
    "21" => array(
        "name" => __('Uso admnitido', 1),
        "comment" => __('Para Suelo.', 1),
        "type" => "list",
        "show" => 1,
        "options" => array(
            "1" => __('Uso agrícola', 1),
            "2" => __('Uso comercial', 1),
            "3" => __('Uso equipamientos asistenciales', 1),
            "4" => __('Uso equipamientos culturales', 1),
            "5" => __('Uso equipamientos deportivos', 1),
            "6" => __('Uso industrial (menos 15cv y 45 db)', 1),
            "7" => __('Uso industrial general', 1),
            "8" => __('Uso residencial plurifamiliar', 1),
            "9" => __('Uso residencial unifamiliar aislada', 1),
        ),
        "showOn" => array(
            "TypeId" => array(6),
        ),
    ),
    "249" => array(
        "name" => __('Conservación', 1),
        "type" => "list",
        "show" => 1,
        "options" => array(
            "1" => __('Buena', 1),
            "2" => __('Muy buena', 1),
            "3" => __('Excelente', 1),
            "4" => __('Regular', 1),
            "5" => __('Necesita reforma', 1),
        ),
        "showOn" => array(
            "TypeId" => array(1,2,3,4,5,7,10),
        ),
    ),
    "320" => array(
        "name" => __('Calefacción', 1),
        "type" => "list",
        "show" => 1,
        "options" => array(
            "1" => __('Gas natural', 1),
            "2" => __('Electricidad', 1),
            "3" => __('Gasóleo', 1),
            "4" => __('Butano', 1),
            "5" => __('Propano', 1),
            "6" => __('Solar', 1),
        ),
        "showOn" => array(
            "TypeId" => array(1, 2),
        ),
    ),
    "248" => array(
        "name" => __('Clasificación', 1),
        "type" => "list",
        "show" => 1,
        "options" => array(
            "1" => __("1 Estrella",1),
            "2" => __("2 Estrellas",1),
            "3" => __("3 Estrellas",1),
            "4" => __("4 Estrellas",1),
            "5" => __("5 Estrellas",1),
            "6" => __("5 Estrellas Gran lujo",1),
            "7" => __("5 Estrellas lujo",1),
            "8" => __("Sin categoría",1),
        ),
        "showOn" => array(
            "TypeId" => array(10),
        ),
    ),
    "321" => array(
        "name" => __('Agua caliente sanitaria', 1),
        "type" => "list",
        "show" => 1,
        "options" => array(
            "1" => __('Gas natural', 1),
            "2" => __('Electricidad', 1),
            "3" => __('Gasóleo', 1),
            "4" => __('Butano', 1),
            "5" => __('Propano', 1),
            "6" => __('Solar', 1),
        ),
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "18" => array(
        "name" => __('Tipo de nave', 1),
        "comment" => __('Para tipo industrial.', 1),
        "type" => "list",
        "show" => 1,
        "options" => array(
            "1" => __('Edificación adosada', 1),
            "2" => __('Edificación aislada', 1),
        ),
        "showOn" => array(
            "TypeId" => array(7),
        ),
    ),
    "17" => array(
        "name" => __('Tipo de plaza', 1),
        "type" => "list",
        "show" => 1,
        "comment" => __('Para plazas de garaje.', 1),
        "options" => array(
            "1" => __('Plaza box', 1),
            "2" => __('Plaza coche + moto', 1),
            "3" => __('Plaza doble', 1),
            "4" => __('Plaza exterior', 1),
            "5" => __('Plaza fija', 1),
            "6" => __('Plaza grande', 1),
            "7" => __('Plaza mediana', 1),
            "8" => __('Plaza moto', 1),
            "9" => __('Plaza muy grande', 1),
            "10" => __('Plaza no fija', 1),
            "11" => __('Plaza pequeña', 1),
        ),
        "showOn" => array(
            "TypeId" => array(8),
        ),
    ),

    // START MOBILIARIO
    array( // SEPRARADOR
        "title" =>  __('Mobiliario', 1),
        "type" => "separator",
        "showOn" => array(
            "TypeId" => array(1,2,3, 4, 8, 10, 12),
        ),
    ),
    "152" => array(
        "name" => __('Alarma individual en trastero', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(12),
        ),
    ),
    "153" => array(
        "name" => __('Sistema de vídeo vigilancia cctv 24h', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(12),
        ),
    ),
    "30" => array(
        "name" => __('Amueblado', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1, 2,3,4),
        ),
    ),
    "316" => array(
        "name" => __('No amueblado', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1, 2),
        ),
    ),
    "314" => array(
        "name" => __('Cocina equipada', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "22" => array(
        "name" => __('Ascensor', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1, 2, 3, 4, 5, 10),
        ),
    ),
    "308" => array(
        "name" => __('Ascensor interior', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "24" => array(
        "name" => __('Trastero', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1, 2, 3, 4),
        ),
    ),
    "258" => array(
        "name" => __('Armarios', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "257" => array(
        "name" => __('Lavadero', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "291" => array(
        "name" => __('Televisión', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "292" => array(
        "name" => __('Nevera', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "293" => array(
        "name" => __('Lavadora', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "287" => array(
        "name" => __('Microondas', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "288" => array(
        "name" => __('Horno', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "294" => array(
        "name" => __('Puerta blindada', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "279" => array(
        "name" => __('Muebles de diseño', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "295" => array(
        "name" => __('Gres / cerámica', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "290" => array(
        "name" => __('Parquet', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "142" => array(
        "name" => __('Domótica', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1, 2),
        ),
    ),
    "259" => array(
        "name" => __('Electrodomésticos', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "254" => array(
        "name" => __('Aire acondicionado', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2, 3, 4, 10),
        ),
    ),
    "270" => array(
        "name" => __('Calefacción', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(3),
        ),
    ),
    "29" => array(
        "name" => __('Calefacción', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(4,10),
        ),
    ),
    "274" => array(
        "name" => __('Jacuzzi', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "282" => array(
        "name" => __('Música ambiental', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "130" => array(
        "name" => __('Sistema de seguridad / vigilancia', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(3),
        ),
    ),
    "272" => array(
        "name" => __('Sistema vigilancia', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(8),
        ),
    ),
    "311" => array(
        "name" => __('Salida de humos', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(3, 8),
        ),
    ),
    // END MOBILIARIO

    // START ESTANCIAS
    array( // SEPRARADOR
        "title" =>  __('Estancias', 1),
        "type" => "separator",
        "showOn" => array(
            "TypeId" => array(1,2,4, 7, 10),
        ),
    ),
    "297" => array(
        "name" => __('Balcones', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "27" => array(
        "name" => __('Terraza', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1, 2, 4),
        ),
    ),
    "289" => array(
        "name" => __('Cocina office', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "260" => array(
        "name" => __('Suite con baño', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "309" => array(
        "name" => __('Gimnasio', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "277" => array(
        "name" => __('Sauna', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "69" => array(
        "name" => __('Superfície solar', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(2, 5, 7, 10),
        ),
    ),
    "26" => array(
        "name" => __('Jardín', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(2,10),
        ),
    ),
    "298" => array(
        "name" => __('Jardín privado', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "305" => array(
        "name" => __('Párking comunitario', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2,10),
        ),
    ),
    "300" => array(
        "name" => __('Piscina comunitaria', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "301" => array(
        "name" => __('Zona comunitaria', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "310" => array(
        "name" => __('Pista de tenis', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "302" => array(
        "name" => __('Zona deportiva', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "303" => array(
        "name" => __('Zona infantil', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "283" => array(
        "name" => __('Porche cubierto', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "263" => array(
        "name" => __('Patio', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "275" => array(
        "name" => __('Bodega', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "281" => array(
        "name" => __('Cuarto de lavado', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "280" => array(
        "name" => __('Sala de cine', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "278" => array(
        "name" => __('Baño de huéspedes', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "276" => array(
        "name" => __('Casa de invitados', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "273" => array(
        "name" => __('Cuarto para personal', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    // END ESTANCIAS

    // START GENERAL
    array( // SEPRARADOR
        "title" =>  __('General', 1),
        "type" => "separator",
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "286" => array(
        "name" => __('Internet', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "304" => array(
        "name" => __('Energía solar', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1, 2),
        ),
    ),
    "285" => array(
        "name" => __('Vistas a la montaña', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "313" => array(
        "name" => __('Se aceptan mascotas', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "266" => array(
        "name" => __('Sólo chicas', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "267" => array(
        "name" => __('Sólo chicos', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "268" => array(
        "name" => __('Sólo no fumadores', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "269" => array(
        "name" => __('-2 meses fianza', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1),
        ),
    ),
    "306" => array(
        "name" => __('Conserje', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    "307" => array(
        "name" => __('Vídeo portero', 1),
        "type" => "bool",
        "show" => 1,
        "showOn" => array(
            "TypeId" => array(1,2),
        ),
    ),
    // END GENERAL
);
