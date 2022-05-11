<?php

namespace AuditLog;

use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\WebProcessor;
use Psr\Log\LoggerInterface;

class AuditLog
{
    /**
     * @var LoggerInterface $logger
     */
    private static $logger;

    /**
     * @param LoggerInterface|string|null $logger Logger object or the path to the log file
     */
    public function __construct($logger)
    {
        if ($logger instanceof LoggerInterface) {
            $this->setLogger($logger);
        } else {
            $logger = $this->createLogger($logger);
        }

        $this->setLogger($logger);
    }


    /**
     * @param Event|array $event
     */
    public function log($event): void
    {

        if (!$event instanceof Event) {
            $event = new Event(...$event);
        }

        try {
            self::$logger->info($event->message, $event->toArray());
        } catch (\Exception $e){
            trigger_error($e->getMessage(), E_USER_NOTICE);
        }
    }

    public function getLogger(): LoggerInterface
    {
        return self::$logger;
    }

    public function setLogger(LoggerInterface $logger): void
    {
        self::$logger = $logger;
    }

    private function createLogger(string $logFile = 'audit.log'): LoggerInterface
    {
        $streamHandler = new StreamHandler($logFile, Logger::INFO);

        $jsonFormatter = new JsonFormatter();

        $streamHandler->setFormatter($jsonFormatter);

        $webProcessor = new WebProcessor(null, [
            'url' => 'REQUEST_URI',
            'ip' => 'REMOTE_ADDR',
            'http_method' => 'REQUEST_METHOD',
            'server' => 'SERVER_NAME',
            'referrer' => 'HTTP_REFERER',
            'user_agent' => 'HTTP_USER_AGENT'
        ]);

        $interspectionProcessor = new IntrospectionProcessor(Logger::INFO, [], 1);

        $logger = new Logger('audit_log');
        $logger->pushHandler($streamHandler);
        $logger->pushProcessor($webProcessor);
        $logger->pushProcessor($interspectionProcessor);

        return $logger;
    }
}
