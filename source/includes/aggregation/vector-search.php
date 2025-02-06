<?php

require 'vendor/autoload.php';

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

$collection = $client->sample_mflix->embedded_movies;

// start-basic-query
$pipeline = new Pipeline(
    Stage::vectorSearch(
        index: 'vector_index',
        path: 'plot_embedding',
        queryVector: [-0.0016261312, -0.028070757, -0.011342932],
        numCandidates: 150,
        limit: 10,
    )
);

$cursor = $collection->aggregate($pipeline);

foreach ($cursor as $doc) {
    echo json_encode($doc), PHP_EOL;
}
// end-basic-query

// start-score-query
$pipeline = new Pipeline(
    Stage::vectorSearch(
        index: 'vector_index',
        path: 'plot_embedding',
        queryVector: [-0.0016261312, -0.028070757, -0.011342932],
        numCandidates: 150,
        limit: 10,
    ),
    Stage::project(
        _id: 0,
        title: 1,
        score: ['$meta' => 'vectorSearchScore'],
    ),
);

$cursor = $collection->aggregate($pipeline);

foreach ($cursor as $doc) {
    echo json_encode($doc), PHP_EOL;
}
// end-score-query