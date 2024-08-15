<?php

namespace Drewlabs\Laravel\Memory\Usage;

class AllocatedMemory
{
    /** @var int */
    private $usedMemory;

    /** @var int */
    private $requestedMemory;

    /**
     * Class constructor
     * 
     * @param int $usedMemory 
     * @param int $requestedMemory 
     */
    public function __construct(int $usedMemory, int $requestedMemory)
    {
        $this->usedMemory = $usedMemory;
        $this->requestedMemory = $requestedMemory;
    }

    /**
     * returns system memory used by the PHP function
     * 
     * @return int 
     */
    public function getUsedMemory(): int
    {
        return $this->usedMemory;
    }

    /**
     * returns the total system memory requested by the PHP function
     * 
     * @return int 
     */
    public function getRequestedMemory(): int
    {
        return $this->requestedMemory;
    }
}
