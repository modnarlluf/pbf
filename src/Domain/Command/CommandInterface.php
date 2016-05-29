<?php
declare (strict_types=1);

namespace PBF\Domain\Command;

interface CommandInterface
{
    /**
     * Execute a command with the given arguments
     *
     * @param array $arguments
     * @return string The command response
     * @throws \PBF\Domain\Command\Exception\InvalidCommandArgumentException
     */
    public function execute(array $arguments = []): string;
}
