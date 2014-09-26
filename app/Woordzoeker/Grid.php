<?php namespace Woordzoeker;

class Grid
{
    /** @var array */
    private $grid;
    /** @var int */
    private $rows;
    /** @var int */
    private $cols;

    /**
     * @param int $rows
     * @param int $cols
     */
    public function __construct($rows, $cols)
    {
        $this->rows = $rows;
        $this->cols = $cols;
        $this->createGrid();
    }

    private function createGrid()
    {
        $this->grid = [];
        for ($r = 0; $r < $this->rows; $r++) {
            for ($c = 0; $c < $this->cols; $c++) {
                $this->grid[$r][$c] = new Cell($r, $c);
            }
        }
    }

    /**
     * @return array
     */
    public function getGrid()
    {
        return $this->grid;
    }

    /**
     * @param int $rowIndex
     * @return \Woordzoeker\Line
     */
    public function getRow($rowIndex)
    {
        return new Line($this->grid[$rowIndex]);
    }

    /**
     * @param int $colIndex
     * @return \Woordzoeker\Line
     */
    public function getCol($colIndex)
    {
        $line = [];
        foreach ($this->grid as $row) {
            $line[] = $row[$colIndex];
        }

        return new Line($line);
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->cols;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->rows;
    }

    /**
     * @return Line
     */
    public function getRandomRow()
    {
        return new Line($this->grid[array_rand($this->grid)]);
    }

    /**
     * @return bool
     */
    public function isFilled()
    {
        foreach ($this->grid as $row) {
            foreach ($row as $cell) {
                if (empty($cell->value)) {
                    return false;
                }
            }
        }

        return true;
    }
}
