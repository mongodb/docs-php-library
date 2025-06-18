<?php

require 'vendor/autoload.php';

// start-monolog-logger
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

$logger = new Logger('mongodb-logger');
$logger->pushHandler(new StreamHandler(__DIR__ . '/library.log', Logger::DEBUG));

MongoDB\add_logger($logger);
// end-monolog-logger

// start-custom-logger
use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;
use Psr\Log\LogLevel;
use MongoDB\PsrLogAdapter;

class MyLogger extends AbstractLogger
{
    public array $logs = [];

    public function log($level, $message, array $context = []): void
    {
        $this->logs[] = [$level, $message, $context['domain']];
    }
}

$customLogger = new MyLogger();
MongoDB\add_logger($customLogger);
print_r($customLogger->logs);
// end-custom-logger

// start-remove-logger
MongoDB\remove_logger($logger);
// end-remove-logger