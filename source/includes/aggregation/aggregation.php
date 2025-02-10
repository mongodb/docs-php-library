<?php

use MongoDB\BSON\UTCDateTime;
use MongoDB\Builder\Accumulator;
use MongoDB\Builder\Expression;
use MongoDB\Builder\Query;
use MongoDB\Builder\Stage;
use MongoDB\Builder\Type\Sort;

require 'vendor/autoload.php';

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

$collection = $client->sample_restaurants->restaurants;

// Retrieves documents with a cuisine value of "Bakery", groups them by "borough", and
// counts each borough's matching documents
// start-array-match-group
$pipeline = [
    ['$match' => ['cuisine' => 'Bakery']],
    ['$group' => ['_id' => '$borough', 'count' => ['$sum' => 1]]],
];

$cursor = $collection->aggregate($pipeline);

foreach ($cursor as $doc) {
    echo json_encode($doc), PHP_EOL;
}
// end-array-match-group

// Performs the same aggregation operation as above but asks MongoDB to explain it
// start-array-explain
$pipeline = [
    ['$match' => ['cuisine' => 'Bakery']],
    ['$group' => ['_id' => '$borough', 'count' => ['$sum' => 1]]],
];

$aggregate = new MongoDB\Operation\Aggregate(
    $collection->getDatabaseName(),
    $collection->getCollectionName(),
    $pipeline
);

$result = $collection->explain($aggregate);
echo json_encode($result), PHP_EOL;
// end-array-explain

// start-builder-match-group
$pipeline = [
    Stage::match(
        date: [
            Query::gte(new UTCDateTime(new DateTimeImmutable('2014-01-01'))),
            Query::lt(new UTCDateTime(new DateTimeImmutable('2015-01-01'))),
        ],
    ),
    Stage::group(
        _id: Expression::dateToString(Expression::dateFieldPath('date'), '%Y-%m-%d'),
        totalSaleAmount: Accumulator::sum(
            Expression::multiply(
                Expression::numberFieldPath('price'),
                Expression::numberFieldPath('quantity'),
            ),
        ),
        averageQuantity: Accumulator::avg(
            Expression::numberFieldPath('quantity'),
        ),
        count: Accumulator::sum(1),
    ),
    Stage::sort(
        totalSaleAmount: Sort::Desc,
    ),
];

$cursor = $collection->aggregate($pipeline);

foreach ($cursor as $doc) {
    echo json_encode($doc), PHP_EOL;
}
// end-builder-match-group

// start-builder-unwind
$pipeline = [
    Stage::unwind(Expression::arrayFieldPath('items')),
    Stage::unwind(Expression::arrayFieldPath('items.tags')),
    Stage::group(
        _id: Expression::fieldPath('items.tags'),
        totalSalesAmount: Accumulator::sum(
            Expression::multiply(
                Expression::numberFieldPath('items.price'),
                Expression::numberFieldPath('items.quantity'),
            ),
        ),
    ),
];

$cursor = $collection->aggregate($pipeline);

foreach ($cursor as $doc) {
    echo json_encode($doc), PHP_EOL;
}
// end-builder-unwind

// start-builder-lookup
$pipeline = [
    Stage::lookup(
        from: 'inventory',
        localField: 'item',
        foreignField: 'sku',
        as: 'inventory_docs',
    ),
];

/* Perform the aggregation on the orders collection */
$cursor = $collection->aggregate($pipeline);

foreach ($cursor as $doc) {
    echo json_encode($doc), PHP_EOL;
}
// end-builder-lookup
