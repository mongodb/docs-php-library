<?php
require 'vendor/autoload.php';

use MongoDB\Client;

// start-scram-sha-256
$uri = 'mongodb://<db_username>:<db_password>@<hostname>:<port>/?authSource=admin&authMechanism=SCRAM-SHA-256';
$client = new Client($uri);
// end-scram-sha-256

// start-scram-sha-1
$uri = 'mongodb://<db_username>:<db_password>@<hostname>:<port>/?authSource=admin&authMechanism=SCRAM-SHA-1';
$client = new Client($uri);
// end-scram-sha-1

// start-x509
$uri = 'mongodb://<hostname>:<port>/?tls=true&tlsCertificateKeyFile=path/to/client.pem&authMechanism=MONGODB-X509';
$client = new Client($uri);
// end-x509

// start-aws-connection-uri
$uri = 'mongodb://<AWS IAM access key ID>:<AWS IAM secret access key>@<hostname>:<port>/?authMechanism=MONGODB-AWS';
$client = new Client($uri);
// end-aws-connection-uri

// start-aws-connection-uri-session
$uri = 'mongodb://<AWS IAM access key ID>:<AWS IAM secret access key>@<hostname>:<port>/?authMechanism=MONGODB-AWS&authMechanismProperties=AWS_SESSION_TOKEN:<token>';
$client = new Client($uri);
// end-aws-connection-uri-session

// start-aws-environment
$uri = 'mongodb://<hostname>:<port>/?authMechanism=MONGODB-AWS';
$client = new Client($uri);
// end-aws-environment

// start-kerberos
$uri = 'mongodb://<Kerberos principal>@<hostname>:<port>/?authMechanism=GSSAPI&authMechanismProperties=SERVICE_NAME:<authentication service name>';
$client = new Client($uri);
// end-kerberos

// start-plain
$uri = 'mongodb://<db_username>:<db_password>@<hostname>:<port>/?authMechanism=PLAIN&tls=true';
$client = new Client($uri);
// end-plain
