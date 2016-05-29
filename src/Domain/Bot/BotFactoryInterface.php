<?php
declare (strict_types=1);

namespace PBF\Domain\Bot;

use PBF\Domain\Bot\BotInterface;

interface BotFactoryInterface
{
    /**
     * @param array $config
     * @param \PBF\Domain\Command\CommandInterface[] $commands
     * @return \PBF\Domain\Bot\BotInterface
     */
    public function getBot(array $config = [], array $commands = []): BotInterface;
}
