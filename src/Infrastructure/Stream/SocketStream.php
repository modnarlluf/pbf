<?php
declare(strict_types=1);

namespace PBF\Infrastructure\Stream;

use PBF\Domain\Stream\StreamInterface;

class SocketStream implements StreamInterface
{
    private $resource;

    /**
     * @param resource $resource
     */
    public function __construct($resource)
    {
        $this->resource = $resource;
    }

    /**
     * Read all the stream content
     *
     * @param int $offset
     * @return string
     */
    public function readAll(int $offset = 0): string
    {
        $buffer = "";

        while ("" !== $chunk = \socket_read($this->resource, -1, $offset)) {
            $buffer .= $chunk;
        }

        return $buffer;
    }

    /**
     * Alias of $this->readAll()
     *
     * @return mixed
     */
    public function __toString()
    {
        return $this->readAll();
    }
}
