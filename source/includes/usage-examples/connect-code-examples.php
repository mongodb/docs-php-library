<?php

require 'vendor/autoload.php';

use MongoDB\Client;

// Connects to a local MongoDB deployment
// start-local
$uri = 'mongodb://localhost:27017/';
$client = new Client($uri);
// end-local

// Connects to a MongoDB Atlas deployment
// start-atlas
$uri = '<Atlas connection string>';
$client = new Client($uri);
// end-atlas

// Connects to a replica set
// start-replica-set
$uri = 'mongodb://<replica set member>:<port>/?replicaSet=<replica set name>';
$client = new Client($uri);
// end-replica-set

// Connects to a MongoDB deployment and enables TLS using client
// options
// start-enable-tls-client
$client = new Client(
    'mongodb://<hostname>:<port>/',
    ['tls' => true],
);
// end-enable-tls-client

// Connects to a MongoDB deployment and enables TLS using connection URI
// parameters
// start-enable-tls-uri
$uri = 'mongodb://<hostname>:<port>/?tls=true';
$client = new Client($uri);
// end-enable-tls-uri

// Connects to a MongoDB deployment, enables TLS, and specifies the path to 
// a CA file using client options
// start-ca-file-client
$client = new Client(
    'mongodb://<hostname>:<port>/',
    ['tls' => true, 'tlsCAFile' => '/path/to/ca.pem'],
);
// end-ca-file-client

// Connects to a MongoDB deployment, enables TLS, and specifies the path to 
// a CA file using connection URI parameters
// start-ca-file-uri
$uri = 'mongodb://<hostname>:<port>/?tls=true&tlsCAFile=/path/to/ca.pem';
$client = new Client($uri);
// end-ca-file-uri

// Connects to a MongoDB deployment, enables TLS, and prevents OCSP endpoint checks
// using client options
// start-disable-ocsp-client
$client = new Client(
    'mongodb://<hostname>:<port>/',
    ['tls' => true, 'tlsDisableOCSPEndpointCheck' => true],
);
// end-disable-ocsp-client

// Connects to a MongoDB deployment, enables TLS, and prevents OCSP endpoint checks
// using connection URI parameters
// start-disable-ocsp-uri
$uri = 'mongodb://<hostname>:<port>/?tls=true&tlsDisableOCSPEndpointCheck=true';
$client = new Client($uri);
// end-disable-ocsp-uri

// Connects to a TLS-enabled deployment and instructs the driver to check the
// server certificate against a CRL
// start-crl
$client = new Client(
    'mongodb://<hostname>:<port>/',
    ['tls' => true],
    ['crl_file' => '/path/to/file.pem'],
);
// end-crl

// Presents a client certificate to prove identity
// using client options
// start-client-cert-client
$client = new Client(
    'mongodb://<hostname>:<port>/',
    ['tls' => true, 'tlsCertificateKeyFile' => '/path/to/client.pem'],
);
// end-client-cert-client

//  Presents a client certificate to prove identity
// using connection URI parameters
// start-client-cert-uri
$uri = 'mongodb://<hostname>:<port>/?tls=true&tlsCertificateKeyFile=/path/to/client.pem';
$client = new Client($uri);
// end-client-cert-uri

// Specifies the password for a client certificate using client options
// start-key-file-client
$client = new Client(
    'mongodb://<hostname>:<port>/',
    [
        'tls' => true,
        'tlsCertificateKeyFile' => '/path/to/client.pem',
        'tlsCertificateKeyFilePassword' => '<password>'
    ],
);
// end-key-file-client

// Specifies the password for a client certificate using connection URI parameters
// start-key-file-uri
$uri = 'mongodb://<hostname>:<port>/?tls=true&tlsCertificateKeyFile=/path/to/client.pem&tlsCertificateKeyFilePassword=<password>';
$client = new Client($uri);
// end-key-file-uri

// Connects to a TLS-enabled deployment and disables server certificate verification
// using client options
// start-insecure-tls-client
$client = new Client(
    'mongodb://<hostname>:<port>/',
    ['tls' => true, 'tlsInsecure' => true],
);
// end-insecure-tls-client

// Connects to a TLS-enabled deployment and disables server certificate verification
// using connection URI parameters
// start-insecure-tls-uri
$uri = 'mongodb://<hostname>:<port>/?tls=true&tlsInsecure=true';
$client = new Client($uri);
// end-insecure-tls-uri

// Disables certificate validation using client options
// start-disable-cert-client
$client = new Client(
    'mongodb://<hostname>:<port>/',
    ['tls' => true, 'tlsAllowInvalidCertificates' => true],
);
// end-disable-cert-client

// Disables certificate validation using connection URI parameters
// start-disable-cert-uri
$uri = 'mongodb://<hostname>:<port>/?tls=true&tlsAllowInvalidCertificates=true';
$client = new Client($uri);
// end-disable-cert-uri

// Connects to a TLS-enabled deployment and disables hostname verification
// using client options
// start-disable-hostname-client
$client = new Client(
    'mongodb://<hostname>:<port>/',
    ['tls' => true, 'tlsAllowInvalidHostnames' => true],
);
// end-disable-hostname-client

// Connects to a TLS-enabled deployment and disables hostname verification
// using connection URI parameters
// start-disable-hostname-uri
$uri = 'mongodb://<hostname>:<port>/?tls=true&tlsAllowInvalidHostnames=true';
$client = new Client($uri);
// end-disable-hostname-uri

// Enables compression for a MongoDB connection and specifies each compression algorithm
// using client options
// start-compression-all-client
$client = new Client(
    'mongodb://<hostname>:<port>/',
    ['tls' => true, 'compressors' => 'snappy,zstd,zlib'],
);
// end-compression-all-client

// Enables compression for a MongoDB connection and specifies each compression algorithm
// using connection URI parameters
// start-compression-all-uri
$uri = 'mongodb://<hostname>:<port>/?compressors=snappy,zstd,zlib';
$client = new Client($uri);
// end-compression-all-uri

// Enables zlib compression for a MongoDB connection using client options
// start-compression-zlib-client
$client = new Client(
    'mongodb://<hostname>:<port>/',
    ['tls' => true, 'compressors' => 'zlib', 'zlibCompressionLevel' => 1],
);
// end-compression-zlib-client

// Enables zlib compression for a MongoDB connection using connection URI parameters
// start-compression-zlib-uri
$uri = 'mongodb://<hostname>:<port>/?compressors=zlib&zlibCompressionLevel=1';
$client = new Client($uri);
// end-compression-zlib-uri

// Connects to a MongoDB deployment and enables the stable API
// start-stable-api
$uri = '<connection string>';
$clientOptions = [
    'serverApi' => [
        'version' => '1',
    ],
];
$client = new Client($uri, $clientOptions);
// end-stable-api

?>