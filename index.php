<?php

require_once 'vendor/autoload.php';

use HomeServerInc\API\HomeServerApiClient;

$client = new HomeServerApiClient('superadministrator@app.com', 'password');


if ($client->auth()) {
    echo $client->getSite('49c96f2f-733b-468f-b374-bc3f3116cb34');
}