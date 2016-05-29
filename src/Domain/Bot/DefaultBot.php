<?php
declare(strict_types=1);

namespace PBF\Domain\Bot;

use PBF\Domain\Command\CommandInterface;
use PBF\Domain\Connexion\ConnexionInterface;
use PBF\Domain\Message\MessageInterface;

class DefaultBot extends AbstractBot
{
    /**
     * @var CommandInterface[]
     */
    private $commands;

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
        // TODO: Implement handleMessage() method.
    }
}
