<?php
require 'vendor/autoload.php';

use MongoDB\BSON\Document;
use MongoDB\Driver\ReadConcern;
use MongoDB\Driver\ReadPreference;
use MongoDB\Driver\WriteConcern;

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

// Accesses the "test_database" database
// start-access-database
$db = $client->selectDatabase('test_database');
// end-access-database

// Accesses the "test_collection" collection
// start-access-collection
$collection = $client->test_database->selectCollection('test_collection');
//$collection->insertOne(['name' => 'first doc']);
// end-access-collection

// Explicitly creates the "example_collection" collection
// start-create-collection
$result = $client->test_database->createCollection('example_collection');
//$db->example_collection->insertOne(['name' => 'second doc']);
// end-create-collection

// Lists the collections in the "test_database" database
// start-find-collections
foreach ($client->test_database->listCollections() as $collectionInfo) {
    print_r($collectionInfo) . PHP_EOL;
}
// end-find-collections

// Deletes the "test_collection" collection
// start-drop-collection
$client->test_database->dropCollection('test_collection');
// end-drop-collection

// Sets read and write settings for the "test_database" database
// start-database-settings
$readPreference = new ReadPreference(ReadPreference::RP_SECONDARY);
$readConcern = new ReadConcern(ReadConcern::LOCAL);
$writeConcern = new WriteConcern(WriteConcern::MAJORITY);

$db = $client->selectDatabase('test_database', [
    'readPreference' => $readPreference,
    'readConcern' => $readConcern,
    'writeConcern' => $writeConcern,
]);
// end-database-settings

// Sets read and write settings for the "test_collection" collection
// start-collection-settings
$readPreference = new ReadPreference(ReadPreference::RP_PRIMARY);
$readConcern = new ReadConcern(ReadConcern::AVAILABLE);
$writeConcern = new WriteConcern(WriteConcern::MAJORITY);

$collection = $client->selectCollection('test_database', 'test_collection', [
    'readPreference' => $readPreference,
    'readConcern' => $readConcern,
    'writeConcern' => $writeConcern,
]);

// end-collection-settings

// Instructs the library to prefer New York data center reads using a tag set
// start-tag-set
$readPreference = new ReadPreference(
    ReadPreference::RP_SECONDARY,
    [
        ['dc' => 'ny'],
        ['dc' => 'sf'],
    ],
);

$db = $client->selectDatabase(
    'test_database',
    ['readPreference' => $readPreference],
);

// end-tag-set

// Instructs the library to distribute reads between members within 35 milliseconds
// of the closest member's ping time
// start-local-threshold
$options = [
    'replicaSet' => 'repl0',
    'readPreference' => new ReadPreference(ReadPreference::RP_SECONDARY_PREFERRED),
    'localThresholdMS' => 35
];

$client = new Client('<connection string>', [], $options);
// end-local-threshold