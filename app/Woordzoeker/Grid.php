<?php namespace Woordzoeker;

class Grid
{
    /** @var array */
    private $grid;
    /** @var int */
    private $rowCount;
    /** @var int */
    private $colCount;
    /** @var Line */
    private $rows;
    /** @var Line */
    private $cols;
    /** @var Line[] */
    private $diagonals;

    /**
     * @param int $rowCount
     * @param int $colCount
     */
    public function __construct($rowCount, $colCount)
    {
        $this->rowCount = $rowCount;
        $this->colCount = $colCount;
        $this->createGrid();
    }

    private function createGrid()
    {
        $this->grid = [];
        for ($r = 0; $r < $this->rowCount; $r++) {
            for ($c = 0; $c < $this->colCount; $c++) {
                $this->grid[$r][$c] = new Cell($r, $c);
            }
        }

        $this->setRows();
        $this->setCols();
        $this->setDiagonals();
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
        return $this->rows[$rowIndex];
    }

    /**
     * @param int $colIndex
     * @return \Woordzoeker\Line
     */
    public function getCol($colIndex)
    {
        return $this->cols[$colIndex];
    }

    /**
     * @return Line
     */
    public function getCols()
    {
        return $this->cols;
    }

    /**
     * @return Line
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @return \Woordzoeker\Line[]
     */
    public function getDiagonals()
    {
        return $this->diagonals;
    }

    /**
     * @return int
     */
    public function getWidth()
    {
        return $this->colCount;
    }

    /**
     * @return int
     */
    public function getHeight()
    {
        return $this->rowCount;
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

    public function setRows()
    {
        foreach ($this->grid as $i => $row) {
            $this->rows[$i] = new Line($row);;
        }
    }

    public function setCols()
    {
        $cols = [];
        foreach ($this->grid as $r => $row) {
            foreach ($row as $c => $cell) {
                $cols[$c][$r] = $cell;
            }
        }

        foreach ($cols as $line) {
            $this->cols[] = new Line($line);
        }
    }

    private function setDiagonals()
    {
        $this->diagonals = [];

        // top left to bottom right. min word length is 4.
        // top left moving down
        for ($i = 0; $i < $this->rowCount - 3; $i++) {
            $line = [];
            for ($r = $i, $c = 0; $r < $this->rowCount; $r++, $c++) {
                $line[] = $this->getCell($r, $c);
            }
            $this->diagonals[] = new Line($line);
        }
        // top left moving right
        for ($i = 1; $i < $this->colCount - 3; $i++) {
            $line = [];
            for ($c = $i, $r = 0; $c < $this->colCount; $r++, $c++) {
                $line[] = $this->getCell($r, $c);
            }
            $this->diagonals[] = new Line($line);
        }
        // top right to bottom left
        // top left moving right
        for ($i = 3; $i < $this->colCount - 1; $i++) {
            $line = [];
            for ($c = $i, $r = 0; $c >= 0; $r++, $c--) {
                $line[] = $this->getCell($r, $c);
            }
            $this->diagonals[] = new Line($line);
        }
        // top right moving down
        for ($i = 0; $i < $this->rowCount - 3; $i++) {
            $line = [];
            for ($r = $i, $c = $this->colCount - 1; $r < $this->rowCount; $r++, $c--) {
                $line[] = $this->getCell($r, $c);
            }
            $this->diagonals[] = new Line($line);
        }

    }

    /**
     * @param int $rowIndex
     * @param int $colIndex
     * @return Cell
     */
    private function getCell($rowIndex, $colIndex)
    {
        return $this->grid[$rowIndex][$colIndex];
    }
}
