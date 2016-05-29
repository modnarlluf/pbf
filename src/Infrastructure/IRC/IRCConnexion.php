<?php
declare(strict_types=1);

namespace PBF\Infrastructure\IRC;

use PBF\Domain\Connexion\ConnexionInterface;
use PBF\Domain\Message\DefaultMessage;
use PBF\Domain\Message\MessageInterface;
use PBF\Infrastructure\Stream\SocketStream;

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

    /** @var resource */
    private $socket;

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
        $message = new DefaultMessage();
        $message->setContent(new SocketStream($this->socket));

        return $message;
    }

    /**
     * Send a message to the server
     *
     * @param MessageInterface $message
     * @return void
     */
    public function send(MessageInterface $message)
    {
        $message = (string) $message->getContent();

        \socket_write($this->socket, $message);
    }

    /**
     * Open the connexion
     *
     * @return bool Whether the connexion has been opened or not
     */
    public function open(): bool
    {
        $this->socket = \socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
        return \socket_connect($this->socket, $this->host, $this->port);
    }

    /**
     * Close the connexion
     *
     * @return bool Whether the connexion has been closed or not
     */
    public function close(): bool
    {
        \socket_close($this->socket);
    }
}
