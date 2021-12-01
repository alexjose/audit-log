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
     * @param string $message The title of the log
     * @param string $event The unique name of event
     * @param string $entityType The type to entity which got modified
     * @param string $entityId The id of the entity which got modified
     * @param array $newValues The new values of the entity
     * @param array|null $oldValues The old values of the entity
     * @param string $userId The id of the user who made the change
     * @param string $userType The type of the user who made the change
     */
    public function __construct(
        $message,
        $module,
        $event,
        $entityId,
        $entityType,
        $newValues,
        $oldValues,
        $userId,
        $userType = 'user'
    ) {
        $this->message = $message;
        $this->module = $module;
        $this->event = $event;
        $this->entityId = $entityId;
        $this->entityType = $entityType;
        $this->newValues = $newValues;
        $this->oldValues = $oldValues;
        $this->userId = $userId;
        $this->userType = $userType;

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
            'user_id' => $this->userId,
            'user_type' => $this->userType,
            'new_values' => $this->newValues,
            'old_values' => $this->oldValues,
            'diff_values' => $this->diffValues,
        ];
    }
}
