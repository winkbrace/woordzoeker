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

    /**
     * @return Cell[]
     */
    public function getAllCells()
    {
        return $this->line;
    }

    /**
     * @param int $index
     * @return \Woordzoeker\Cell
     */
    public function getCellAt($index)
    {
        if (! array_key_exists($index, $this->line)) {
            throw new \InvalidArgumentException('Invalid index provided to get cell in line');
        }

        return $this->line[$index];
    }

    /**
     * @return int
     */
    public function getLength()
    {
        return count($this->line);
    }

    /**
     * reverse the cells in the line
     * This is the easiest way to handle reversed words
     */
    public function reverse()
    {
        $this->line = array_reverse($this->line);
    }
}
