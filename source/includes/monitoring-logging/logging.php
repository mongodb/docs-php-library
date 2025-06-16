<?php

require 'vendor/autoload.php';

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use MongoDB\PsrLogAdapter;

use function MongoDB\add_logger;
use function MongoDB\remove_logger;

// start-register-logger
class MyLogger extends AbstractLogger
{
    public array $logs = [];

    public function log($level, $message, array $context = []): void
    {
        $this->logs[] = [$level, $message, $context['domain']];
    }
}

$logger = new MyLogger();
add_logger($logger);
print_r($logger->logs);
// end-register-logger

// start-write-messages
PsrLogAdapter::writeLog(PsrLogAdapter::WARN, 'domain1', 'This is a warning message');
PsrLogAdapter::writeLog(PsrLogAdapter::CRITICAL, 'domain2', 'This is a critical message');

print_r($logger->logs);
// end-write-messages

// start-remove-logger
remove_logger($logger);
// end-remove-logger
