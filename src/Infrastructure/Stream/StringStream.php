<?php
declare(strict_types=1);

namespace PBF\Infrastructure\Stream;

use PBF\Domain\Stream\StreamInterface;

class StringStream implements StreamInterface
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    /**
     * Read all the stream content
     *
     * @param int $offset
     * @return string
     */
    public function readAll(int $offset = 0): string
    {
        return substr($this->string, $offset);
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
