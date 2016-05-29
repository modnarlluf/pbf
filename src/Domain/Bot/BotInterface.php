<?php
declare (strict_types=1);

namespace PBF\Domain\Bot;

use Psr\Log\LoggerInterface;

interface BotInterface
{
    /**
     * Get the bot unique ID
     *
     * @return string
     */
    public function getId(): string;

    /**
     * This method is executed once, it should initialize the bot
     *
     * @return void
     */
    public function start();

    /**
     * This method is executed while the application is running.
     * It should only receive one message and send one when needed
     *
     * @return void
     */
    public function loop();

    /**
     * This method is executed once, it should stop the bot
     *
     * @return void
     */
    public function stop();

    /**
     * Set the logger of the bot
     *
     * @param LoggerInterface $logger
     * @return void
     */
    public function setLogger(LoggerInterface $logger);
}
