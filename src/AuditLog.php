<?php

namespace AuditLog;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\WebProcessor;

class AuditLog
{
    /**
     * @var LoggerInterface $logger
     */
    private static $logger;

    /**
     * @param string $logFile The path to the log file
     */
    public function __construct($logFile)
    {
        $streamHandler = new StreamHandler($logFile, Logger::INFO);

        $webProcessor = new WebProcessor(null, [
            'url' => 'REQUEST_URI',
            'ip' => 'REMOTE_ADDR',
            'http_method' => 'REQUEST_METHOD',
            'server' => 'SERVER_NAME',
            'referrer' => 'HTTP_REFERER',
            'user_agent' => 'HTTP_USER_AGENT'
        ]);

        $interspectionProcessor = new IntrospectionProcessor(Logger::INFO, [], 1);

        self::$logger = new \Monolog\Logger('audit_log');
        self::$logger->pushHandler($streamHandler);
        self::$logger->pushProcessor($webProcessor);
        self::$logger->pushProcessor($interspectionProcessor);
    }

    /**
     * @param string $title The title of the log
     * @param string $event The unique name of event
     * @param string $entityType The type to entity which got modified
     * @param string $entityId The id of the entity which got modified
     * @param array $newValues The new values of the entity
     * @param array|null $oldValues The old values of the entity
     * @param string $userId The id of the user who made the change
     * @param string $userType The type of the user who made the change
     */
    public function log(
        $title,
        $event,
        $entityId,
        $entityType,
        $newValues,
        $oldValues,
        $userId,
        $userType = 'user'
    ): void {
        $log = [
            'title' => $title,
            'event' => $event,
            'entity_id' => $entityId,
            'entity_type' => $entityType,
            'new_values' => $newValues,
            'old_values' => $oldValues,
            'user_id' => $userId,
            'user_type' => $userType,
        ];
        self::$logger->info($title, $log);
    }
}
