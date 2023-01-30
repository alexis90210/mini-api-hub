<?php

require 'vendor/autoload.php';

require 'cors.php';

use GuzzleHttp\Client;

use GuzzleHttp\Psr7\Request;


$data = json_decode( file_get_contents('php://input'));

if ( !$data ) {
    echo json_encode([
        'code' => 'error',
        'message' => 'Parametre de la requete obligatoire'
    ]);
    die();
}

try {
    
    $client = new Client(['base_uri' => 'http://51.178.29.100/']);

    // Methods
    $data->method = isset( $data->method ) ? $data->method : 'GET';

    $data->route = isset( $data->route ) ? $data->route : '';

    $headers = [];

    if ( isset( $data->headers) ) {
        $headers =  array_merge($headers , [ 'headers' => (array) $data->headers ]);
    }

    if ( isset( $data->data) ) {
        $headers =  array_merge($headers , [ 'json' =>  (array) $data->data  ]);
    }

    // Prepare Request
    $request = new Request($data->method, $data->route, $headers );

    // Send Request
    $response = $client->send($request);
    
    $response_body = (string)$response->getBody();

    echo $response_body;

} catch (\Throwable $th) {

    ini_set('display_errors', 1);

    if ( str_contains($th, "405 Method Not Allowed")) {
        echo json_encode([
            "code" => "error",
            "message" => "405 Method Not Allowed"
        ]);
    } else  if ( str_contains($th, "404 Not Found")) {
        echo json_encode([
            "code" => "error",
            "message" => "404 Not Found"
        ]);
    } else  if ( str_contains($th, "415 Unsupported Media")) {
        echo json_encode([
            "code" => "error",
            "message" => "415 Unsupported Media"
        ]);
    } else {
        echo $th;    
    }
}