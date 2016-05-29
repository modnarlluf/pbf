<?php
declare(strict_types=1);

namespace PBF\Application\Log;

use Psr\Log\AbstractLogger;

class ResourceLogger extends AbstractLogger
{
    private $resource;

    public function __construct(resource $resource)
    {
        $this->resource = $resource;
    }

    /**
     * Logs with an arbitrary level.
     *
     * @param mixed $level
     * @param string $message
     * @param array $context
     * @return null
     */
    public function log($level, $message, array $context = array())
    {
        fprintf($this->resource, "[%s] %s %s", $level, $message, json_encode($context));
    }
}
