<p align="center">
    <a href="https://github.com/alexjose/audit-log/actions"><img src="https://github.com/alexjose/audit-log/workflows/tests/badge.svg" alt="Build Status"></a>
    <a href="https://packagist.org/packages/alexjose/audit-log"><img src="https://img.shields.io/packagist/dt/alexjose/audit-log" alt="Total Downloads"></a>
    <a href="https://packagist.org/packages/alexjose/audit-log"><img src="https://img.shields.io/packagist/v/alexjose/audit-log" alt="Latest Stable Version"></a>
    <a href="https://packagist.org/packages/alexjose/audit-log"><img src="https://img.shields.io/packagist/l/alexjose/audit-log" alt="License"></a>
</p>

# AuditLog - Log audit events using the Monolog

This library aims to log the critical changes happening in the application. This tracks the changes and the source of the events.

## Installation

```bash
composer require alexjose/audit-log
```

## Basic Usage

```php
$auditLog = new AuditLog();
$auditLog->log([
    'New User Registerd',
    'User',
    'creation',
    1,
    'user',
    [
        'username' => 'john',
        'email' => 'john@example.com'
    ],
    null,
    1
]);
```

### Signature of `log()`

`log()` will accept an instance of `Event` or an array with the attributes of the `Event`.

```php
    /**
     * @param Event|array $event
     */
    public function log($event): void
```

Signature of `new Event()`

```php
    /**
     * @param string $message The title of the log
     * @param string $event The unique name of event
     * @param string $entityType The type to entity which got modified
     * @param string $entityId The id of the entity which got modified
     * @param array $newValues The new values of the entity
     * @param array|null $oldValues The old values of the entity
     * @param string $userId The id of the user who made the change
     * @param string $userType The type of the user who made the change
     */
    public function construct(
        $message,
        $module,
        $event,
        $entityId,
        $entityType,
        $newValues,
        $oldValues,
        $userId,
        $userType = 'user'
    ):void
```
