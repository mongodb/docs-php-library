<?php
require 'vendor/autoload.php'; // include Composer's autoloader

use MongoDB\Client;
use MongoDB\BSON\ObjectID;
use MongoDB\GridFS\Bucket;

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

// start create bucket
$db = $client->db;
$bucket = $db->selectGridFSBucket();
// end create bucket

// start create bucket explicit
$manager = new Manager('<connection string>');
$bucket = new Bucket($manager, 'db');
// end create bucket explicit

// start create custom bucket
$db = $client->db;
$custom_bucket = $db->selectGridFSBucket(['bucketName' => 'myCustomBucket']);
// end create custom bucket

// start upload files
$stream = $bucket->openUploadStream('my_file', [
    'chunkSizeBytes' => 1048576,
    'metadata' => ['contentType' => 'text/plain']
]);
$stream->write('data to store');
$stream->close();
// end upload files

// start retrieve file info
$files = $bucket->find();
foreach ($files as $file_doc) {
    var_dump($file_doc);
}
// end retrieve file info

// start download files name
$stream = $bucket->openDownloadStreamByName('my_file');
$contents = stream_get_contents($stream);
$stream->close();
// echo $contents if necessary
// end download files name

// start download files id
$stream = $bucket->openDownloadStream(new ObjectID('66b3c86e672a17b6c8a4a4a9'));
$contents = stream_get_contents($stream);
$stream->close();
// echo $contents if necessary
// end download files id

// start rename files
$bucket->rename(new ObjectID('66b3c86e672a17b6c8a4a4a9'), 'new_file_name');
// end rename files

// start delete files
$bucket->delete(new ObjectID('66b3c86e672a17b6c8a4a4a9'));
// end delete files
