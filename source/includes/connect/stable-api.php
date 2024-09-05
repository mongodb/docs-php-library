// start-specify-v1
<?php

$uri = "mongodb://<hostname>:<port>";

$driverOptions = [
    'serverApi' => new MongoDB\Driver\ServerApi('1')
];

$client = new MongoDB\Client($uri, [], $driverOptions);
// end-specify-v1

// start-stable-api-options
<?php

$uri = "mongodb://<hostname>:<port>";

$driverOptions = [
    'serverApi' => new MongoDB\Driver\ServerApi('1', true, true)
];

$client = new MongoDB\Client($uri, [], $driverOptions);
// end-stable-api-options
