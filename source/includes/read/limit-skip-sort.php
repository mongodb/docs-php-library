<?php

require 'vendor/autoload.php';

$client = new MongoDB\Client('<connection string>');

// start-db-coll
$db = $client->sample_restaurants;
$collection = $db->restaurants;
// end-db-coll

// Retrieves 5 documents that have a "cuisine" value of "Italian"
// start-limit
$options = [
    'limit' => 5,
];
$cursor = $collection->find(['cuisine' => 'Italian'], $options);

foreach ($cursor as $doc) {
    echo json_encode($doc) . PHP_EOL;
}
// end-limit

// Retrieves documents with a "cuisine" value of "Italian" and sorts in ascending "name" order
// start-sort
$options = [
    'sort' => ['name' => 1],
];

$cursor = $collection->find(['cuisine' => 'Italian'], $options);
foreach ($cursor as $doc) {
    echo json_encode($doc) . PHP_EOL;
}
// end-sort

// Retrieves documents with a "borough" value of "Manhattan" but skips the first 10 results
// start-skip
$options = [
    'skip' => 10,
];

$cursor = $collection->find(['borough' => 'Manhattan'], $options);
foreach ($cursor as $doc) {
    echo json_encode($doc) . PHP_EOL;
}
// end-skip

// Retrieves 5 documents with a "cuisine" value of "Italian", skips the first 10 results,
// and sorts by ascending "name" order
// start-limit-sort-skip
$options = [
    'sort' => ['name' => 1],
    'limit' => 5,
    'skip' => 10,
];

$cursor = $collection->find(['cuisine' => 'Italian'], $options);
foreach ($cursor as $doc) {
    echo json_encode($doc) . PHP_EOL;
}
// end-limit-sort-skip

?>