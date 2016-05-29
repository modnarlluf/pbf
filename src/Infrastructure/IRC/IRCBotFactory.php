<?php
declare(strict_types=1);

namespace PBF\Infrastructure\IRC;

use PBF\Domain\Bot\AbstractCommandBotFactory;
use PBF\Domain\Connexion\ConnexionInterface;

class IRCBotFactory extends AbstractCommandBotFactory
{
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
