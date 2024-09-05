<?php

require __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

$client = new Client('<connection string>');
$collection = $client-><database>-><collection>;

// start-single-field
$result = $collection->createIndex(['<field name>' => 1]);
// end-single-field

// start-compound
$indexName = $collection->createIndex(
    ['<field name 1>' => 1, '<field name 2>' => 1]
);
// end-compound

// start-multikey
$result = $collection->createIndex(['<array field name>' => 1]);
// end-multikey

// start-search-create
$result = $collection->createSearchIndex(
    ['mappings' => ['dynamic' => true]],
    ['name' => '<index name>']
);
// end-search-create

// start-search-list
foreach ($collection->listSearchIndexes() as $indexInfo) {
    var_dump($indexInfo);
}
// end-search-list

// start-search-update
$result = $collection->updateSearchIndex(
    ['name' => '<index name>'],
    ['mappings' => ['dynamic' => true]],
 );
// end-search-update

// start-search-delete
$result = $collection->dropIndex('<index name>');
// end-search-delete

// start-text
$result = $collection->createIndex(['<field name>' => 'text']);
// end-text

// start-geo
$result = $collection->createIndex(
    [ '<GeoJSON object field>' => '2dsphere'], ['name' => '<index name>']
);
// end-geo

// start-unique
$result = $collection->createIndex(['<field name>' => 1], ['unique' => true]);
// end-unique

// start-wildcard
$result = $collection->createIndex(['$**' => 1]);
// end-wildcard

// start-clustered
$options = [
    'clusteredIndex' => [
        'key' => ['_id' => 1],
        'unique' => true
    ]
];

$database->createCollection('<collection name>', $options);
// end-clustered

// start-list
foreach ($collection->listIndexes() as $indexInfo) {
    var_dump($indexInfo);
}
// end-list

// start-remove
$result = $collection->dropIndex('<index name>');
// end-remove