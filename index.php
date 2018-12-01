<?php

require_once 'vendor/autoload.php';

use HomeServerInc\API\HomeServerApiClient;

$client = new HomeServerApiClient('superadministrator@app.com', 'password');


if ($client->auth()) {
    $response = $client->getSite('49c96f2f-733b-468f-b374-bc3f3116cb34');

    //working with arrays
    echo "<h1>Arrays</h1>";
    $site = json_decode($response, true)['data'];
    echo $site['name'].'<br />';
    echo $site['phone']['friendly_name'].'<br />';


    echo "<h1>StdClass</h1>";
    //working with StdClass
    $site = json_decode($response)->{'data'};
    echo $site->{'name'}.'<br />';
    echo $site->{'phone'}->{'friendly_name'}.'<br />';
}
