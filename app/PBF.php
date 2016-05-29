<?php
declare (strict_types=1);

use PBF\Application\Kernel;

class PBF extends Kernel
{
    /**
     * @return \PBF\Application\ModuleInterface[]|array
     */
    protected function getModules(): array
    {
        return [
            "irc" => new PBF\Infrastructure\IRC\IRCModule(),
        ];
    }

    /**
     * Get the app root dir
     *
     * @return string
     */
    protected function getRootDir(): string
    {
        return __DIR__;
    }
}
