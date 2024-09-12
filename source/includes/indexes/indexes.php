<?php

require __DIR__ . '/../vendor/autoload.php';

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

$database = $client->sample_mflix;
$collection = $database->movies;

// start-list-indexes
foreach ($collection->listIndexes() as $indexInfo) {
    echo $indexInfo;
}
// end-list-indexes

// start-remove-index
$collection->dropIndex('_title_');
// end-remove-index

// start-remove-all-indexes
$collection->dropIndexes();
// end-remove-all-indexes

// start-index-single
$indexName = $collection->createIndex(['title' => 1]);
// end-index-single

// start-index-single-query
$document = $collection->findOne(['title' => 'Sweethearts']);
echo json_encode($document) , PHP_EOL;
// end-index-single-query

// start-multikey
$indexName = $collection->createIndex(['cast' => 1]);
// end-multikey

// start-index-array-query
$document = $collection->findOne(
    ['cast' => ['$in' => ['Aamir Khan', 'Kajol']]]
);
echo json_encode($document) , PHP_EOL;
// end-index-array-query
