<?php
declare(strict_types=1);

namespace PBF\Infrastructure\IRC;

use PBF\Domain\Connexion\ConnexionInterface;
use PBF\Domain\Message\MessageInterface;

class IRCConnexion implements ConnexionInterface
{
    const DEFAULT_HOST = "localhost";
    const DEFAULT_PORT = 6667;

    /** @var string */
    private $chan;

    /** @var string */
    private $host;

    /** @var int */
    private $port;

    /**
     * @param string $chan
     * @param string $host
     * @param int $port
     */
    public function __construct(string $chan, string $host = self::DEFAULT_HOST, int $port = self::DEFAULT_PORT)
    {
        $this->chan = $chan;
        $this->host = $host;
        $this->port = $port;
    }

    /**
     * Receive a message from the server
     *
     * @return MessageInterface
     */
    public function receive(): MessageInterface
    {
        // TODO: Implement receive() method.
    }

    /**
     * Send a message to the server
     *
     * @param MessageInterface $message
     * @return void
     */
    public function send(MessageInterface $message)
    {
        // TODO: Implement send() method.
    }

    /**
     * Open the connexion
     *
     * @return bool Whether the connexion has been opened or not
     */
    public function open(): bool
    {
        // TODO: Implement open() method.
    }

    /**
     * Close the connexion
     *
     * @return bool Whether the connexion has been closed or not
     */
    public function close(): bool
    {
        // TODO: Implement close() method.
    }
}
