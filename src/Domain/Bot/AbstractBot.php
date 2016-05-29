<?php
declare(strict_types=1);

namespace PBF\Domain\Bot;

use PBF\Domain\Connexion\ConnexionInterface;
use PBF\Domain\Message\MessageInterface;

abstract class AbstractBot implements BotInterface
{
    /** @var ConnexionInterface */
    private $connexion;

    /**
     * @param ConnexionInterface $connexion
     */
    public function __construct(ConnexionInterface $connexion)
    {
        $this->connexion = $connexion;
    }

    /**
     * This method is executed once, it should initialize the bot
     *
     * @return void
     */
    public function start()
    {
        $this->connexion->open();
    }

    /**
     * This method is executed while the application is running.
     * It should only receive one message and send one when needed
     *
     * @return void
     */
    public function loop()
    {
        $message = $this->connexion->receive();

        $this->handleMessage($message, $this->connexion);
    }

    /**
     * This method is executed once, it should stop the bot
     *
     * @return void
     */
    public function stop()
    {
        $this->connexion->close();
    }

    /**
     * Respond to the given message.
     *
     * @param MessageInterface $message
     * @param ConnexionInterface $connexion
     * @return void
     */
    abstract protected function handleMessage(MessageInterface $message, ConnexionInterface $connexion);
}
