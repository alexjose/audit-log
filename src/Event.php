<?php

namespace AuditLog;

class Event
{
    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    private $module;

    /**
     * @var string
     */
    private $event;

    /**
     * @var string
     */
    private $entityType;

    /**
     * @var string
     */
    private $entityId;

    /**
     * @var string
     */
    private $entityTitle;

    /**
     * @var array
     */
    private $newValues;

    /**
     * @var array|null
     */
    private $oldValues;

    /**
     * @var array
     */
    private $diffValues;

    /**
     * @var string
     */
    private $userId;

    /**
     * @var string
     */
    private $userType;

    /**
     * @var string
     */
    private $username;



    /**
     * @param string $message The title of the log
     * @param string $event The unique name of event
     * @param string $entityId The id of the entity which got modified
     * @param string $entityType The type to entity which got modified
     * @param string $entityTitle The title of the entity which got modified
     * @param array $newValues The new values of the entity
     * @param array|null $oldValues The old values of the entity
     * @param string $userId The id of the user who made the change
     * @param string $userType The type of the user who made the change
     * @param string $username The username of the user who made the change
     */
    public function __construct(
        $message,
        $module,
        $event,
        $entityId,
        $entityType,
        $entityTitle,
        $newValues,
        $oldValues,
        $userId,
        $userType,
        $username
    ) {
        $this->message = $message;
        $this->module = $module;
        $this->event = $event;
        $this->entityId = $entityId;
        $this->entityType = $entityType;
        $this->entityTitle = $entityTitle;
        $this->newValues = $newValues;
        $this->oldValues = $oldValues;
        $this->userId = $userId;
        $this->userType = $userType;
        $this->username = $username;

        $this->diffValues = $this->getDiff();
    }

    private function getDiff()
    {
        return array_diff_assoc($this->newValues, $this->oldValues ?? []);
    }

    public function toArray()
    {
        return [
            'message' => $this->message,
            'module' => $this->module,
            'event' => $this->event,
            'entity_id' => $this->entityId,
            'entity_type' => $this->entityType,
            'entity_title' => $this->entityTitle,
            'user_id' => $this->userId,
            'user_type' => $this->userType,
            'username' => $this->username,
            'new_values' => $this->newValues,
            'old_values' => $this->oldValues,
            'diff_values' => $this->diffValues,
        ];
    }
}
