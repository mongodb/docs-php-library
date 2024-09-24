// start-specify-v1
$uri = "mongodb://<hostname>:<port>";

$driverOptions = ['serverApi' => new MongoDB\Driver\ServerApi('1')];

$client = new MongoDB\Client($uri, [], $driverOptions);
// end-specify-v1

// start-stable-api-options
$uri = "mongodb://<hostname>:<port>";

$driverOptions = ['serverApi' => new MongoDB\Driver\ServerApi('1', strict: true, deprecationErrors: true)];
$client = new MongoDB\Client($uri, [], $driverOptions);
// end-stable-api-options
