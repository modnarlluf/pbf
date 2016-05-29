<?php
declare(strict_types=1);

namespace PBF\Domain\Supervisor;

use PBF\Domain\Bot\BotInterface;

interface BotSupervisorInterface
{
    /**
     * Register an instance to supervise
     *
     * @param string $id
     * @param BotInterface $bot
     * @return void
     */
    public function addInstance(string $id, BotInterface $bot);

    /**
     * Start all the registered instances
     *
     * @return void
     */
    public function start();

    /**
     * Stop all the started instances
     *
     * @return void
     */
    public function stop();
}
