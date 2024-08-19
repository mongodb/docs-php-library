<?php

try {
    // Replace the placeholder with your Atlas connection string
    $uri = "<connection string>";

    // Create a MongoDB client with server API options
    $client = new MongoDB\Client($uri, [], [
        'serverApi' => [
            'version' => '1'
        ]
    ]);

    // Ping the server to verify that the connection works
    $admin = $client->admin;
    $command = new MongoDB\Driver\Command(['ping' => 1]);
    $result = $admin->command($command)->toArray();

    echo json_encode($result), "\n";
    echo "Pinged your deployment. You successfully connected to MongoDB!\n";
} catch (Exception $e) {
    echo "An exception occurred: ", $e->getMessage(), "\n";
    exit(EXIT_FAILURE);
}
?>