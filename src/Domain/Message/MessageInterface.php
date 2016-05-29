<?php
declare (strict_types=1);

namespace PBF\Domain\Message;

use PBF\Domain\Stream\StreamInterface;

interface MessageInterface
{
    /**
     * Set the value of an header
     *
     * @param string $name
     * @param string $content
     * @return MessageInterface The message object
     */
    public function setHeader(string $name, string $content): MessageInterface;

    /**
     * Checks if an header exists
     *
     * @param string $name
     * @return bool Whether the header exists or not
     */
    public function hasHeader(string $name): bool;

    /**
     * Get an header value
     *
     * @param string $name
     * @return string The header content
     * @throws \PBF\Domain\Message\Exception\InvalidHeaderNameException
     */
    public function getHeader(string $name): string;

    /**
     * Remove an header
     *
     * @param string $name
     * @return bool Whether the header existed or not
     */
    public function removeHeader(string $name): bool;

    /**
     * @param StreamInterface $content
     * @return MessageInterface The message object
     */
    public function setContent(StreamInterface $content): MessageInterface;

    /**
     * @return StreamInterface The message content stream
     */
    public function getContent(): StreamInterface;
}
