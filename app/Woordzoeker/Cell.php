<?php namespace Woordzoeker;

class Cell
{
    /** @var int */
    private $rowIndex;
    /** @var int */
    private $colIndex;
    /** @var string */
    public $value;

    /**
     * @param int $rowIndex
     * @param int $colIndex
     * @param string $value
     */
    public function __construct($rowIndex, $colIndex, $value = null)
    {
        $this->rowIndex = $rowIndex;
        $this->colIndex = $colIndex;
        $this->value = $value;
    }
}
