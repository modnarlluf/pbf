<?php
declare (strict_types=1);

namespace PBF\Domain\Bot;

use PBF\Domain\Bot\BotInterface;

interface BotFactoryInterface
{
    /**
     * @param array $config
     * @return \PBF\Domain\Bot\BotInterface
     * @throws \PBF\Domain\Bot\Exception\InvalidBotConfigurationException
     */
    public function getBot(array $config = []): BotInterface;
}
