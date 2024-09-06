<?php

require __DIR__ . '/vendor/autoload.php';

use MongoDB\Client;

$client = new Client('<connection string>');

// start-runcommand
$database = $client->plants;

$countCommand = ['count' => 'flowers'];
$explainCommand = ['explain' => $countCommand, 'verbosity' => 'queryPlanner'];

$result = $database->command($explainCommand);
// end-runcommand

var_dump($result->toArray());

