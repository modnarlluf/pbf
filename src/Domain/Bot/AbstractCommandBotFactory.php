<?php
declare(strict_types=1);

namespace PBF\Domain\Bot;

use PBF\Domain\Bot\Exception\InvalidBotClassException;
use PBF\Domain\Connexion\ConnexionInterface;
use PBF\Infrastructure\Bot\CommandBot;
use Psr\Log\LoggerInterface;

abstract class AbstractCommandBotFactory implements BotFactoryInterface
{
    const BOT_BASE_CLASS = CommandBot::class;

    /**
     * Build an instance of BotInterface with the given config
     *
     * @param string $id
     * @param array $config
     * @param null|LoggerInterface $logger
     * @return BotInterface
     * @throws InvalidBotClassException
     */
    public function getBot(string $id, array $config = [], LoggerInterface $logger = null): BotInterface
    {
        $connexion = $this->getConnexion($config);

        if (isset($config["bot_class"])) {
            $botReflection = new \ReflectionClass($config["bot_class"]);

            if (!$botReflection->isSubclassOf(static::BOT_BASE_CLASS)) {
                throw new InvalidBotClassException(sprintf(
                    "The 'bot_class' entry must provide a class extending %s",
                    static::BOT_BASE_CLASS
                ));
            }

            $bot = $botReflection->newInstance($id, $connexion, $logger);
        } else {
            $baseClass = static::BOT_BASE_CLASS;
            $bot = new $baseClass($id, $connexion, $logger);
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
