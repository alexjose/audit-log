<?php

namespace AuditLog;

use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\PsrLogMessageProcessor;
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

        $jsonFormatter = new \Monolog\Formatter\JsonFormatter();

        // $streamHandler->setFormatter($jsonFormatter);

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
     * @param string $url The url of the page where the change was made
     * @param string $ip The ip address of the user who made the change
     * @param string $userAgent The user agent of the user who made the change
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
        // $url = null,
        // $ip = null,
        // $userAgent = null
    ): void {
        $log = [
            'title' => $title,
            'event' => $event,
            'entityId' => $entityId,
            'entityType' => $entityType,
            'newValues' => $newValues,
            'oldValues' => $oldValues,
            'userId' => $userId,
            'userType' => $userType,
            // 'url' => $url ?? @$_SERVER['REQUEST_URI'],
            // 'ip' => $ip ?? @$_SERVER['REMOTE_ADDR'],
            // 'userAgent' => $userAgent ?? @$_SERVER['HTTP_USER_AGENT'],
        ];
        self::$logger->info($title, $log);
    }
}
