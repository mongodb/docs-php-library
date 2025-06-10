<?php

require __DIR__ . '/vendor/autoload.php';

// start-command-subscriber
class MyCommandSubscriber implements MongoDB\Driver\Monitoring\CommandSubscriber
{
    public function __construct(private $stream) {}

    public function commandStarted(MongoDB\Driver\Monitoring\CommandStartedEvent $event): void
    {
        fwrite($this->stream, sprintf(
            'Started command #%d "%s": %s%s',
            $event->getRequestId(),
            $event->getCommandName(),
            MongoDB\BSON\Document::fromPHP($event->getCommand())->toCanonicalExtendedJSON(),
            PHP_EOL,
        ));
    }

    public function commandSucceeded(MongoDB\Driver\Monitoring\CommandSucceededEvent $event): void {}
    public function commandFailed(MongoDB\Driver\Monitoring\CommandFailedEvent $event): void {}
}
// end-command-subscriber

// start-sdam-subscriber
class MySDAMSubscriber implements MongoDB\Driver\Monitoring\SDAMSubscriber
{
    public function __construct(private $stream) {}

    public function serverOpening(MongoDB\Driver\Monitoring\ServerOpeningEvent $event): void {
        fprintf(
            $this->stream,
            'Server opening on %s:%s\n',
            $event->getHost(),
            $event->getPort(),
            PHP_EOL,
        );
    }

    public function serverClosed(MongoDB\Driver\Monitoring\ServerClosedEvent $event): void {}
    public function serverChanged(MongoDB\Driver\Monitoring\ServerChangedEvent $event): void {}
    public function serverHeartbeatFailed(MongoDB\Driver\Monitoring\ServerHeartbeatFailedEvent $event): void {}
    public function serverHeartbeatStarted(MongoDB\Driver\Monitoring\ServerHeartbeatStartedEvent $event): void {}
    public function serverHeartbeatSucceeded(MongoDB\Driver\Monitoring\ServerHeartbeatSucceededEvent $event): void {}
    public function topologyChanged(MongoDB\Driver\Monitoring\TopologyChangedEvent $event): void {}
    public function topologyClosed(MongoDB\Driver\Monitoring\TopologyClosedEvent $event): void {}
    public function topologyOpening(MongoDB\Driver\Monitoring\TopologyOpeningEvent $event): void {}
}
// end-sdam-subscriber

$uri = getenv('MONGODB_URI') ?: throw new RuntimeException('Set the MONGODB_URI variable to your connection URI');
$client = new MongoDB\Client($uri);

$collection = $client->db->my_coll;

// start-add-subs
$commandSub = new MyCommandSubscriber(STDERR);
$sdamSub = new MySDAMSubscriber(STDERR);

$client->addSubscriber($commandSub);
$client->addSubscriber($sdamSub);
// end-add-subs

$collection->insertOne(['x' => 100]);

// start-remove-sub
$client->removeSubscriber($commandSub);
// end-remove-sub