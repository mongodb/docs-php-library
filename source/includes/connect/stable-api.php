// start-specify-v1
<?php

$uri = "mongodb://<hostname>:<port>";

$client = new MongoDB\Client($uri, [], [
    'serverApi' => new MongoDB\Driver\ServerApi('1')
]);

?>
// end-specify-v1

// start-stable-api-options
<?php

$uri = "mongodb://<hostname>:<port>";

$client = new MongoDB\Client($uri, [], [
    'serverApi' => new MongoDB\Driver\ServerApi('1', true, true)
]);

?>
// end-stable-api-options
