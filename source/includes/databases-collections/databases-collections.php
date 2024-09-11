<?php
require 'vendor/autoload.php';

use MongoDB\BSON\Document;

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

// start-access-database
$db = $client->selectDatabase('test_database');
// end-access-database

// start-access-collection
$collection = $client->test_database->selectCollection('test_collection');
// end-access-collection

// start-create-collection
$result = $client->test_database->createCollection('example_collection');
// end-create-collection

// start-find-collections
foreach ($db->listCollections() as $collectionInfo) {
    echo json_encode($collectionInfo), PHP_EOL;
}
// end-find-collections

// start-drop-collection
$db->dropCollection('test_collection');
// end-drop-collection

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

// start-collection-settings
$readPreference = new ReadPreference(ReadPreference::RP_PRIMARY);
$readConcern = new ReadConcern(ReadConcern::AVAILABLE);
$writeConcern = new WriteConcern(WriteConcern::MAJORITY);

// Specify the preferences when selecting a collection
$collection = $client->selectCollection('test_database', 'test_collection', [
    'readPreference' => $readPreference,
    'readConcern' => $readConcern,
    'writeConcern' => $writeConcern,
]);

// end-collection-settings

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

// start-local-threshold
$options = [
    'replicaSet' => 'repl0',
    'readPreference' => new ReadPreference(ReadPreference::RP_SECONDARY_PREFERRED),
    'localThresholdMS' => 35
];

$client = new Client('<connection string>', [], $options);
// end-local-threshold