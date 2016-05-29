<?php
declare(strict_types=1);

namespace PBF\Application;

use PBF\Domain\Bot\BotFactoryInterface;

interface ModuleInterface
{
    public function getBotFactory(): BotFactoryInterface;
}
