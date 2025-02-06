<?php

require 'vendor/autoload.php';

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

$collection = $client->sample_restaurants->restaurants;

// start-compound-search-query
$pipeline = new Pipeline(
	Stage::search(
		Search::compound(
			must: [
				Search::text(
					query: 'kitchen',
					path: 'name',
				),
			],
			should: [
				Search::text(
					query: 'american',
					path: 'cuisine',
				),
			],
			filter: [
				Search::text(
					query: 'Queens',
					path: 'borough',
				),
			],
		),
	),
);

$cursor = $collection->aggregate($pipeline);

foreach ($cursor as $doc) {
	echo json_encode($doc), PHP_EOL;
}
// end-compound-search-query

// start-autocomplete-search-query
$pipeline = new Pipeline(
	Stage::search(
		Search::autocomplete(
			query: 'Lucy',
			path: 'name',
		),
	),
	Stage::limit(10),
	Stage::project(_id: 0, title: 1),
);

$cursor = $collection->aggregate($pipeline);

foreach ($cursor as $doc) {
	echo json_encode($doc), PHP_EOL;
}
// end-autocomplete-search-query