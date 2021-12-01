<?php

use AuditLog\AuditLog;

require_once __DIR__ . '/vendor/autoload.php';




$auditLog = new AuditLog('test-1.log');
$auditLog->log(
    'New User Registerd',
    'creation',
    1,
    'user',
    [
        'username' => 'john',
        'email' => 'john@example.com'
    ],
    null,
    1
);
