<?php

require 'vendor/autoload.php';

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

// start-run-bulk
$restaurantCollection = $client->sample_restaurants->restaurants;

$result = $restaurantCollection->bulkWrite(
    [
        [
            'insertOne' => [
                ['name' => 'Mongo\'s Deli'],
                ['cuisine' => 'Sandwiches'],
                ['borough' => 'Manhattan'],
                ['restaurant_id' => '1234'],
            ],
        ],
        [
            'updateOne' => [
                ['name' => 'Mongo\'s Deli'],
                ['$set' => ['cuisine' => 'Sandwiches and Salads']],
            ],
        ],
        [
            'deleteMany' => [
                ['borough' => 'Manhattan'],
            ],
        ],
    ]
);
// end-run-bulk

// start-bulk-options
$result = $restaurantCollection->bulkWrite(
    [
        [
            'insertOne' => [
                ['name' => 'Mongo\'s Pizza'],
                ['cuisine' => 'Italian'],
                ['borough' => 'Queens'],
                ['restaurant_id' => '5678'],
            ],
        ],
        [
            'deleteOne' => [
                ['restaurant_id' => '5678'],
            ],
        ],
    ],
    ['ordered' => false]
);
// end-bulk-options

// start-bulk-client-insert-one
$restaurantCollection = $client->sample_restaurants->restaurants;
$movieCollection = $client->sample_mflix->movies;

$bulkWrite = MongoDB\ClientBulkWrite::createWithCollection($restaurantCollection);
$bulkWrite->insertOne(['name' => 'Mongo Deli', 'cuisine' => 'Sandwiches']);

$bulkWrite = $bulkWrite->withCollection($movieCollection);
$bulkWrite->insertOne(['title' => 'The Green Ray', 'year' => 1986]);
// end-bulk-client-insert-one

// start-bulk-client-update-one
$restaurantCollection = $client->sample_restaurants->restaurants;
$bulkWrite = MongoDB\ClientBulkWrite::createWithCollection($restaurantCollection);

$bulkWrite->updateOne(
    ['name' => 'Dandelion Bakery'],
    ['$set' => ['grade' => 'B+']],
    ['upsert' => true],
);
// end-bulk-client-update-one

// start-bulk-client-update-many
$restaurantCollection = $client->sample_restaurants->restaurants;
$bulkWrite = MongoDB\ClientBulkWrite::createWithCollection($restaurantCollection);

$bulkWrite->updateMany(
    ['name' => 'Starbucks'],
    ['$set' => ['cuisine' => 'Coffee (Chain)']],
);
// end-bulk-client-update-many

// start-bulk-client-replace-one
$restaurantCollection = $client->sample_restaurants->restaurants;
$bulkWrite = MongoDB\ClientBulkWrite::createWithCollection($restaurantCollection);

$bulkWrite->replaceOne(
    ['name' => 'Dandelion Bakery'],
    ['name' => 'Flower Patisserie', 'cuisine' => 'Bakery & Cafe'],
);
// end-bulk-client-replace-one

// start-bulk-client-delete-one
$restaurantCollection = $client->sample_restaurants->restaurants;
$bulkWrite = MongoDB\ClientBulkWrite::createWithCollection($restaurantCollection);

$bulkWrite->deleteOne(
    ['borough' => 'Queens'],
);
// end-bulk-client-delete-one

// start-bulk-client-delete-many
$restaurantCollection = $client->sample_restaurants->restaurants;
$bulkWrite = MongoDB\ClientBulkWrite::createWithCollection($restaurantCollection);

$bulkWrite->deleteMany(
    ['name' => ['$regex' => 'p{2,}']],
);
// end-bulk-client-delete-many

// start-bulk-client
$restaurantCollection = $client->sample_restaurants->restaurants;
$movieCollection = $client->sample_mflix->movies;

$bulkWrite = MongoDB\ClientBulkWrite::createWithCollection($restaurantCollection);
$bulkWrite->insertOne(['name' => 'Mongo Deli', 'cuisine' => 'Sandwiches']);
$bulkWrite->updateOne(
    ['name' => 'Dandelion Bakery'],
    ['$set' => ['grade' => 'B+']],
    ['upsert' => true],
);

$bulkWrite = $bulkWrite->withCollection($movieCollection);
$bulkWrite->insertOne(['title' => 'The Green Ray', 'year' => 1986]);
$bulkWrite->deleteMany(
    ['title' => ['$regex' => 'd{2,}']],
);
$bulkWrite->replaceOne(
    ['runtime' => ['$gte' => 200]],
    ['title' => 'Seven Samurai', 'runtime' => 203],
);

$result = $client->bulkWrite($bulkWrite);
echo 'Inserted documents: ', $result->getInsertedCount(), PHP_EOL;
echo 'Modified documents: ', $result->getModifiedCount(), PHP_EOL;
echo 'Deleted documents: ', $result->getDeletedCount(), PHP_EOL;
// end-bulk-client

// start-bulk-client-options
$bulkWrite = MongoDB\ClientBulkWrite::createWithCollection($collection, ['ordered' => false]);
// end-bulk-client-options
