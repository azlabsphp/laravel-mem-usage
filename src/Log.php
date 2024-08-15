<?php

namespace Drewlabs\Laravel\Memory\Usage;

final class Log
{
    /** @var string */
    private $name;

    /** @var AllocatedMemory */
    private $initial;

    /** @var AllocatedMemory */
    private $current;

    /** @var AllocatedMemory */
    private $diff;

    /** @var int */
    private $loggedAt;

    /**
     * Creates class constructor
     * 
     * @param string $name               The request or the action on which log is performed
     * @param AllocatedMemory $initial 
     * @param AllocatedMemory $current 
     * @param int $loggedAt 
     */
    public function __construct(string $name, AllocatedMemory $initial, AllocatedMemory $current, int $loggedAt = null)
    {
        $this->name = $name;
        $this->initial = $initial;
        $this->current = $current;
        $this->loggedAt = $loggedAt ?? time();
        $this->diff = new AllocatedMemory(
            $this->current->getUsedMemory() - $this->initial->getUsedMemory(),
            $this->current->getRequestedMemory() - $this->initial->getUsedMemory()
        );
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getInitialMemoryAllocation(): AllocatedMemory
    {
        return $this->initial;
    }

    public function getCurrentMemoryAllocation(): AllocatedMemory
    {
        return $this->current;
    }

    public function getHandlersConsumedMemory(): AllocatedMemory
    {
        return $this->diff;
    }


    public function getLoggedAt(): string
    {
        return date('Y-m-d H:i:s', $this->loggedAt);
    }
}
