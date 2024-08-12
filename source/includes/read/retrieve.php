<?php
require 'vendor/autoload.php'; // includes the library

$uri = "<connection string>";
$client = new MongoDB\Client($uri);

// start-db-coll
$db = $client->sample_training;
$collection = $db->companies;
// end-db-coll

// Finds one document with a "name" value of "LinkedIn"
// start-find-one
$document = $collection->findOne(['name' => 'LinkedIn']);
echo json_encode($document) . "\n";
// end-find-one

// Finds documents with a "founded_year" value of 1970
// start-find-many
$results = $collection->find(['founded_year' => 1970]);
// end-find-many

// Prints documents with a "founded_year" value of 1970
// start-cursor
foreach ($results as $doc) {
    echo json_encode($doc) . "\n";
}
// end-cursor

// Finds and prints up to 5 documents with a "number_of_employees" value of 1000
// start-modify
$options = [
    'limit' => 5,
];

$results = $collection->find(['number_of_employees' => 1000], $options);

foreach ($results as $doc) {
    echo json_encode($doc) . "\n";
}
// end-modify
?>