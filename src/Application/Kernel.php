<?php
declare (strict_types=1);

namespace PBF\Application;

use PBF\Application\Exception\ClassNotFoundException;
use PBF\Application\Exception\InvalidBotTypeException;
use PBF\Application\Exception\InvalidCommandCategoryException;
use PBF\Domain\Bot\BotInterface;
use PBF\Domain\Command\CommandInterface;
use PBF\Domain\Supervisor\SupervisorInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\Yaml\Yaml;

abstract class Kernel
{
    const BOTS_FILE = "config/bots.yml";
    const COMMANDS_FILE = "config/commands.yml";
    const DEFAULT_COMMAND_CATEGORY = "default";

    /** @var ModuleInterface[] */
    private $modules;

    /** @var CommandInterface[][] */
    private $commands;

    /** @var BotInterface[] */
    private $bots;

    /** @var SupervisorInterface */
    private $supervisor;

    /** @var LoggerInterface */
    private $logger;

    /**
     * @param SupervisorInterface $supervisor
     * @param LoggerInterface $logger
     */
    public function __construct(SupervisorInterface $supervisor, LoggerInterface $logger)
    {
        $this->supervisor = $supervisor;
        $this->logger = $logger;
    }

    /**
     * Boot the kernel
     *
     * @return void
     */
    public function boot()
    {
        $this->loadModules();
        $this->loadCommandsConfiguration();
        $this->loadBotsConfiguration();
    }

    /**
     * Launch all the bots
     *
     * @return void
     */
    public function run()
    {

    }

    /**
     * Stop the bots and let the process close
     *
     * @return void
     */
    public function shutdown()
    {

    }

    /**
     * Load all the provided modules
     *
     * @return void
     */
    private function loadModules()
    {
        foreach ($this->getModules() as $name => $module) {
            $this->registerModule($name, $module);
        }
    }

    /**
     * Register a single module in the kernel
     *
     * @param string $name
     * @param ModuleInterface $module
     * @return void
     */
    private function registerModule(string $name, ModuleInterface $module)
    {
        $this->modules[$name] = $module;
    }

    /**
     * Parse and load the bots configuration file
     *
     * @return void
     * @throws InvalidBotTypeException
     */
    private function loadBotsConfiguration()
    {
        $config = Yaml::parse(file_get_contents(__DIR__."/".static::BOTS_FILE));

        foreach ($config as $botId => $botConfig) {
            $type = (string) ($botConfig["type"] ?? "");

            if (!isset($this->modules[$type])) {
                throw new InvalidBotTypeException(sprintf(
                    "The type '%s' doesn't exist for bot '%s'",
                    $type,
                    $botId
                ));
            }

            $rawCommands = $botConfig["commands"] ?? "*";
            $commands = iterator_to_array($this->resolveBotCommands($rawCommands));

            $botFactoryConfig = (array) ($botConfig["config"] ?? []);
            $typeModule = $this->modules[$type];
            $bot = $typeModule->getBotFactory()->getBot($botFactoryConfig, $commands);

            $this->bots[$botId] = $bot;
        }
    }

    /**
     * Return an iterator containing all the found commands for the given expression
     *
     * @param string|array $rawCommands
     * @return \Iterator
     * @throws InvalidCommandCategoryException
     */
    protected function resolveBotCommands($rawCommands): \Iterator
    {
        if ("*" === $rawCommands) {
            foreach ($this->commands as $category) {
                foreach ($category as $name => $command) {
                    yield $name => $command;
                }
            }
        } elseif (is_string($rawCommands) && isset($this->commands[$rawCommands])) {
            foreach ($this->commands[$rawCommands] as $name => $command) {
                yield $name => $command;
                }
        } elseif (is_array($rawCommands)) {
            foreach ($rawCommands as $categoryToFind) {
                if (!isset($this->commands[$categoryToFind])) {
                    throw new InvalidCommandCategoryException(sprintf(
                        "The command category '%s' doesn't exist",
                        $categoryToFind
                    ));
                }

                foreach ($this->commands[$categoryToFind] as $name => $command) {
                    yield $name => $command;
                }
            }
        }
    }

    /**
     * Parse an load the commands configuration file
     *
     * @return void
     */
    private function loadCommandsConfiguration()
    {
        $config = Yaml::parse(file_get_contents(__DIR__."/".static::COMMANDS_FILE));

        foreach ($config as $categoryName => $category) {
            if (is_array($category)) {
                $this->loadCommandCategory($categoryName, $category);
            } else {
                $this->loadCommandCategory(static::DEFAULT_COMMAND_CATEGORY, [$category]);
            }
        }
    }

    /**
     * Load a single command category
     *
     * @param string $categoryName
     * @param array $entries
     */
    private function loadCommandCategory(string $categoryName, array $entries)
    {
        foreach ($entries as $commandName => $className) {
            $command = $this->buildCommand($className);
            $this->commands[$categoryName][$commandName] = $command;
        }
    }

    /**
     * Resolve command class name and return an instance of the class.
     *
     * @param string $className
     * @return CommandInterface
     * @throws \PBF\Application\Exception\ClassNotFoundException
     */
    protected function buildCommand(string $className): CommandInterface
    {
        if (!class_exists($className)) {
            throw new ClassNotFoundException(sprintf("Unable to load the class %s", $className));
        }

        return new $className;
    }

    /**
     * @return ModuleInterface[]|array
     */
    abstract protected function getModules(): array;
}
