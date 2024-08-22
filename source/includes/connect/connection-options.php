// start-connection-uri
<?php

// Replace the placeholders with your actual hostname, port, and path to the certificate key file
$uri = "mongodb://<hostname>:<port>/?tls=true&tlsCertificateKeyFile=/path/to/file.pem";

// Create a MongoDB client
$client = new MongoDB\Client($uri);
// end-connection-uri

// start-client-options
<?php

// Replace the placeholders with your actual hostname and port
$uri = "mongodb://<hostname>:<port>/";

// Set the connection options
$uriOptions = [
    'tls' => true,
    'tlsCertificateKeyFile' => '/path/to/file.pem'
];

// Create a MongoDB client with the URI and options
$client = new Client($uri, $uriOptions);
// end-client-options

// start-uri-object
#include <mongocxx/uri.hpp>
#include <mongocxx/client.hpp>
#include <mongocxx/instance.hpp>

int main()
{
    mongocxx::instance instance;
    mongocxx::uri uri("mongodb://<hostname>:<port>/?tls=true");
    mongocxx::client client(uri);
    auto is_tls_enabled = uri.tls();
}
// end-uri-object