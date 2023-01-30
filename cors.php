<?php

if (isset($_SERVER["HTTP_ORIGIN"])) {
    
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");

} else {

    header("Access-Control-Allow-Origin: *");

}

header("Access-Control-Allow-Credentials: true");

header("Access-Control-Max-Age: 600");    // cache for 10 minutes

if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_METHOD"]))

        header("Access-Control-Allow-Methods: POST, GET, OPTIONS, DELETE, PUT"); 

    if (isset($_SERVER["HTTP_ACCESS_CONTROL_REQUEST_HEADERS"]))
    
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    //Just exit with 200 OK with the above headers for OPTIONS method
    exit(0);
}
