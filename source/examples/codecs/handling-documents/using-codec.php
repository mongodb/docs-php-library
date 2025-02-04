<?php

use MongoDB\Client;

$client = new Client();
$collection = $client->getCollection('test', 'person', [
    'codec' => new PersonCodec(),
]);

$person = new Person('Jane Doe');
$collection->insertOne($person);

$person = $collection->findOne();
