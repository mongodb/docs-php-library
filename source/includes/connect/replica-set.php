<?php

// Replace the placeholder with your connection string
$uri = "mongodb://host1:27017/?replicaSet=sampleRS";

// Create a MongoDB client
$client = new Client($uri);