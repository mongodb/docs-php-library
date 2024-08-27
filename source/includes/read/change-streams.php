<?php
require 'vendor/autoload.php'; 

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

// start-db-coll
$collection = $client->sample_restaurants->restaurants;
// end-db-coll

// Monitors and prints changes to the "restaurants" collection
// start-open-change-stream
$changeStream = $collection->watch();

foreach ($changeStream as $event) {
    echo json_encode($event) . PHP_EOL;
}
// end-open-change-stream

// Updates a document that has a "name" value of "Blarney Castle"
// start-update-for-change-stream
$result = $collection->updateOne(
    ['name' => 'Blarney Castle'],
    ['$set' => ['cuisine' => 'Irish']]
);
// end-update-for-change-stream

// Passes a pipeline argument to watch() to monitor only update operations
// start-change-stream-pipeline
$pipeline = [['$match' => ['operationType' => 'update']]];
$changeStream = $collection->watch($pipeline);

foreach ($changeStream as $event) {
    echo json_encode($event) . PHP_EOL;
}
// end-change-stream-pipeline

// Passes an options argument to watch() to include the post-image of updated documents
// start-change-stream-post-image
$options = ['fullDocument' => MongoDB\Operation\Watch::FULL_DOCUMENT_UPDATE_LOOKUP];
$changeStream = $collection->watch([], $options);

foreach ($changeStream as $event) {
    echo json_encode($event) . PHP_EOL;
}
// end-change-stream-post-image
