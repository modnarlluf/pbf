<?php
declare(strict_types=1);

namespace PBF\Domain\Bot;

use PBF\Domain\Bot\Exception\InvalidBotClassException;
use PBF\Domain\Connexion\ConnexionInterface;
use PBF\Infrastructure\Bot\CommandBot;

abstract class AbstractCommandBotFactory implements BotFactoryInterface
{
    /**
     * @param array $config
     * @return BotInterface
     * @throws \PBF\Domain\Bot\Exception\InvalidBotConfigurationException
     */
    public function getBot(array $config = []): BotInterface
    {
        $connexion = $this->getConnexion($config);

        if (isset($config["bot_class"])) {
            $botReflection = new \ReflectionClass($config["bot_class"]);

            if (!$botReflection->isSubclassOf(CommandBot::class)) {
                throw new InvalidBotClassException(sprintf(
                    "The 'bot_class' entry must provide a class extending %s",
                    CommandBot::class
                ));
            }

            $bot = $botReflection->newInstance($connexion);
        } else {
            $bot = new CommandBot($connexion);
        }

        $bot->registerCommands($config["commands"] ?? []);

        return $bot;
    }

    /**
     * Build the bot connexion
     *
     * @param array $config
     * @return ConnexionInterface
     */
    abstract protected function getConnexion(array $config = []): ConnexionInterface;
}
