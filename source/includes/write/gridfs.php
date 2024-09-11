<?php
require 'vendor/autoload.php'; // include Composer's autoloader

use MongoDB\Client;
use MongoDB\BSON\ObjectID;
use MongoDB\GridFS\Bucket;

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

// Creates a GridFS bucket or references an existing one
// start create bucket
$db = $client->db;
$bucket = $db->selectGridFSBucket();
// end create bucket

// Constructs a GridFS bucket
// start create bucket explicit
$manager = new Manager('<connection string>');
$bucket = new Bucket($manager, 'db');
// end create bucket explicit

// Creates or references a GridFS bucket with a custom name
// start create custom bucket
$custom_bucket = $client->db->selectGridFSBucket(
    ['bucketName' => 'myCustomBucket']
);
// end create custom bucket

// Uploads a file called "my_file" to the GridFS bucket and writes data to it
// start upload files
$stream = $bucket->openUploadStream('my_file', [
    'chunkSizeBytes' => 1048576,
    'metadata' => ['contentType' => 'text/plain']
]);
fwrite($stream, 'Data to store');
fclose($stream);
// end upload files

// Prints information about each file in the bucket
// start retrieve file info
$files = $bucket->find();
foreach ($files as $file_doc) {
    echo json_encode($file_doc) , PHP_EOL;
}
// end retrieve file info

// Downloads the "my_file" file from the GridFS bucket and prints its contents
// start download files name
$stream = $bucket->openDownloadStreamByName('my_file');
$contents = stream_get_contents($stream);
echo json_encode($contents) , PHP_EOL;
fclose($stream);
// end download files name

// Downloads a file from the GridFS bucket by referencing its ObjectID value
// start download files id
$stream = $bucket->openDownloadStream(new ObjectID('66e0a5487c880f844c0a32b1'));
$contents = stream_get_contents($stream);
fclose($stream);
// end download files id

// Renames a file from the GridFS bucket with the specified ObjectID
// start rename files
$bucket->rename(new ObjectID('66e0a5487c880f844c0a32b1'), 'new_file_name');
// end rename files

// Deletes a file from the GridFS bucket with the specified ObjectID
// start delete files
$bucket->delete(new ObjectID('66e0a5487c880f844c0a32b1'));
// end delete files
