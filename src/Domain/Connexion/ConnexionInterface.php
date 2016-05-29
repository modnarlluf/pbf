<?php
declare (strict_types=1);

namespace PBF\Domain\Connexion;

use PBF\Domain\Message\MessageInterface;

interface ConnexionInterface
{
    /**
     * Open the connexion
     *
     * @return bool Whether the connexion has been opened or not
     */
    public function open(): bool;

    /**
     * Close the connexion
     *
     * @return bool Whether the connexion has been closed or not
     */
    public function close(): bool;

    /**
     * Receive a message from the server
     *
     * @return MessageInterface
     */
    public function receive(): MessageInterface;

    /**
     * Send a message to the server
     *
     * @param MessageInterface $message
     * @return void
     */
    public function send(MessageInterface $message);
}
