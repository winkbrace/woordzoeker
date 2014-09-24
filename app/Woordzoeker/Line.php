<?php namespace Woordzoeker;

class Line
{
    /** @var Cell[] */
    private $line;

    /**
     * @param Cell[] $line
     */
    public function __construct(array $line)
    {
        $this->line = $line;
    }
}
