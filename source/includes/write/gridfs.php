<?php
require 'vendor/autoload.php'; // include Composer's autoloader

use MongoDB\Client;
use MongoDB\BSON\ObjectID;
use MongoDB\GridFS\Bucket;
use MongoDB\Driver\Manager;

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);

// start-to-json
function toJSON(object $document): string
{
    return MongoDB\BSON\Document::fromPHP($document)->toRelaxedExtendedJSON();
}
// end-to-json

// Creates a GridFS bucket or references an existing one
// start-create-bucket
$bucket = $client->db->selectGridFSBucket();
// end-create-bucket

// Creates or references a GridFS bucket with a custom name
// start-create-custom-bucket
$custom_bucket = $client->db->selectGridFSBucket(
    ['bucketName' => 'myCustomBucket']
);
// end-create-custom-bucket

// Uploads a file called "my_file" to the GridFS bucket and writes data to it
// start-open-upload-stream
$stream = $bucket->openUploadStream('my_file', [
    'metadata' => ['contentType' => 'text/plain']
]);
fwrite($stream, 'Data to store');
fclose($stream);
// end-open-upload-stream

// Uploads data to a stream, then writes the stream to a GridFS file
// start-upload-from-stream
$file = fopen('/path/to/input_file', 'rb');
$bucket->uploadFromStream('new_file', $file);
// end-upload-from-stream

// Prints information about each file in the bucket
// start-retrieve-file-info
$files = $bucket->find();
foreach ($files as $file_doc) {
    echo toJSON($file_doc), PHP_EOL;
}
// end-retrieve-file-info

// Downloads the "my_file" file from the GridFS bucket and prints its contents
// start-open-download-stream-name
$stream = $bucket->openDownloadStreamByName('my_file');
$contents = stream_get_contents($stream);
echo $contents, PHP_EOL;
fclose($stream);
// end-open-download-stream-name

// Downloads a file from the GridFS bucket by referencing its ObjectID value
// start-download-files-id
$stream = $bucket->openDownloadStream(new ObjectID('66e0a5487c880f844c0a32b1'));
$contents = stream_get_contents($stream);
fclose($stream);
// end-download-files-id

// Downloads the original "my_file" file from the GridFS bucket
// start-download-file-revision
$stream = $bucket->openDownloadStreamByName('my_file', ['revision' => 0]);
$contents = stream_get_contents($stream);
fclose($stream);
// end-download-file-revision

// Downloads an entire GridFS file to a download stream
// start-download-to-stream
$stream = fopen('/path/to/output_file', 'wb');
$bucket->downloadToStream(
    new ObjectID('66e0a5487c880f844c0a32b1'),
    $stream,
);
// end-download-to-stream

// Renames a file from the GridFS bucket with the specified ObjectID
// start-rename-files
$bucket->rename(new ObjectID('66e0a5487c880f844c0a32b1'), 'new_file_name');
// end-rename-files

// Deletes a file from the GridFS bucket with the specified ObjectID
// start-delete-files
$bucket->delete(new ObjectID('66e0a5487c880f844c0a32b1'));
// end-delete-files
