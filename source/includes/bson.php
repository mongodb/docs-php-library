<?php

require 'vendor/autoload.php';

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your Atlas URI that connects to the sample dataset');
$client = new MongoDB\Client($uri);
$db = $client->test;

// start-create-doc
$document = [
    'address' => [
        'street' => 'Pizza St',
        'zipcode' => '10003'
    ],
    'coord' => [-73.982419, 41.579505],
    'cuisine' => 'Pizza',
    'name' => 'Mongo\'s Pizza'
];
// end-create-doc

// start-modify-doc
$document['restaurant_id'] = 12345;
$document['name'] = 'Mongo\'s Pizza Place';
// end-modify-doc

// start-type-map
$options = [
    'typeMap' => [
        'array' => 'MongoDB\Model\BSONDocument',
        'root' => 'MongoDB\Model\BSONDocument', 
        'document' => 'MongoDB\Model\BSONDocument'
    ]
];

$db->createCollection('restaurants', $options);
// end-type-map

// start-person-class
class Person implements MongoDB\BSON\Persistable
{
    private MongoDB\BSON\ObjectId $id;
    private string $name;
    private MongoDB\BSON\UTCDateTime $createdAt;

    public function __construct(string $name)
    {
        $this->id = new MongoDB\BSON\ObjectId;
        $this->name = $name;
        $this->createdAt = new MongoDB\BSON\UTCDateTime;
    }

    function bsonSerialize()
    {
        return [
            '_id' => $this->id,
            'name' => $this->name,
            'createdAt' => $this->createdAt,
        ];
    }

    function bsonUnserialize(array $data)
    {
        $this->id = $data['_id'];
        $this->name = $data['name'];
        $this->createdAt = $data['createdAt'];
    }
}
// end-person-class

// start-person-serialize
$collection = $client->test->persons;
$result = $collection->insertOne(new Person('Bob'));
$person = $collection->findOne(['_id' => $result->getInsertedId()]);

var_dump($person);
// end-person-serialize

// start-backed-enum
enum Role: int
{
    case USER = 1;
    case ADMIN = 2;
}

class User implements MongoDB\BSON\Persistable
{
    public function __construct(
        private string $username,
        private Role $role,
        private MongoDB\BSON\ObjectId $_id = new MongoDB\BSON\ObjectId(),
    ) {}

    public function bsonSerialize(): array
    {
        return [
            '_id' => $this->_id,
            'username' => $this->username,
            'role' => $this->role,
        ];
    }

    public function bsonUnserialize(array $data): void
    {
        $this->_id = $data['_id'];
        $this->username = $data['username'];
        $this->role = Role::from($data['role']);
    }
}
// end-backed-enum