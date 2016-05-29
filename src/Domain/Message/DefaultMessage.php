<?php
declare (strict_types=1);

namespace PBF\Domain\Message;

use PBF\Domain\Message\Exception\InvalidHeaderNameException;
use PBF\Domain\Stream\StreamInterface;

class DefaultMessage implements MessageInterface
{
    /** @var string[] */
    private $headers = [];

    /** @var StreamInterface */
    private $content;

    /**
     * Set the value of an header
     *
     * @param string $name
     * @param string $content
     * @return MessageInterface The Message object
     */
    public function setHeader(string $name, string $content): MessageInterface
    {
        $this->headers[$name] = $content;
        return $this;
    }

    /**
     * Checks if an header exists
     *
     * @param string $name
     * @return bool Whether the header exists or not
     */
    public function hasHeader(string $name): bool
    {
        return isset($this->headers[$name]);
    }

    /**
     * Get an header value
     *
     * @param string $name
     * @return string The header content
     * @throws \PBF\Domain\Message\Exception\InvalidHeaderNameException
     */
    public function getHeader(string $name): string
    {
        if (!$this->hasHeader($name)) {
            throw new InvalidHeaderNameException(sprintf("The header '%s' is not set", $name));
        }

        return $this->headers[$name];
    }

    /**
     * Remove an header
     *
     * @param string $name
     * @return bool Whether the header existed or not
     */
    public function removeHeader(string $name): bool
    {
        $headerExist = $this->hasHeader($name);
        unset($this->headers[$name]);

        return $headerExist;
    }

    /**
     * @param StreamInterface $content
     * @return MessageInterface The message object
     */
    public function setContent(StreamInterface $content): MessageInterface
    {
        $this->content = $content;
        return $this;
    }

    /**
     * @return StreamInterface The message content stream
     */
    public function getContent(): StreamInterface
    {
        return $this->content;
    }
}
