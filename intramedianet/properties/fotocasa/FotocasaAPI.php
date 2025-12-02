<?php

class FotocasaAPI {

	// API URL
	static private $apiURL = 'https://imports.gw.fotocasa.pro/';

	// API ENDPOINTS
	static private $getPublication = array( // Retorna los datos de los portales disponibles del cliente.
		"url" => "api/publication",
		"method" => "GET"
	);
	static private $getPublicationProperty = array( // Retorna todos los inmuebles publicados en Fotocasa, Vibbo y Milanuncios.
		"url" => "api/publication/property",
		"method" => "GET"
	);
	static private $insertProperty = array( // Inserción de nuevos inmuebles.
		"url" => "api/property",
		"method" => "POST"
	);
	static private $updateProperty = array( // Actualización de un inmueble ya existente.
		"url" => "api/property",
		"method" => "PUT"
	);
	static private $deleteProperty = array( // Despublica un inmueble de todos los portales. Además actualiza su estado de "Disponible" a "No disponible" en Inmofactory.
		"url" => "api/v2/property/",
		"method" => "DELETE"
	);
	static private $deletePropertyByPortal = array( // Despublica un inmueble de todos los portales. Además actualiza su estado de "Disponible" a "No disponible" en Inmofactory.
		"url" => "api/property/{id}/publication/{publicationId}",
		"method" => "DELETE"
	);

	static public function getPublication($auth, $data = "")
    {
		return self::APICall( self::$getPublication["url"], self::$getPublication["method"], $auth, $data );
	}

	static public function getPublicationProperty($auth, $data = "")
    {
		return self::APICall( self::$getPublicationProperty["url"], self::$getPublicationProperty["method"], $auth, $data );
	}

	static public function insertProperty($auth, $data = "")
    {

		return self::APICall( self::$insertProperty["url"], self::$insertProperty["method"], $auth, $data );
	}

	static public function updateProperty($auth, $data = "")
    {

		$ch = curl_init(self::$apiURL.self::$updateProperty["url"]);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, self::$updateProperty["method"]);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Cache-Control: no-cache',
			'Api-Key: '.$auth,
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data)
		));

        $resultJson = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($resultJson, 1);

        return $result;

		// return self::APICall( self::$updateProperty["url"], self::$updateProperty["method"], $auth, $data );
	}

	static public function deleteProperty($id, $auth, $data = "")
    {

		if ( $id64 = base64_encode($id) ) {
			return self::APICall( "api/v2/property/".base64_encode($id), self::$deleteProperty["method"], $auth, $data );
		}
		return "Error on base64 with ID ". $id;
	}

	static public function deletePropertyByPortal($idProp, $idPub, $auth, $data = "")
    {
		$url = self::$deletePropertyByPortal["url"];
		$url = str_replace(array("{id}", "{publicationId}"), array($idProp, $idPub), $url);
		if ($url) {
			return self::APICall( $url, self::$deletePropertyByPortal["method"], $auth, $data );
		}
		return "Error on URL: ". $url;
	}

	static private function APICall($url, $method, $auth, $data = "")
    {

		$ch = curl_init(self::$apiURL.$url);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			'Cache-Control: no-cache',
			'Inmofactory-Api-Key: '.$auth,
			'Content-Type: application/json',
			'Content-Length: ' . strlen($data)
		));

        $resultJson = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($resultJson, 1);
        return $result;
    }
}
