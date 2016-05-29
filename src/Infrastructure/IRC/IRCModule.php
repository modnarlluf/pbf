<?php
declare(strict_types=1);

namespace PBF\Infrastructure\IRC;

use PBF\Application\ModuleInterface;
use PBF\Domain\Bot\BotFactoryInterface;

class IRCModule implements ModuleInterface
{
    public function getBotFactory(): BotFactoryInterface
    {
        return new IRCBotFactory();
    }
}
