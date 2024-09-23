<?php

require __DIR__ . '/../vendor/autoload.php';

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

// Start example code here

// End example code here

$admin = $client->admin;
$result = $admin->command(['ping' => 1]);

if ($result) {
    echo 'Successfully pinged the MongoDB server.', PHP_EOL;
} else {
    echo 'Ping to MongoDB server failed.', PHP_EOL;
}