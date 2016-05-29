<?php
declare(strict_types=1);

namespace PBF\Domain\Stream;

interface StreamInterface
{
    /**
     * Read all the stream content
     *
     * @param int $offset
     * @return string
     */
    public function readAll(int $offset = 0): string;

    /**
     * Alias of $this->readAll()
     *
     * @return mixed
     */
    public function __toString();
}
