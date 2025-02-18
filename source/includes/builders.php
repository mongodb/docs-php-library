<?php

// start-imports
use MongoDB\Builder\Pipeline;
use MongoDB\Builder\Query;
use MongoDB\Builder\Stage;
// end-imports

require 'vendor/autoload.php';

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

// start-db-coll
$collection = $client->sample_geospatial->shipwrecks;
// end-db-coll

// start-find
$docs = $collection->find(Query::query(
    feature_type: Query::eq('Wrecks - Visible'),
    coordinates: Query::near(
        Query::geometry(
            type: 'Point',
            coordinates: [-79.9, 9.3],
        ),
        maxDistance: 10000,
    )
));

foreach ($docs as $doc) {
    echo json_encode($doc), PHP_EOL;
}
// end-find

// start-deleteone
$result = $collection->deleteOne(Query::query(
    feature_type: Query::regex('nondangerous$', '')
));

echo 'Deleted documents: ', $result->getDeletedCount(), PHP_EOL;
// end-deleteone

// start-updateone
$result = $collection->updateOne(
    Query::query(watlev: Query::eq('partly submerged at high water')),
    new Pipeline(
        Stage::set(year: 1870),
    ),
);

echo 'Updated documents: ', $result->getModifiedCount(), PHP_EOL;
// end-updateone

// start-cs
$pipeline = [
    Stage::match(operationType: Query::eq('update')),
    Stage::project(operationType: 1, ns: 1, fullDocument: 1),
];

$changeStream = $collection->watch(
    $pipeline,
    ['fullDocument' => MongoDB\Operation\Watch::FULL_DOCUMENT_UPDATE_LOOKUP]
);

for ($changeStream->rewind(); true; $changeStream->next()) {
    if (! $changeStream->valid()) {
        continue;
    }
    $event = $changeStream->current();
    echo json_encode($event), PHP_EOL;

    if ($event['operationType'] === 'invalidate') {
        break;
    }
}
// end-cs
