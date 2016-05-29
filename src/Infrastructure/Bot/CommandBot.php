<?php
declare(strict_types=1);

namespace PBF\Infrastructure\Bot;

use PBF\Domain\Bot\AbstractBot;
use PBF\Domain\Bot\BotInterface;
use PBF\Domain\Command\CommandInterface;
use PBF\Domain\Command\Exception\InvalidCommandArgumentException;
use PBF\Domain\Connexion\ConnexionInterface;
use PBF\Domain\Message\MessageInterface;

class CommandBot extends AbstractBot
{
    const DEFAULT_COMMAND_PREFIX = "!";

    /**
     * @var CommandInterface[]
     */
    private $commands;

    /** @var string */
    private $commandPrefix = self::DEFAULT_COMMAND_PREFIX;

    /**
     * @param array $commands
     * @return $this
     */
    public function registerCommands(array $commands)
    {
        foreach ($commands as $name => $command) {
            $this->registerCommand($name, $command);
        }

        return $this;
    }

    /**
     * @param string $name
     * @param CommandInterface $command
     * @return $this
     */
    public function registerCommand(string $name, CommandInterface $command)
    {
        $this->commands[$name] = $command;
        return $this;
    }

    /**
     * Respond to the given message.
     *
     * @param MessageInterface $message
     * @param ConnexionInterface $connexion
     * @return void
     */
    protected function handleMessage(MessageInterface $message, ConnexionInterface $connexion)
    {
        $messageContent = (string) $message->getContent();

        if (0 === substr_compare($messageContent, $this->commandPrefix, 0)) {
            $arguments = preg_split("/\\s+/", $messageContent);
            $rawCommand = array_shift($arguments);

            $command = substr($rawCommand, strlen($this->commandPrefix));

            if (!isset($this->commands[$command])) {
                $this->handleUnknownCommand($command);
                return;
            }

            $command = $this->commands[$command];

            try {
                $command->execute($arguments);
            } catch (InvalidCommandArgumentException $e) {
                $this->handleInvalidCommandArguments($e);
            }
        }
    }

    /**
     * This method may be extended if you want to add a behavior
     *
     * @param string $command
     * @return void
     */
    protected function handleUnknownCommand(string $command)
    {
        // noop
    }

    /**
     * This method may be extended if you want to add a behavior
     *
     * @param InvalidCommandArgumentException $exception
     * @return void
     */
    protected function handleInvalidCommandArguments(InvalidCommandArgumentException $exception)
    {
        // noop
    }

    /**
     * @param string $commandPrefix
     * @return BotInterface
     */
    public function setCommandPrefix(string $commandPrefix): BotInterface
    {
        $this->commandPrefix = $commandPrefix;
        return $this;
    }
}
