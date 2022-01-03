<?php

declare(strict_types=1);

use AuditLog\AuditLog;
use AuditLog\Event;
use PHPUnit\Framework\TestCase;

final class AuditLogTest extends TestCase
{
    function testLogBasic()
    {
        $auditLog = new AuditLog('test.log');
        $auditLog->log([
            'New User Registerd',
            'User',
            'creation',
            1,
            'user',
            'alex@example.com',
            [
                'username' => 'john',
                'email' => 'john@example.com',
            ],
            null,
            1,
            'user',
            'alex@example.com'
        ]);

        $this->assertFileExists('test.log');
    }

    function testLogCustomLogFile()
    {
        $auditLog = new AuditLog('test1.log');
        $auditLog->log([
            'New User Registerd',
            'User',
            'creation',
            1,
            'user',
            'alex@example.com',
            [
                'username' => 'john',
                'email' => 'john@example.com',
            ],
            null,
            1,
            'user',
            'alex@example.com',
        ]);

        $this->assertFileExists('test1.log');
    }

    function testLogEvent()
    {
        $auditLog = new AuditLog('test-event.log');

        $event = new Event(
            'New User Registerd',
            'User',
            'creation',
            1,
            'user',
            'alex@example.com',
            [
                'username' => 'john',
                'email' => 'john@example.com',
            ],
            null,
            1,
            'user',
            'alex@example.com'
        );

        $auditLog->log($event);

        $this->assertFileExists('test-event.log');
    }
}
