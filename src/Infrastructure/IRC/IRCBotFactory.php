<?php
declare(strict_types=1);

namespace PBF\Infrastructure\IRC;

use PBF\Domain\Bot\BotFactoryInterface;
use PBF\Domain\Bot\BotInterface;
use PBF\Domain\Bot\DefaultBot;

class IRCBotFactory implements BotFactoryInterface
{
    public function getBot(array $config = [], array $commands = []): BotInterface
    {
        $connexion = new IRCConnexion(
            $config["chan"] ?? "",
            $config["host"] ?? IRCConnexion::DEFAULT_HOST,
            $config["port"] ?? IRCConnexion::DEFAULT_PORT
        );

        $bot = new DefaultBot($connexion);
        $bot->registerCommands($commands);

        return $bot;
    }
}
