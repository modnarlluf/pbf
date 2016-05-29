<?php
declare (strict_types=1);

namespace PBF\Domain\Bot;

interface BotInterface
{
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
}
