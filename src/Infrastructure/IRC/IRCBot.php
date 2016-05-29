<?php
declare(strict_types=1);

namespace PBF\Infrastructure\IRC;

use PBF\Domain\Message\DefaultMessage;
use PBF\Infrastructure\Bot\CommandBot;
use PBF\Infrastructure\Stream\StringStream;

class IRCBot extends CommandBot
{
    /** @var string  */
    private $chan = "";

    /** @var string  */
    private $nick = "";

    /**
     * This method is executed once, it should initialize the bot
     *
     * @return void
     */
    public function start()
    {
        parent::start();

        if ("" !== $this->nick) {
            $this->getLogger()->info("[Bot] Using name {nick} with irc bot {bot_id}", [
                "nick" => $this->nick,
                "bot_id" => $this->getId()
            ]);

            $this->sendCommand(sprintf("NICK %s", $this->nick));
            $this->sendCommand(sprintf(
                "USER %s %s %s :%s",
                $this->nick,
                $this->nick."_",
                $this->nick."__",
                $this->nick
            ));
        }

        if ("" !== $this->chan) {
            $chan = 0 === strpos($this->chan, "#") ? $this->chan : "#".$this->chan;

            $this->getLogger()->info("[Bot] Joining chan {chan} with irc bot {bot_id}", [
                "chan" => $chan,
                "bot_id" => $this->getId(),
            ]);

            $this->sendCommand(sprintf("JOIN %s", $chan));
        }
    }

    /**
     * @param string $chan
     * @return IRCBot
     */
    public function setChan(string $chan): IRCBot
    {
        $this->chan = $chan;
        return $this;
    }

    /**
     * @param string $nick
     * @return IRCBot
     */
    public function setNick(string $nick): IRCBot
    {
        $this->nick = $nick;
        return $this;
    }

    protected function sendCommand(string $command)
    {
        $message = new DefaultMessage();
        $message->setContent(new StringStream($command));

        $this->getConnexion()->send($message);
    }
}
