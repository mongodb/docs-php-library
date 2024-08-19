<?php

require __DIR__ . '/../vendor/autoload.php';

use MongoDB\Client;

$client = new Client('<connection string>');
$collection = $client->sample_mflix->movies;

$filter = ['title' => 'The Shawshank Redemption'];
$result = $collection->findOne($filter);

if ($result) {
    echo json_encode($result, JSON_PRETTY_PRINT);
} else {
    echo "Document not found";
}
