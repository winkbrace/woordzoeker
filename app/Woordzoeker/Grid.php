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
        if ($rowCount < 5 || $colCount < 5) {
            throw new \InvalidArgumentException('The grid needs to be at least 5 letters wide and high.');
        }
        if ($rowCount > 20 || $colCount > 20) {
            throw new \InvalidArgumentException('The grid cannot exceed 20 letters in width and height.');
        }

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
     * @return \Woordzoeker\Line[]
     */
    public function getColumns()
    {
        return $this->cols;
    }

    /**
     * @return \Woordzoeker\Line[]
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
     * @return Line[]
     */
    public function getAllLines()
    {
        $lines = [];
        foreach ($this->rows as $line) {
            $lines[] = $line;
        }
        foreach ($this->cols as $line) {
            $lines[] = $line;
        }
        foreach ($this->diagonals as $line) {
            $lines[] = $line;
        }
        return $lines;
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

    private function setRows()
    {
        foreach ($this->grid as $i => $row) {
            $this->rows[$i] = new Line($row);;
        }
    }

    private function setCols()
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
            $this->addToDiagonals($line);
        }
        // top left moving right
        for ($i = 1; $i < $this->colCount - 3; $i++) {
            $line = [];
            for ($c = $i, $r = 0; $c < $this->colCount; $r++, $c++) {
                $line[] = $this->getCell($r, $c);
            }
            $this->addToDiagonals($line);
        }
        // top right to bottom left
        // top left moving right
        for ($i = 3; $i < $this->colCount - 1; $i++) {
            $line = [];
            for ($c = $i, $r = 0; $c >= 0; $r++, $c--) {
                $line[] = $this->getCell($r, $c);
            }
            $this->addToDiagonals($line);
        }
        // top right moving down
        for ($i = 0; $i < $this->rowCount - 3; $i++) {
            $line = [];
            for ($r = $i, $c = $this->colCount - 1; $r < $this->rowCount; $r++, $c--) {
                $line[] = $this->getCell($r, $c);
            }
            $this->addToDiagonals($line);
        }
    }

    /**
     * @param Cell[] $cells
     */
    private function addToDiagonals(array $cells)
    {
        $cells = array_filter($cells);
        if (count($cells) >= 4) {
            $this->diagonals[] = new Line($cells);
        }
    }

    /**
     * @param int $rowIndex
     * @param int $colIndex
     * @return Cell
     */
    private function getCell($rowIndex, $colIndex)
    {
        if (! isset($this->grid[$rowIndex]) || ! isset($this->grid[$rowIndex][$colIndex])) {
            return null;
        }

        return $this->grid[$rowIndex][$colIndex];
    }
}
