<?php

declare(strict_types=1);

use AuditLog\AuditLog;
use AuditLog\Event;
use PHPUnit\Framework\TestCase;

final class EventTest extends TestCase
{
    function testGetDiff()
    {
        $event = new Event(
            'Course Updated',
            'Course',
            'updation',
            1,
            'course',
            'Course 1',
            [
                'name' => 'Laravel 8',
                'description' => 'Laravel 8 is a web application framework with expressive, elegant syntax.',
                'category' => 'PHP',
            ],
            [
                'name' => 'Laravel',
                'description' => 'Laravel is a web application framework with expressive, elegant syntax.',
                'category' => 'PHP',
            ],
            1,
            'user',
            'alex@example.com'
        );
        $this->assertEquals([
            'name' => 'Laravel 8',
            'description' => 'Laravel 8 is a web application framework with expressive, elegant syntax.',
        ], $event->toArray()['diff_values']);
    }

    public function testToArray()
    {
        $event = new Event(
            'Course Updated',
            'Course',
            'updation',
            1,
            'course',
            'Course 1',
            [
                'name' => 'Laravel 8',
                'description' => 'Laravel 8 is a web application framework with expressive, elegant syntax.',
                'category' => 'PHP',
            ],
            [
                'name' => 'Laravel',
                'description' => 'Laravel is a web application framework with expressive, elegant syntax.',
                'category' => 'PHP',
            ],
            1,
            'user',
            'alex@example.com'
        );

        $this->assertEquals([
            'message' => 'Course Updated',
            'module' => 'Course',
            'event' => 'updation',
            'user_id' => 1,
            'user_type' => 'user',
            'entity_id' => 1,
            'entity_type' => 'course',
            'old_values' => [
                'name' => 'Laravel',
                'description' => 'Laravel is a web application framework with expressive, elegant syntax.',
                'category' => 'PHP',
            ],
            'new_values' => [
                'name' => 'Laravel 8',
                'description' => 'Laravel 8 is a web application framework with expressive, elegant syntax.',
                'category' => 'PHP',
            ],
            'diff_values' => [
                'name' => 'Laravel 8',
                'description' => 'Laravel 8 is a web application framework with expressive, elegant syntax.',
            ],
        ], $event->toArray());
    }
}
