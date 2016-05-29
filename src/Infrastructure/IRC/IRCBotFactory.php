<?php
declare(strict_types=1);

namespace PBF\Infrastructure\IRC;

use PBF\Domain\Bot\AbstractCommandBotFactory;
use PBF\Domain\Bot\BotInterface;
use PBF\Domain\Connexion\ConnexionInterface;
use Psr\Log\LoggerInterface;

class IRCBotFactory extends AbstractCommandBotFactory
{
    const BOT_BASE_CLASS = IRCBot::class;

    /**
     * Build an instance of BotInterface with the given config
     *
     * @param string $id
     * @param array $config
     * @param null|LoggerInterface $logger
     * @return \PBF\Domain\Bot\BotInterface
     * @throws \PBF\Domain\Bot\Exception\InvalidBotConfigurationException
     */
    public function getBot(string $id, array $config = [], LoggerInterface $logger = null): BotInterface
    {
        /** @var IRCBot $bot */
        $bot = parent::getBot($id, $config, $logger);

        $bot->setNick($config["nick"] ?? "");
        $bot->setChan($config["chan"] ?? "");

        return $bot;
    }

    /**
     * Build the bot connexion
     *
     * @param array $config
     * @return ConnexionInterface
     */
    public function getConnexion(array $config = []): ConnexionInterface
    {
        return new IRCConnexion(
            $config["chan"] ?? "",
            $config["host"] ?? IRCConnexion::DEFAULT_HOST,
            $config["port"] ?? IRCConnexion::DEFAULT_PORT
        );
    }
}
