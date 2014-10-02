<?php namespace Woordzoeker;

class GridTest extends \PHPUnit_Framework_TestCase
{
    /** @var Grid */
    private $grid;

    public function setUp()
    {
        $this->grid = new Grid(5, 5);
    }

    public function testCreation()
    {
        $this->assertInstanceOf('\\Woordzoeker\\Grid', $this->grid);
        $grid = $this->grid->getGrid();
        $this->assertCount(5, $grid); // rows
        $this->assertCount(5, $grid[0]); // columns
    }

    public function testCreateNonSquare()
    {
        $grid = new Grid(5, 10);
        $this->assertCount(5, $grid->getRows());
        $this->assertCount(10, $grid->getColumns());
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateTooSmall()
    {
        new Grid(4, 5);
        $this->fail('Grid should throw exception when below 5 width or height');
    }

    /**
     * @expectedException \InvalidArgumentException
     */
    public function testCreateTooBig()
    {
        new Grid(10, 25);
        $this->fail('Grid should throw exception when above 20 width or height');
    }

    public function testRows()
    {
        $rows = $this->grid->getRows();
        $this->assertCount(5, $rows);
        $this->assertInstanceOf('\\Woordzoeker\\Line', $rows[0]);
        $this->assertEquals($rows[2], $this->grid->getRow(2));
    }

    public function testCols()
    {
        $cols = $this->grid->getColumns();
        $this->assertCount(5, $cols);
        $this->assertInstanceOf('\\Woordzoeker\\Line', $cols[0]);
        $this->assertEquals($cols[2], $this->grid->getCol(2));
    }

    public function testDiagonals()
    {
        $diagonals = $this->grid->getDiagonals();
        $this->assertCount(6, $diagonals);
        $this->assertInstanceOf('\\Woordzoeker\\Line', $diagonals[0]);
    }

    public function testGetRandomRow()
    {
        $grid = new Grid(6, 8);
        $row = $grid->getRandomRow();
        $this->assertEquals(8, $row->getLength()); // row = 6, col = 8
    }
}
