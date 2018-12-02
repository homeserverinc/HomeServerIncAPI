<?php

require_once 'vendor/autoload.php';

use HomeServerInc\API\HomeServerApiClient;


$request = explode('/', $_SERVER['REQUEST_URI']);

$service = $request[1];
$param = isset($request[2]) ? $request[2] : null;


$apiClient = new HomeServerApiClient('superadministrator@app.com', 'password');
if ($apiClient->auth()) {
    switch ($service) {
        case 'service':
            echo $apiClient->getService($param);
            break;

        case 'question':
            echo $apiClient->getQuestion($param);
            break;
            
        default:  
            include('home.php');
            break;
    }
}
?>