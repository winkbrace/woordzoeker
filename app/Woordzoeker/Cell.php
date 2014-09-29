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

    /**.
     * @return bool
     */
    public function hasLetter()
    {
        return ! empty($this->value);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return '[' . $this->rowIndex . '][' . $this->colIndex . '] => ' . $this->value;
    }
}
