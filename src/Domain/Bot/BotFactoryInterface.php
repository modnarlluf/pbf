<?php
declare (strict_types=1);

namespace PBF\Domain\Bot;

use Psr\Log\LoggerInterface;

interface BotFactoryInterface
{
    /**
     * Build an instance of BotInterface with the given config
     *
     * @param string $id
     * @param array $config
     * @param null|LoggerInterface $logger
     * @return \PBF\Domain\Bot\BotInterface
     * @throws \PBF\Domain\Bot\Exception\InvalidBotConfigurationException
     */
    public function getBot(string $id, array $config = [], LoggerInterface $logger = null): BotInterface;
}
