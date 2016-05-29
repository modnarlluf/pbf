<?php
declare(strict_types=1);

namespace PBF\Infrastructure\Supervisor;

use PBF\Domain\Bot\BotInterface;
use PBF\Domain\Supervisor\Exception\InstanceCreationException;
use PBF\Domain\Supervisor\BotSupervisorInterface;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class PcntlBotSupervisor implements BotSupervisorInterface
{
    /** @var BotInterface[] */
    private $instances = [];

    /** @var string[] */
    private $runningInstances = [];

    /** @var LoggerInterface */
    private $logger;

    public function __construct(LoggerInterface $logger = null)
    {
        $this->logger = $logger ?: new NullLogger();
    }

    /**
     * Register an instance to supervise
     *
     * @param string $id
     * @param BotInterface $bot
     * @return void
     */
    public function addInstance(string $id, BotInterface $bot)
    {
        $this->instances[$id] = $bot;
    }

    /**
     * Start all the registered instances
     *
     * @return void
     */
    public function start()
    {
        foreach ($this->instances as $id => $bot) {
            $pid = \pcntl_fork();

            switch(true) {
                case -1 === $pid:
                    // child creation error
                    throw new InstanceCreationException(sprintf("Failed to create an instance for '%s'", $id));

                case 0 !== $pid:
                    // parent process
                    $this->runningInstances[$id] = $pid;
                    $this->logger->info("[Supervisor] Bot with id {id} started on process {pid}", [
                        "id" => $id,
                        "pid" => $pid
                    ]);
                    break;

                default:
                    // child process
                    // Register shutdown function
                    \pcntl_signal(SIGHUP, [$bot, "stop"]);
                    \pcntl_signal(SIGINT, [$bot, "stop"]);
                    \pcntl_signal(SIGTERM, [$bot, "stop"]);
                    \pcntl_signal(SIGQUIT, [$bot, "stop"]);

                    $bot->start();

                    while (true) {
                        $bot->loop();
                    }
            }
        }
    }

    /**
     * Stop all the started instances
     *
     * @return void
     */
    public function stop()
    {
        foreach ($this->runningInstances as $id => $pid) {
            \posix_kill($pid, SIGTERM);
            $this->logger->info("[Supervisor] Bot with id {id} stopped with pid {pid}", ["id" => $id, "pid" => $pid]);
        }
    }
}
