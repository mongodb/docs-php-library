<?php

require 'vendor/autoload.php';

use MongoDB\Client;

$client = new Client('<connection string>');

// start-db-coll
$db = $client->sample_restaurants;
$collection = $db->restaurants;
// end-db-coll

// Retrieves documents matching the "name" field query and projects their "name", "cuisine", and "borough" values
// start-project-include
$options = [
    'projection' => [
        'name' => 1,
        'cuisine' => 1,
        'borough' => 1,
    ],
];

$cursor = $collection->find(['name' => 'Emerald Pub'], $options);
foreach ($cursor as $doc) {
    echo json_encode($doc), PHP_EOL;
}
// end-project-include

// Retrieves documents matching the "name" field query
// and projects their "name", "cuisine", and "borough" values while excluding the "_id" values
// start-project-include-without-id
$options = [
    'projection' => [
        '_id' => 0,
        'name' => 1,
        'cuisine' => 1,
        'borough' => 1,
    ],
];

$cursor = $collection->find(['name' => 'Emerald Pub'], $options);
foreach ($cursor as $doc) {
    echo json_encode($doc), PHP_EOL;
}
// end-project-include-without-id

// Retrieves documents matching the "name" field query and excludes their "grades" and "address" values when printing
// start-project-exclude
$options = [
    'projection' => [
        'grades' => 0,
        'address' => 0,
    ],
];

$cursor = $collection->find(['name' => 'Emerald Pub'], $options);
foreach ($cursor as $doc) {
    echo json_encode($doc), PHP_EOL;
}
// end-project-exclude

?>