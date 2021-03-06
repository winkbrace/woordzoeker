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
        foreach ($line as $cell) {
            if (! $cell instanceof Cell) {
                throw new \InvalidArgumentException('array of Cell objects required to create Line.');
            }
        }

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
     * @return Cell[]
     */
    public function getEmptyCells()
    {
        $cells = [];
        foreach ($this->line as $cell) {
            if (! $cell->hasLetter()) {
                $cells[] = $cell;
            }
        }

        return $cells;
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

    /**
     * @return int number of cells that have no letter yet
     */
    public function freeCellCount()
    {
        $count = 0;
        foreach ($this->line as $cell) {
            if (! $cell->hasLetter()) {
                $count++;
            }
        }

        return $count;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $output = '';
        foreach ($this->line as $cell) {
            $output .= $cell->__toString() . "\t";
        }

        return $output . " <br/>\n";
    }
}
