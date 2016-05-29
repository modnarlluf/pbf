<?php
declare(strict_types=1);

namespace PBF\Domain\Bot;

use PBF\Domain\Connexion\ConnexionInterface;
use PBF\Domain\Message\MessageInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

abstract class AbstractBot implements BotInterface
{
    /** @var string */
    private $id;

    /** @var ConnexionInterface */
    private $connexion;

    /** @var LoggerInterface */
    private $logger;

    /**
     * @param string $id
     * @param ConnexionInterface $connexion
     * @param null|LoggerInterface $logger
     */
    final public function __construct(string $id, ConnexionInterface $connexion, LoggerInterface $logger = null)
    {
        $this->id = $id;
        $this->connexion = $connexion;
        $this->setLogger($logger ?? new NullLogger());
    }

    /**
     * Get the bot unique ID
     *
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
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
     * @return LoggerInterface
     */
    public function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    /**
     * Set the logger of the bot
     *
     * @param LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @return ConnexionInterface
     */
    public function getConnexion(): ConnexionInterface
    {
        return $this->connexion;
    }

    /**
     * @param ConnexionInterface $connexion
     * @return void
     */
    public function setConnexion(ConnexionInterface $connexion)
    {
        $this->connexion = $connexion;
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
