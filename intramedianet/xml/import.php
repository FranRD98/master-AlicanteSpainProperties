<?php

ini_set('display_errors', 0);
error_reporting(E_ALL);

 // Cargamos la conexión a MySql
require_once( $_SERVER["DOCUMENT_ROOT"] . '/Connections/inmoconn.php' );

$propiedaes = simplexml_load_file("import.xml");

$i = 1;

$language = 'es';

$languages = array('es', 'da', 'de', 'el', 'en', 'fi', 'fr', 'is', 'it', 'nl', 'no', 'pt', 'ru', 'se', 'zh');

// $existe = array();

// foreach ($propiedaes->inmueble as $property) {

//     $valor = (string)$property->caracteriscas->interior;

//     if ( !in_array($valor, $existe) ) {
//         array_push($existe, $valor);
//         echo $valor . '<hr>';
//     }

// }
// aa();

foreach ($propiedaes->inmueble as $property) {


    //////////////////////////////////////////////////////////////////////////////////////////////////
    // Paises
    //////////////////////////////////////////////////////////////////////////////////////////////////

    
    $query_rsCountry = "SELECT id_loc1, name_en_loc1 FROM properties_loc1 WHERE  LOWER(name_en_loc1) = 'spain'";
    $rsCountry = mysqil_query($inmoconn,$query_rsCountry) or die(mysqli_error());
    $row_rsCountry = mysqli_fetch_assoc($rsCountry);
    $totalRows_rsCountry = mysqli_num_rows($rsCountry);

    if($totalRows_rsCountry == 0){

        $query = "INSERT INTO properties_loc1 SET ";

        foreach($languages as $value) {
            if($value != $language){
                $query .= " ,";
            }
            $query .= "name_".$value."_loc1 = 'Spain'";
        }

        
        $rsCountryInsert = mysqil_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
        $id = @mysqli_insert_id($inmoconn);
        $country = $id;

    } else{

        $country = $row_rsCountry['id_loc1'];

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////
    // Provincias
    //////////////////////////////////////////////////////////////////////////////////////////////////

    
    $query_rsProvince = "SELECT id_loc2, name_en_loc2 FROM properties_loc2 WHERE  LOWER(name_en_loc2) = '".str_replace("'","\'", strtolower(trim(($property->direccion->provincia))))."' AND loc1_loc2 = '".$country."'";
    $rsProvince = mysqil_query($inmoconn,$query_rsProvince) or die(mysqli_error());
    $row_rsProvince = mysqli_fetch_assoc($rsProvince);
    $totalRows_rsProvince = mysqli_num_rows($rsProvince);

    if($totalRows_rsProvince == 0){

        $query = "INSERT INTO properties_loc2 SET ";

        $query .= "loc1_loc2 = '".$country."', ";

        foreach($languages as $value) {
            if($value != $language){
                $query .= " ,";
            }
            $query .= "name_".$value."_loc2 = '".(trim(str_replace("'","\'", trim($property->direccion->provincia))))."'";
        }

        
        $rsProvinceInsert = mysqil_query($inmoconn,$query) or die(mysqli_error());
        $id = @mysqli_insert_id($inmoconn);
        $province = $id;

    } else{

        $province = $row_rsProvince['id_loc2'];

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////
    // Ciudades
    //////////////////////////////////////////////////////////////////////////////////////////////////

    
    $query_rsCity = "SELECT id_loc3, name_en_loc3 FROM properties_loc3 WHERE  LOWER(name_en_loc3) = '".str_replace("'","\'", strtolower(trim($property->direccion->poblacion)))."' AND loc2_loc3 = '".$province."'";
    $rsCity = mysqil_query($inmoconn,$query_rsCity) or die(mysqli_error());
    $row_rsCity = mysqli_fetch_assoc($rsCity);
    $totalRows_rsCity = mysqli_num_rows($rsCity);

    if($totalRows_rsCity == 0){

        $query = "INSERT INTO properties_loc3 SET ";

        $query .= "loc2_loc3 = '".$province."', ";

        foreach($languages as $value) {
            if($value != $language){
                $query .= " ,";
            }
            $query .= "name_".$value."_loc3 = '".(trim(str_replace("'","\'", trim($property->direccion->poblacion))))."'";
        }

        
        $rsCityInsert = mysqil_query($inmoconn,$query) or die(mysqli_error());
        $id = @mysqli_insert_id($inmoconn);
        $city = $id;

    } else{

        $city = $row_rsCity['id_loc3'];

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////
    // Zonas
    //////////////////////////////////////////////////////////////////////////////////////////////////

    $campo =  (trim($property->direccion->zona) != '' && trim($property->direccion->zona) != 'Array')?str_replace("'","\'", strtolower(trim($property->direccion->zona))):str_replace("'","\'", strtolower(trim($property->direccion->poblacion)));

    $campo2 =  (trim($property->direccion->zona )!= '' && trim($property->direccion->zona )!= 'Array')?str_replace("'","\'", trim($property->direccion->zona)):str_replace("'","\'", trim($property->direccion->poblacion));

    
    $query_rsZone = "SELECT id_loc4, name_en_loc4 FROM properties_loc4 WHERE  LOWER(name_en_loc4) = '".$campo."' AND loc3_loc4 = '".$city."'";
    $rsZone = mysqil_query($inmoconn,$query_rsZone) or die(mysqli_error());
    $row_rsZone = mysqli_fetch_assoc($rsZone);
    $totalRows_rsZone = mysqli_num_rows($rsZone);

    if($totalRows_rsZone == 0){

        $query = "INSERT INTO properties_loc4 SET ";

        $query .= "loc3_loc4 = '".$city."', ";

        foreach($languages as $value) {
            if($value != $language){
                $query .= " ,";
            }
            $query .= "name_".$value."_loc4 = '".$campo2."'";
        }

        
        $rsZoneInsert = mysqil_query($inmoconn,$query) or die(mysqli_error());
        $id = @mysqli_insert_id($inmoconn);
        $location = $id;

    } else{

        $location = $row_rsZone['id_loc4'];

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////
    // Tipos
    //////////////////////////////////////////////////////////////////////////////////////////////////

    
    $query_rsType = "SELECT id_typ, types_en_typ FROM properties_types WHERE  LOWER(types_en_typ) = '".str_replace("'","\'", strtolower(trim($property->tipo)))."'";
    $rsType = mysqil_query($inmoconn,$query_rsType) or die(mysqli_error());
    $row_rsType = mysqli_fetch_assoc($rsType);
    $totalRows_rsType = mysqli_num_rows($rsType);

    if($totalRows_rsType == 0){

        $query = "INSERT INTO properties_types SET ";

        foreach($languages as $value) {
            if($value != $language){
                $query .= ", ";
            }
            $query .= "types_".$value."_typ = '".(trim(str_replace("'","\'", $property->tipo)))."'";
        }

        
        $rsTypeInsert = mysqil_query($inmoconn,$query) or die(mysqli_error() .'<hr>' . $query);
        $id = @mysqli_insert_id($inmoconn);
        $type = $id;

    } else{

        $type = $row_rsType['id_typ'];

    }

    //////////////////////////////////////////////////////////////////////////////////////////////////
    // Insertar inmuebles
    //////////////////////////////////////////////////////////////////////////////////////////////////

    
    $query_rsProperty = "SELECT * FROM properties_properties WHERE referencia_prop = '".trim($property->referencia)."'";
    $rsProperty = mysqil_query($inmoconn,$query_rsProperty) or die(mysqli_error());
    $row_rsProperty = mysqli_fetch_assoc($rsProperty);
    $totalRows_rsProperty = mysqli_num_rows($rsProperty);

    switch (trim($property->estado)) {
        case 'Segunda mano':
            $status = "5";
            break;
        case 'Obra Nueva - En construcción':
            $status = "11";
            break;
        case 'Obra Nueva - Llave en Mano':
            $status = "11";
            break;
    }

    if($totalRows_rsProperty == 0) {

        $query = "INSERT INTO properties_properties SET ";

        $query .= "referencia_prop = '".trim($property->referencia)."', ";
        $query .= "localidad_prop = '".$location."', ";
        $query .= "operacion_prop = '".$status."', ";
        $query .= "tipo_prop = '".$type."', ";
        $query .= "preci_reducidoo_prop = '".trim(str_replace(",00", "", $property->precio))."', ";
        $query .= "descripcion_es_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->es))."', ";
        $query .= "descripcion_en_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->en))."', ";
        $query .= "descripcion_ru_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->ru))."', ";
        $query .= "descripcion_nl_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->nl))."', ";
        $query .= "descripcion_fr_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->fr))."', ";
        $query .= "descripcion_no_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->nb))."', ";
        $query .= "descripcion_se_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->sv))."', ";
        $query .= "cp_prop = '".trim($property->direccion->codigopostal)."', ";
        $query .= "direccion_prop = '".trim($property->direccion->via)."', ";
        $query .= "m2_prop = '".trim($property->superficies->construidos)."', ";
        $query .= "m2_parcela_prop = '".trim($property->superficies->solar)."', ";
        $query .= "m2_terraza_prop = '".trim($property->superficies->terraza)."', ";
        $query .= "m2_garaje_prop = '".trim($property->superficies->garaje)."', ";
        $query .= "m2_sotano_prop = '".trim($property->superficies->sotano)."', ";
        $query .= "m2_fachada_prop = '".trim($property->superficies->fachada)."', ";
        $query .= "habitaciones_prop = '".trim($property->estancias->dormitorios)."', ";
        $query .= "aseos_prop = '".trim($property->estancias->banos)."', ";
        $query .= "aseos2_prop = '".trim($property->estancias->aseos)."', ";
        $query .= "cocinas_prop = '".trim($property->estancias->cocinas)."', ";
        $query .= "terrazas_prop = '".trim($property->estancias->terrazas)."', ";
        $query .= "salones_prop = '".trim($property->estancias->salones)."', ";
        $query .= "puertas_prop = '".trim($property->otros->puertas)."', ";
        $query .= "plantas_prop = '".trim($property->otros->plantas)."', ";
        $query .= "viviendas_prop = '".trim($property->otros->viviendas)."', ";
        $query .= "planta_prop = '".trim($property->otros->planta)."', ";
        $query .= "salas_prop = '".trim($property->otros->salas)."', ";
        $query .= "armarios_empotrados_prop = '".trim($property->otros->armariosempotrados)."', ";
        $query .= "plazas_garaje_prop = '".trim($property->otros->plazasgaraje)."', ";
        $query .= "construccion_prop = '".trim($property->otros->anoconstruccion)."', ";
        $query .= "gastos_prop = '".trim($property->otros->gastoscomunidad)."', ";
        $query .= "distance_beach_prop = '".trim($property->otros->distanciaplaya)."', ";
        $query .= "distancia_poblacion_cercana_prop = '".trim($property->otros->distanciapoblacioncercana)."', ";
        $query .= "coeficiente_ocupacion_prop = '".trim($property->otros->coeficienteocupacion)."', ";
        $query .= "precio_garaje_opcional_prop = '".trim($property->otros->preciogarajeopcional)."', ";
        $query .= "precio_trastero_opcional_prop = '".trim($property->otros->preciotrasteroopcional)."', ";
        $query .= "tip_gas_prop = '".trim($property->tipos->gas)."', ";
        $query .= "tip_piscina_prop = '".trim($property->tipos->piscina)."', ";
        $query .= "tip_calefaccion_prop = '".trim($property->tipos->calefaccion)."', ";
        $query .= "tip_aire_acondicionado_prop = '".trim($property->tipos->aireacondicionado)."', ";
        $query .= "tip_jardin_prop = '".trim($property->tipos->jardin)."', ";
        $query .= "tip_garaje_prop = '".trim($property->tipos->garaje)."', ";
        $query .= "tip_area_juego_prop = '".trim($property->tipos->areajuego)."', ";
        $query .= "tip_cocina_prop = '".trim($property->tipos->cocina)."', ";
        $query .= "tip_linea_playa_prop = '".trim($property->tipos->lineaplaya)."', ";
        if ((string)$property->tipos->piscina != '') {
            $query .= "piscina_prop = '1', ";
        }
        if ((string)$property->tipos->orientacion != '') {
            $query .= "orientacion_prop = 'o-se', ";
        }
        $query .= "inserted_xml_prop = '".date("Y-m-d H:i:s")."', ";
        $query .= "activado_prop = '1' ";

        
        $rsPropertyInsert = mysqil_query($inmoconn,$query) or die(mysqli_error());
        $id = @mysqli_insert_id($inmoconn);
        $propertyID = $id;

        echo "Inserted<br>";

    } else {

        $update = true;

        $query = "UPDATE properties_properties SET ";

        $query .= "localidad_prop = '".$location."', ";
        $query .= "operacion_prop = '".$status."', ";
        $query .= "tipo_prop = '".$type."', ";
        $query .= "preci_reducidoo_prop = '".trim(str_replace(",00", "", $property->precio))."', ";
        $query .= "descripcion_es_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->es))."', ";
        $query .= "descripcion_en_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->en))."', ";
        $query .= "descripcion_ru_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->ru))."', ";
        $query .= "descripcion_nl_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->nl))."', ";
        $query .= "descripcion_fr_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->fr))."', ";
        $query .= "descripcion_no_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->nb))."', ";
        $query .= "descripcion_se_prop = '".mysqli_real_escape_string($inmoconn,trim($property->descripcion->sv))."', ";
        $query .= "cp_prop = '".trim($property->direccion->codigopostal)."', ";
        $query .= "direccion_prop = '".trim($property->direccion->via)."', ";
        $query .= "m2_prop = '".trim($property->superficies->construidos)."', ";
        $query .= "m2_parcela_prop = '".trim($property->superficies->solar)."', ";
        $query .= "m2_terraza_prop = '".trim($property->superficies->terraza)."', ";
        $query .= "m2_garaje_prop = '".trim($property->superficies->garaje)."', ";
        $query .= "m2_sotano_prop = '".trim($property->superficies->sotano)."', ";
        $query .= "m2_fachada_prop = '".trim($property->superficies->fachada)."', ";
        $query .= "habitaciones_prop = '".trim($property->estancias->dormitorios)."', ";
        $query .= "aseos_prop = '".trim($property->estancias->banos)."', ";
        $query .= "aseos2_prop = '".trim($property->estancias->aseos)."', ";
        $query .= "cocinas_prop = '".trim($property->estancias->cocinas)."', ";
        $query .= "terrazas_prop = '".trim($property->estancias->terrazas)."', ";
        $query .= "salones_prop = '".trim($property->estancias->salones)."', ";
        $query .= "puertas_prop = '".trim($property->otros->puertas)."', ";
        $query .= "plantas_prop = '".trim($property->otros->plantas)."', ";
        $query .= "viviendas_prop = '".trim($property->otros->viviendas)."', ";
        $query .= "planta_prop = '".trim($property->otros->planta)."', ";
        $query .= "salas_prop = '".trim($property->otros->salas)."', ";
        $query .= "armarios_empotrados_prop = '".trim($property->otros->armariosempotrados)."', ";
        $query .= "plazas_garaje_prop = '".trim($property->otros->plazasgaraje)."', ";
        $query .= "construccion_prop = '".trim($property->otros->anoconstruccion)."', ";
        $query .= "gastos_prop = '".trim($property->otros->gastoscomunidad)."', ";
        $query .= "distance_beach_prop = '".trim($property->otros->distanciaplaya)."', ";
        $query .= "distancia_poblacion_cercana_prop = '".trim($property->otros->distanciapoblacioncercana)."', ";
        $query .= "coeficiente_ocupacion_prop = '".trim($property->otros->coeficienteocupacion)."', ";
        $query .= "precio_garaje_opcional_prop = '".trim($property->otros->preciogarajeopcional)."', ";
        $query .= "precio_trastero_opcional_prop = '".trim($property->otros->preciotrasteroopcional)."', ";
        $query .= "tip_gas_prop = '".trim($property->tipos->gas)."', ";
        $query .= "tip_piscina_prop = '".trim($property->tipos->piscina)."', ";
        $query .= "tip_calefaccion_prop = '".trim($property->tipos->calefaccion)."', ";
        $query .= "tip_aire_acondicionado_prop = '".trim($property->tipos->aireacondicionado)."', ";
        $query .= "tip_jardin_prop = '".trim($property->tipos->jardin)."', ";
        $query .= "tip_garaje_prop = '".trim($property->tipos->garaje)."', ";
        $query .= "tip_area_juego_prop = '".trim($property->tipos->areajuego)."', ";
        $query .= "tip_cocina_prop = '".trim($property->tipos->cocina)."', ";
        $query .= "tip_linea_playa_prop = '".trim($property->tipos->lineaplaya)."', ";
        if ((string)$property->tipos->piscina != '') {
            $query .= "piscina_prop = '1', ";
        }
        if ((string)$property->tipos->orientacion != '') {
            $query .= "orientacion_prop = 'o-se', ";
        }
        $query .= "inserted_xml_prop = '".date("Y-m-d H:i:s")."', ";
        $query .= "activado_prop = '1' ";

        $query .= "WHERE referencia_prop = '".trim($property->referencia)."'";

        
        $rsPropertyInsert = mysqil_query($inmoconn,$query) or die(mysqli_error());
        $propertyID = $row_rsProperty['id_prop'];

        echo "Updated<br>";

    }

    $opciones = array();

    if ((string)$property->caracteriscas->acristalado == 'True') {
        array_push($opciones, 'Glazed');
    }
    if ((string)$property->caracteriscas->agua == 'True') {
        array_push($opciones, 'Water');
    }
    if ((string)$property->caracteriscas->amueblado == 'True') {
        array_push($opciones, 'Furnished');
    }
    if ((string)$property->caracteriscas->antenaparabolica == 'True') {
        array_push($opciones, 'Satellite dish');
    }
    if ((string)$property->caracteriscas->antenatv == 'True') {
        array_push($opciones, 'TV antenna');
    }
    if ((string)$property->caracteriscas->ascensor == 'True') {
        array_push($opciones, 'Lift');

        
        $query_rsUpdate1 = "UPDATE `properties_properties` SET `ascensor_prop` = '1' WHERE `id_prop` = '".$propertyID."'";
        $rsUpdate1 = mysqil_query($inmoconn,$query_rsUpdate1) or die(mysqli_error());
    }
    if ((string)$property->caracteriscas->barbacoa == 'True') {
        array_push($opciones, 'Barbecue');
    }
    if ((string)$property->caracteriscas->chimenea == 'True') {
        array_push($opciones, 'Fireplace');
    }
    if ((string)$property->caracteriscas->costa == 'True') {
        array_push($opciones, 'Coast');
    }
    if ((string)$property->caracteriscas->electrodomesticos == 'True') {
        array_push($opciones, 'Kitchen appliances');
    }
    if ((string)$property->caracteriscas->energiasolar == 'True') {
        array_push($opciones, 'Energía solar');
    }
    if ((string)$property->caracteriscas->exterior == 'True') {
        array_push($opciones, 'Exterior');
    }
    if ((string)$property->caracteriscas->galeria == 'True') {
        array_push($opciones, 'Galería');
    }
    if ((string)$property->caracteriscas->gimnasio == 'True') {
        array_push($opciones, 'Gimnasio');
    }
    if ((string)$property->caracteriscas->golf == 'True') {
        array_push($opciones, 'Golf');
    }
    if ((string)$property->caracteriscas->hidromasaje == 'True') {
        array_push($opciones, 'Hidromasaje');
    }
    if ((string)$property->caracteriscas->internet == 'True') {
        array_push($opciones, 'Internet');
    }
    if ((string)$property->caracteriscas->luz == 'True') {
        array_push($opciones, 'Laz');
    }
    if ((string)$property->caracteriscas->obranueva == 'True') {
        array_push($opciones, 'New construction');
    }
    if ((string)$property->caracteriscas->pistadebaloncesto == 'True') {
        array_push($opciones, 'Pista de baloncesto');
    }
    if ((string)$property->caracteriscas->pistadefutbol == 'True') {
        array_push($opciones, 'Pista de fútbo');
    }
    if ((string)$property->caracteriscas->pistadepadel == 'True') {
        array_push($opciones, 'Pista de pádel');
    }
    if ((string)$property->caracteriscas->pistadetenis == 'True') {
        array_push($opciones, 'Pista de tenis');
    }
    if ((string)$property->caracteriscas->portero == 'True') {
        array_push($opciones, 'Portero');
    }
    if ((string)$property->caracteriscas->puertablindada == 'True') {
        array_push($opciones, 'Puerta blindada');
    }
    if ((string)$property->caracteriscas->solarium == 'True') {
        array_push($opciones, 'Solarium');
    }
    if ((string)$property->caracteriscas->telefono == 'True') {
        array_push($opciones, 'Phone');
    }
    if ((string)$property->caracteriscas->sauna == 'True') {
        array_push($opciones, 'Sauna');
    }
    if ((string)$property->caracteriscas->trastero == 'True') {
        array_push($opciones, 'Trastero');
    }
    if ((string)$property->caracteriscas->urbanizacion == 'True') {
        array_push($opciones, 'Urbanization');
    }
    if ((string)$property->caracteriscas->vistasmar == 'True') {
        array_push($opciones, 'Sea Views');

        
        $query_rsUpdate1 = "UPDATE `properties_properties` SET `vistas_mar_prop` = '1' WHERE `id_prop` = '".$propertyID."'";
        $rsUpdate1 = mysqil_query($inmoconn,$query_rsUpdate1) or die(mysqli_error());

    }

    
    $query_rsDeletekPropFeature = "DELETE FROM properties_property_feature WHERE  property = '".$propertyID."'";
    $rsDeletekPropFeature = mysqil_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error() . '<hr>' . $query_rsDeletekPropFeature);

    if(count($opciones) > 0) {
        foreach ($opciones as $valueOpc) {
            if ($valueOpc != '') {
                
                $query_rsFeature = "SELECT id_feat, feature_es_feat FROM properties_features WHERE  LOWER(feature_es_feat) = '".str_replace("'","\'", strtolower(trim($valueOpc)))."'";
                $rsFeature = mysqil_query($inmoconn,$query_rsFeature) or die(mysqli_error() . '<hr>' . $query_rsFeature );
                $row_rsFeature = mysqli_fetch_assoc($rsFeature);
                $totalRows_rsFeature = mysqli_num_rows($rsFeature);

                if($totalRows_rsFeature == 0){

                    $query = "INSERT INTO properties_features SET ";

                    $query .= "feature_es_feat = '".mysqli_real_escape_string($inmoconn,trim($valueOpc))."', ";
                    $query .= "feature_en_feat = '".mysqli_real_escape_string($inmoconn,trim($valueOpc))."', ";
                    $query .= "feature_ru_feat = '".mysqli_real_escape_string($inmoconn,trim($valueOpc))."', ";
                    $query .= "feature_nl_feat = '".mysqli_real_escape_string($inmoconn,trim($valueOpc))."', ";
                    $query .= "feature_fr_feat = '".mysqli_real_escape_string($inmoconn,trim($valueOpc))."', ";
                    $query .= "feature_no_feat = '".mysqli_real_escape_string($inmoconn,trim($valueOpc))."', ";
                    $query .= "feature_se_feat = '".mysqli_real_escape_string($inmoconn,trim($valueOpc))."' ";

                    
                    $rsFeatureInsert = mysqil_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);
                    $id = @mysqli_insert_id($inmoconn);
                    $feature = $id;

                } else{

                    $feature = $row_rsFeature['id_feat'];

                }

                if($feature != ''){

                    $query = "INSERT INTO properties_property_feature SET ";

                    $query .= "property = '".$propertyID."',";
                    $query .= "feature = '".$feature."'";

                    
                    $rsPropFeatureInsert = mysqil_query($inmoconn,$query) or die(mysqli_error() . '<hr>' . $query);

                }
            }
        }
    }

    
    $query_rsDeletekPropFeature = "DELETE FROM properties_images WHERE  property_img = '".$propertyID."'";
    $rsDeletekPropFeature = mysqil_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error() . '<hr>' . $query_rsDeletekPropFeature);

    $imgOrd = 1;

    foreach ($property->imagenes->imagen as $image) {

        
        $query_rsImages = "SELECT * FROM properties_images WHERE property_img = '".$propertyID."' AND image_img = '".trim($image->big)."'";
        $rsImages = mysqil_query($inmoconn,$query_rsImages) or die(mysqli_error());
        $row_rsImages = mysqli_fetch_assoc($rsImages);
        $totalRows_rsImages = mysqli_num_rows($rsImages);

        if($totalRows_rsImages == 0){

            $query = "INSERT INTO properties_images SET ";

            $query .= "property_img = '".$propertyID."',";
            $query .= "image_img = '".trim($image->big)."', ";
            $query .= "alt_es_img = '".trim($image->info->es->alt)."', ";
            $query .= "alt_en_img = '".trim($image->info->en->alt)."', ";
            $query .= "alt_ru_img = '".trim($image->info->ru->alt)."', ";
            $query .= "alt_nl_img = '".trim($image->info->nl->alt)."', ";
            $query .= "alt_fr_img = '".trim($image->info->fr->alt)."', ";
            $query .= "alt_no_img = '".trim($image->info->nb->alt)."', ";
            $query .= "alt_se_img = '".trim($image->info->sv->alt)."', ";
            $query .= "alt_fi_img = '".trim($image->info->fi->alt)."', ";
            $query .= "active_img = '1', ";
            $query .= "order_img = '".$imgOrd."'";

            
            $rsPropFeatureInsert = mysqil_query($inmoconn,$query) or die(mysqli_error());

        } else {

            $query = "UPDATE properties_images SET ";

            $query .= "active_img = '1',  ";

            $query .= "order_img = '".$imgOrd."'";

            $query .= "WHERE property_img = '".$propertyID."' AND image_img = '".trim($image->big)."'";

            
            $rsPropFeatureInsert = mysqil_query($inmoconn,$query) or die(mysqli_error());

        }

        $imgOrd++;

    }


    
    $query_rsDeletekPropFeature = "DELETE FROM properties_planos WHERE  property_img = '".$propertyID."'";
    $rsDeletekPropFeature = mysqil_query($inmoconn,$query_rsDeletekPropFeature) or die(mysqli_error() . '<hr>' . $query_rsDeletekPropFeature);

    $imgOrd = 1;

    foreach ($property->planos->plano as $image) {

        
        $query_rsImages = "SELECT * FROM properties_planos WHERE property_img = '".$propertyID."' AND image_img = '".trim($image->big)."'";
        $rsImages = mysqil_query($inmoconn,$query_rsImages) or die(mysqli_error());
        $row_rsImages = mysqli_fetch_assoc($rsImages);
        $totalRows_rsImages = mysqli_num_rows($rsImages);

        if($totalRows_rsImages == 0){

            $query = "INSERT INTO properties_planos SET ";

            $query .= "property_img = '".$propertyID."',";
            $query .= "image_img = '".$image->big."', ";
            if(trim($image->info->es->alt) != '...') {
            $query .= "alt_es_img = '".mysqli_real_escape_string($inmoconn,trim($image->info->es->alt))."', ";
            }
            if(trim($image->info->en->alt) != '...') {
            $query .= "alt_en_img = '".mysqli_real_escape_string($inmoconn,trim($image->info->en->alt))."', ";
            }
            if(trim($image->info->ru->alt) != '...') {
            $query .= "alt_ru_img = '".mysqli_real_escape_string($inmoconn,trim($image->info->ru->alt))."', ";
            }
            if(trim($image->info->nl->alt) != '...') {
            $query .= "alt_nl_img = '".mysqli_real_escape_string($inmoconn,trim($image->info->nl->alt))."', ";
            }
            if(trim($image->info->fr->alt) != '...') {
            $query .= "alt_fr_img = '".mysqli_real_escape_string($inmoconn,trim($image->info->fr->alt))."', ";
            }
            if(trim($image->info->nb->alt) != '...') {
            $query .= "alt_no_img = '".mysqli_real_escape_string($inmoconn,trim($image->info->nb->alt))."', ";
            }
            if(trim($image->info->sv->alt) != '...') {
            $query .= "alt_se_img = '".mysqli_real_escape_string($inmoconn,trim($image->info->sv->alt))."', ";
            }
            if(trim($image->info->fi->alt) != '...') {
            $query .= "alt_fi_img = '".mysqli_real_escape_string($inmoconn,trim($image->info->fi->alt))."', ";
        }
            $query .= "active_img = '1', ";
            $query .= "order_img = '".$imgOrd."'";

            
            $rsPropFeatureInsert = mysqil_query($inmoconn,$query) or die(mysqli_error());

        } else {

            $query = "UPDATE properties_planos SET ";

            $query .= "active_img = '1',  ";

            $query .= "order_img = '".$imgOrd."'";

            $query .= "WHERE property_img = '".$propertyID."' AND image_img = '".trim($image->big)."'";

            
            $rsPropFeatureInsert = mysqil_query($inmoconn,$query) or die(mysqli_error());

        }

        $imgOrd++;

    }

    echo "<hr>";



}

