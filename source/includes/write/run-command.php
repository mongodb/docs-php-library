<?php

require __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

// start-runcommand
$database = $client->accounts;
$command = ['dbStats' => 1];

$result = $database->command($command);
// end-runcommand

var_dump(json_encode($result->toArray()));
