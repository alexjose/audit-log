<?php

declare(strict_types=1);

use AuditLog\AuditLog;
use PHPUnit\Framework\TestCase;

final class AuditLogTest extends TestCase
{
    function testLog()
    {
        $auditLog = new AuditLog('test.log');
        $auditLog->log(
            'New User Registerd',
            'creation',
            1,
            'user',
            [
                'username' => 'john',
                'email' => 'john@example.com',
            ],
            null,
            1
        );
    }
}
